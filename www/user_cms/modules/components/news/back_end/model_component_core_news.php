<?php 

class model_component_core_news extends model {
	
	public function get_news($id = 0, $params = array()) {
	
		$sql = "";
		
		if(isset($params['join']) && $params['join'] == 'category_name') {
			$sql .= "SELECT i.*, c.name AS cat_name FROM news_items i LEFT JOIN news_categories c ON c.id = i.category_id ";
		} else {
			$sql .= "SELECT * FROM news_items i ";
		}
		
		if(isset($params['type'])) {
			if($params['type'] = 'by_category') {
				$sql .= " WHERE i.category_id = '" . (int)$id . "'";
			} elseif($params['type'] = 'by_id') {
				$sql .= " WHERE i.id = '" . (int)$id . "'";
			}
		}
		
		if(isset($params['sort'])) {
			$sql .= " ORDER BY " . $params['sort'] . " ";
		} else {
			$sql .= " ORDER BY i.id DESC ";
		}
		
		if(isset($params['limit'])) {
			$sql .= " LIMIT " . $params['limit'] . " ";
		}
		return $this->dbh->query($sql);
	}
	
	public function get_news_item($id) {
		return $this->dbh->row("SELECT * FROM news_items WHERE id = '" . (int)$id . "' LIMIT 1");
	}
	
	public function add_news_item($data = array()) {
		$sql = "INSERT INTO news_items (category_id, name, text, preview, title, keywords, description, url, date_add, date_edit, date)
							VALUES ('" . (int)$data['category_id'] . "', 
									'" . $this->dbh->escape($data['name']) . "', 
									'" . $this->dbh->escape($data['text']) . "', 
									'" . $this->dbh->escape($data['preview']) . "', 
									'" . $this->dbh->escape($data['title']) . "', 
									'" . $this->dbh->escape($data['keywords']) . "', 
									'" . $this->dbh->escape($data['description']) . "', 
									'" . $this->dbh->escape($data['url']) . "', 
									'" . (int)$data['date_add'] . "', 
									'" . (int)$data['date_edit'] . "',
									'" . (int)$data['date'] . "')";
									
		$this->dbh->exec($sql);
		return $this->dbh->lastInsertId();
	}
	
	public function edit_news_item($data = array()) {
		$sql = "UPDATE news_items SET 
					category_id = '" . (int)$data['category_id'] . "',
					name = '" . $this->dbh->escape($data['name']) . "',
					text = '" . $this->dbh->escape($data['text']) . "',
					preview = '" . $this->dbh->escape($data['preview']) . "',
					title = '" . $this->dbh->escape($data['title']) . "',
					keywords = '" . $this->dbh->escape($data['keywords']) . "',
					description = '" . $this->dbh->escape($data['description']) . "',
					url = '" . $this->dbh->escape($data['url']) . "',
					date_add = '" . (int)$data['date_add'] . "',
					date_edit = '" . (int)$data['date_edit'] . "',
					date = '" . (int)$data['date'] . "'
				WHERE id = '" . (int)$data['id'] . "'";
		$this->dbh->exec($sql);
		return false;
	}
	
	public function delete_news_item($id) {
		return $this->dbh->exec("DELETE FROM news_items WHERE id = '" . (int)$id . "'");
	}

	public function get_categories() {
		return $this->dbh->query("SELECT * FROM news_categories ORDER BY date_add DESC");
	}
	
	public function get_total_news($category_id = 0) {
		$sql = "SELECT COUNT(*) AS count FROM news_items ";
		
		if($category_id) {
			$sql .= "WHERE category_id = '" . (int)$category_id . "'";
		}
		
		$result = $this->dbh->row($sql);
		
		return (int)$result['count'];
	}

	public function get_category($id) {
		return $this->dbh->row("SELECT * FROM news_categories WHERE id = '" . (int)$id . "' LIMIT 1");
	}
		
	public function add_category($data) {
		$sql = "INSERT INTO news_categories (name, text, sub, preview, title, keywords, description, url, date_add, date_edit, date)
							VALUES ('" . $this->dbh->escape($data['name']) . "', 
									'" . $this->dbh->escape($data['text']) . "', 
									'" . $this->dbh->escape($data['parent_category']) . "', 
									'" . $this->dbh->escape($data['preview']) . "', 
									'" . $this->dbh->escape($data['title']) . "', 
									'" . $this->dbh->escape($data['keywords']) . "', 
									'" . $this->dbh->escape($data['description']) . "', 
									'" . $this->dbh->escape($data['url']) . "', 
									'" . (int)$data['date_add'] . "', 
									'" . (int)$data['date_edit'] . "',
									'" . (int)$data['date'] . "')";
									
		$this->dbh->exec($sql);
		return $this->dbh->lastInsertId();
	}
	
	public function edit_category($data) {
		$sql = "UPDATE news_categories SET 
					name = '" . $this->dbh->escape($data['name']) . "',
					text = '" . $this->dbh->escape($data['text']) . "',
					sub = '" . $this->dbh->escape($data['parent_category']) . "',
					preview = '" . $this->dbh->escape($data['preview']) . "',
					title = '" . $this->dbh->escape($data['title']) . "',
					keywords = '" . $this->dbh->escape($data['keywords']) . "',
					description = '" . $this->dbh->escape($data['description']) . "',
					url = '" . $this->dbh->escape($data['url']) . "',
					date_add = '" . (int)$data['date_add'] . "',
					date_edit = '" . (int)$data['date_edit'] . "',
					date = '" . (int)$data['date'] . "'
				WHERE id = '" . (int)$data['id'] . "'";
		return $this->dbh->exec($sql);
	}
		
	public function delete_category($id) {
		foreach($this->get_news($id, array('type'=>'by_category')) as $news_item) {
			$this->delete_news_item($news_item['id']);
		}
		return $this->dbh->exec("DELETE FROM news_categories WHERE id = '" . (int)$id . "'");
	}
	
	public function get_config() {
		return array(
			'substr_preview' => 1,
			'preview_count'  => 300,
			'items_per_page' => 25
		);
	}
	
}