<?php 

class model_component_core_news extends model {
	
	public function get_component_info($component) {
		return $this->dbh->row("SELECT * FROM main WHERE component = '" . $this->dbh->escape($component) . "' LIMIT 1");
	}
	
	public function get_news($data, $params = array()) {

		$sql = "";
		
		if(isset($params['join'])) {
			if($params['join'] == 'category_name') {
				$sql .= "SELECT i.*, c.name AS cat_name FROM news_items i LEFT JOIN news_categories c ON c.id = i.category_id WHERE i.date <= '".time()."' AND c.date <= '".time()."'";
			} elseif ($params['join'] == 'category_url') {
				$sql .= "SELECT i.*, c.url AS cat_url FROM news_items i LEFT JOIN news_categories c ON c.id = i.category_id WHERE i.date <= '".time()."' AND c.date <= '".time()."'"; //
			} else {
				$sql .= "SELECT * FROM news_items i WHERE i.date <= '".time()."'";
			}
		} else {
			$sql .= "SELECT * FROM news_items i WHERE i.date <= '".time()."'"; //cat
		}
		
		if(isset($params['type'])) {
			if($params['type'] == 'by_category') {
				$sql .= " AND i.category_id = '" . (int)$data . "'";
			} elseif($params['type'] == 'by_url') {
				$sql .= " AND i.url = '" . $this->dbh->escape($data) . "'";
			} elseif($params['type'] == 'by_id') {
				$sql .= " AND i.id = '" . (int)$data . "'";
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
		//print_r($sql);
		return $this->dbh->query($sql);
	}
	
	public function get_news_item($data, $params) {
		$params['limit'] = 1;
		$result = $this->get_news($data, $params);
		if($result){
			return $result[0];
		}
		return array();
	}
		
	public function get_categories($data, $params = array()) {
		
		if(isset($params['join'])) {
			if($params['join'] == 'count_news') {
				$sql = "SELECT c.*, COUNT(i.id) AS count_news FROM news_categories c LEFT JOIN news_items i ON c.id = i.category_id WHERE c.date <= '".time()."'";
			} else {
				$sql = "SELECT * FROM news_categories c WHERE c.date <= '".time()."'";
			}
		} else {
			$sql = "SELECT * FROM news_categories c WHERE c.date <= '".time()."'";
		}
		
		if(isset($params['type'])) {
			if($params['type']=='by_url') {
				$sql .= " AND c.url = '" . $this->dbh->escape($data) . "'";
			}
		} else {
			$sql .= " AND c.id = '" . (int)$data . "'";
		}
		
		if(isset($params['sort'])) {
			$sql .= " ORDER BY " . $params['sort'] . " ";
		} else {
			$sql .= " ORDER BY c.id ASC ";
		}
		
		if(isset($params['limit'])) {
			$sql .= " LIMIT " . $params['limit'] . " ";
		}
		return $this->dbh->query($sql);
	}
	
	public function get_category($data, $params = array()) {
		$params['limit'] = 1;
		$result = $this->get_categories($data, $params);
		if($result){
			return $result[0];
		}
		return array();
	}
	
	public function get_category_full_url($category_id){
		$urls = array();
		$names = array();
		$cat_id = $category_id;
		$doned = array();
		while ($cat_id > 0) {
			if (isset($doned[$cat_id])) {
				return FALSE;
			}
			$doned[$cat_id] = 1;
			
			$next_category = $this->dbh->query("SELECT * FROM news_categories WHERE id=" . $cat_id . " LIMIT 1");
			if ($next_category) $next_category = $next_category[0];
			//$url = '/' . $next_category['url'] . $url; // $url = '/.../.../...';
			$urls[] = $next_category['url']; // $url = '/.../.../...';
			$names[] = $next_category['name'];
			$cat_id = $next_category['sub'];
			
		}
		return array('urls'=>$urls, 'names'=>$names);
	}
	
	public function get_count_news($category_id){
		return $this->dbh->query("SELECT COUNT(id) AS count_news FROM news_items WHERE category_id='$category_id' AND date <= '".time()."'");
	}
	
}