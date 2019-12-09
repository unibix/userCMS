<?php 

class controller_plugin_core_gallery_box extends plugin {
	
	function action_index($plugin) {
		
		$category_id = $this->run_params;
		$this->data['items'] = $this->get_images((int)$category_id);
		//core::print_r($this->data['items']);
		$category = $this->get_category_by_id((int)$category_id);
		//core::print_r($category);
		$this->data['category_dir'] = $category['dir'];
				
		$this->page['html'] = $this->load_view();
		return $this->page;
	}
	
	function get_images($category_id=0) {
		$sql = "SELECT * FROM gallery_items ";
		if($category_id != 0) {
			$sql .=" WHERE category_id = '" . (int)$category_id . "'";
		}
		$sql .= " ORDER BY date_add DESC";
		return $this->dbh->query($sql);
		
	}
	function get_category_by_id($category_id=0) {
		$sql = "SELECT * FROM gallery_categories ";
		if($category_id != 0) {
			$sql .=" WHERE id = '" . (int)$category_id . "'";
		}
		$sql .= " LIMIT 1";
		return $this->dbh->row($sql);
		
	}
	

} 