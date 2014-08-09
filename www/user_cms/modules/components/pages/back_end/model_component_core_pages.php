<?php 
/*
* main component's model
*/
class model_component_core_pages extends model {
	
	public function get_page($main_id = 0){
		$sql = "SELECT m.* , p.text, p.id AS page_id FROM main m LEFT JOIN pages p ON p.main_id = m.id WHERE m.id = '" . (int)$main_id . "' LIMIT 1";
		return $this->dbh->row($sql);
	}
	
	/*
	* возвращает дочерние страницы 1го уровня вложенности
	* params:
	*   children_count - join column with count of children / добавляет к выборке столбец с количеством дочерних страниц
	*   content - join `pages` table with page content / добавляет к выборке таблицу `pages` с контентом
	*   sort - set 'sort by' value / указывает порядок сортировки
	*
	*/
	public function get_pages_by_parent_id($parent_id = 0, $params = array()){
	
		$sql = '';
		
		if(isset($params['children_count']) && $params['children_count'] === true){
			$sql .= "SELECT m.*, COUNT(m2.id) AS children_count FROM main m LEFT JOIN main m2 ON m2.parent_id = m.id ";
		} else {
			$sql .= "SELECT * FROM main m ";
		}
		
		if(isset($params['content']) && $params['content'] === true){
			$sql .= "LEFT JOIN pages p ON p.main_id = m.id ";
		}
		
		$sql .= "WHERE m.parent_id = '" . (int)$parent_id . "' AND m.component = 'pages'  GROUP BY m.id ";
		
		if(isset($params['sort'])){
			$sql .= "ORDER BY " . $params['sort'] . " ";
		} else {
			$sql .= "ORDER BY m.id DESC";
		}
		return $this->dbh->query($sql);
	}
	
	/*
	* возвращает дерево\список всех дочерних страниц любого уровня вложенности
	*	
	*
	*/
	public function get_pages($parent_id = 0, $params = array()){
		$sql = "SELECT * FROM main m ";
		if(isset($params['content']) && $params['content'] === true){ // if true add content from page table
			$sql .= " LEFT JOIN pages p ON p.main_id = m.id";
		}
		$sql .= " WHERE m.component = 'pages'";
		if(isset($params['type']) && $params['type'] == 'tree') { // return multidimensional array with children, else return simple list
			$sql .= " AND m.parent_id = '" . (int)$parent_id . "' ";
		}
		if(isset($params['sort'])){
			$sql .= " ORDER BY " . $params['sort'] . " ";
		} else {
			$sql .= " ORDER BY m.id DESC";
		}
		
		$retval = array();
		$results = $this->dbh->query($sql);
		
		foreach($results as $result){
			$retval[ $result['id'] ] = $result;
			if(isset($params['type']) && $params['type'] == 'tree') {
				$retval[ $result['id'] ]['children'] = $this->get_pages($result['id'], $params);
			}
		}
		return $retval;
	}
	/*
		удаление страницы.
		(bool) recursive - удаление дочерних страниц
	*/
	public function delete_page($page_id = 0, $recursive = false){
		//$page = $this->dbh->row("SELECT * FROM pages WHERE main_id = '" . (int)$page_id . "'");
		$sql = "DELETE FROM pages WHERE main_id = '" . (int)$page_id . "';";
		$sql .= "DELETE FROM main WHERE id = '" . (int)$page_id . "'";
		
		if($recursive) {
			$children = $this->get_pages_by_parent_id($page_id);
			foreach($children as $child) {
				$this->delete_page($child['id'], true);
			}
		}
		return $this->dbh->exec($sql);
	}
	
	public function add_page($data = array()){
		$sql = "INSERT INTO main (name, title, keywords, description, component, url, view, theme_view, date_add, parent_id)
					VALUES(
					'" . $this->dbh->escape($data['name']) . "',
					'" . $this->dbh->escape($data['title']) . "',
					'" . $this->dbh->escape($data['keywords']) . "',
					'" . $this->dbh->escape($data['description']) . "',
					'pages',
					'" . $this->dbh->escape($data['url']) . "',
					'" . $this->dbh->escape($data['page_view']) . "',
					'" . $this->dbh->escape($data['theme_view']) . "',
					'" . time() . "',
					'" . (int)$data['parent_id'] . "'
					)";
					
		$this->dbh->query($sql);
		
		$page_main_id = $this->dbh->lastInsertId();
		$sql = "INSERT INTO pages (main_id, text)
					VALUES(
					'" . $page_main_id . "',
					'" . $this->dbh->escape($data['text']) . "'
					)";
					
		$this->dbh->query($sql);
		
		return $page_main_id;
	}
	
	public function edit_page($data = array()){
		$sql = "UPDATE main SET 
					name        = '" . $this->dbh->escape($data['name']) . "',
					title       = '" . $this->dbh->escape($data['title']) . "',
					keywords    = '" . $this->dbh->escape($data['keywords']) . "',
					description = '" . $this->dbh->escape($data['description']) . "',
					component   = 'pages',
					url         = '" . $this->dbh->escape($data['url']) . "',
					view        = '" . $this->dbh->escape($data['page_view']) . "',
					theme_view  = '" . $this->dbh->escape($data['theme_view']) . "',
					parent_id   = '" . (int)$data['parent_id'] . "',
					date_edit   = '" . time() . "'
				WHERE id = '" . (int)$data['id'] . "'";
				
		$this->dbh->query($sql);
		
		$sql = "UPDATE pages SET text = '" . $this->dbh->escape($data['text']) . "' WHERE main_id = '" . (int)$data['id'] . "'";
				
		$this->dbh->query($sql);
	}
	/*
		возвращает строку с урлом страницы
	*/
	public function get_page_url($page_id, $url = '') {
		$sql = "SELECT parent_id, url FROM main WHERE id = '" . (int)$page_id . "'";
		$page = $this->dbh->row($sql);
		if (!$page) {
			return null;
		}
		$url = '/' . $page['url'] . $url;
		if($page['parent_id'] == 0) {
			return str_replace('//', '/', $url);
		} else {
			return $this->get_page_url($page['parent_id'], $url);
		}
	}
	
	/*
		метод для проверки существования урла.
		id - идентификатор страницы, которая исключается их проверки
	*/
	public function url_exists($url, $id = null) {
		$sql = "SELECT * FROM main WHERE url = '" . $this->dbh->escape($url) . "'";
		if($id) {
			$sql .= " AND id != '" . (int)$id . "'";
		}
		if($this->dbh->query_count($sql) > 0) {
			return true;
		}
		return false;
	}
	
	/*
		метод для преобразования урла
	*/
	public function url_modify($url, $id = null, $i = 2) {
		if($this->url_exists(rtrim($url, "0..9") . $i, $id)) {
			$this->url_modify($url, $id, $i++);
		}
		return $url . $i;
	}
	
	public function get_views($path) {
		$views = array();
		
		if (!is_dir($path)) {
			return $views;
		}
		
		$files = array_values(array_diff(scandir($path), array('.', '..')));
		foreach ($files as $file) {
			if (is_file($path . '/' . $file) && is_readable($path . '/' . $file)) {
				$info = pathinfo($path . '/' . $file);
				if (isset($info['extension']) && $info['extension'] == 'tpl') {
					$views[] = $info['filename'];
				}
			}
		}
		return $views;
	}
}