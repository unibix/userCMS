<?php 
/*
* main component's model
*/
class model_component_core_pages extends model {
	
	public function get_page($url, $parent_id = 0){
		$sql = "SELECT * FROM main m LEFT JOIN pages p ON p.main_id = m.id WHERE m.url = '" . $this->dbh->escape($url) . "' AND m.component = 'pages' AND m.parent_id = '" . (int)$parent_id . "' LIMIT 1";
		return $this->dbh->row($sql);
	}	
	
	/*
	* возвращает содержимое таблицы main
	*
	*/
	public function get_main_info($url, $parent_id = 0){
		$sql = "SELECT * FROM main m WHERE m.url = '" . $this->dbh->escape($url) . "' AND m.component = 'pages' AND m.parent_id = '" . (int)$parent_id . "' LIMIT 1";
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
}