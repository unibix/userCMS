<?php 
/*
* main component's model
*/
class model_component_core_gallery extends model {

	public function get_component_info($component) {
		return $this->dbh->row("SELECT * FROM main WHERE component = '" . $this->dbh->escape($component) . "' LIMIT 1");
	}
	
	public function get_categories($sub=0) {
		$sql = "SELECT c.*, COUNT(i.id) AS count_items FROM gallery_categories c LEFT JOIN gallery_items i ON i.category_id = c.id WHERE c.sub=".$sub." GROUP BY c.id ORDER BY c.id DESC";
		return $this->dbh->query($sql);
	}
	
	public function get_category($id) {
		$sql = "SELECT * FROM gallery_categories WHERE id = '" . (int)$id . "'";
		return $this->dbh->row($sql);
	}
	
	public function get_category_by_url($url) {
		$sql = "SELECT * FROM gallery_categories WHERE url = '" . $this->dbh->escape($url) . "'";
		return $this->dbh->row($sql);
	}
	
	public function get_category_by_item_id($id) {
		$sql = "SELECT * FROM gallery_categories WHERE id = (SELECT category_id FROM gallery_items WHERE id = '" . (int)$id . "')";
		return $this->dbh->row($sql);
	}
	
	
	public function get_items($category_id) {
		$sql = "SELECT * FROM gallery_items ";
		if($category_id) {
			$sql .=" WHERE category_id = '" . (int)$category_id . "'";
		}
		$sql .= " ORDER BY sort, date_add DESC";
		return $this->dbh->query($sql);
	}
	
	public function get_item($id) {
		return $this->dbh-row("SELECT * FROM gallery_items WHERE id = '" . (int)$id . "' LIMIT 1");
	}
}
