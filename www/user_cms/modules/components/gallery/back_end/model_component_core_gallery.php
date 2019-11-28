<?php 


class model_component_core_gallery extends model {

	public function req_cats($sub, $step){
		//print_r($this->mycs);
		$this->mycs[] = array('id'=>$sub, 'step'=>$step);
		if (!empty($this->cats[$sub])) foreach ($this->cats[$sub] as $cat){
			$this->req_cats($cat, $step+1);
		}
	}

	public function sort_cats($categories){
		$newcats = array();
		if (!empty($categories)) { 
			foreach ($categories as $category){
				$tmp[$category['id']] = $category;
			}
			$categories = $tmp;
			unset($tmp);
			$cats = array();
			foreach ($categories as $category){
				$cats[$category['sub']][] = $category['id'];
			}
			$this->mycs = array();//$cats;
			$this->cats = $cats;
			$this->req_cats(0, -1);
			unset($this->mycs[0]);
			$i=0;
			//print_r($this->mycs);
			foreach ($this->mycs as $v) {$newcats[$i] = $categories[$v['id']]; $newcats[$i]['step'] = $v['step']; $i++;}
			unset($this->mycs);
			unset($this->cats);
			//print_r ($newcats);
		}
		return ($newcats);
	}

	public function get_categories() {
		$sql = "SELECT c.*, COUNT(i.id) AS count_items FROM gallery_categories c LEFT JOIN gallery_items i ON i.category_id = c.id GROUP BY c.id ORDER BY c.id DESC";
		return $this->dbh->query($sql);
	}
	
	public function get_category($id) {
		$sql = "SELECT * FROM gallery_categories WHERE id = '" . (int)$id . "'";
		return $this->dbh->row($sql);
	}
	
	public function get_category_by_item_id($id) {
		$sql = "SELECT * FROM gallery_categories WHERE id = (SELECT category_id FROM gallery_items WHERE id = '" . (int)$id . "')";
		return $this->dbh->row($sql);
	}
	
	public function get_category_by_url($url) {
		$sql = "SELECT * FROM gallery_categories WHERE url = '" . $this->dbh->escape($url) . "'";
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
	
	public function add_item($data) {
		$sql = '';
		if(!is_array($data['image'])) {
			$sql = "INSERT INTO gallery_items (category_id, image, text, date_add) VALUES (
						'" . (int)$data['category_id'] . "', '" . $this->dbh->escape($data['image']) . "', '" . $this->dbh->escape($data['text']) . "', '" . time() . "'
					)";
		} else {
			foreach ($data['image'] as $key => $value) {
				$sql .= "INSERT INTO gallery_items (category_id, image, text, date_add) VALUES (
							'" . (int)$data['category_id'] . "', '" . $this->dbh->escape($data['image'][$key]) . "', '" . $this->dbh->escape($data['text']) . "', '" . time() . "'
						);";
			}
		}
		return $this->dbh->exec($sql);
	}
	
	public function edit_item($data) {
		$sql = "UPDATE gallery_items SET 
					category_id = '" . (int)$data['category_id'] . "',
					text = '" . $this->dbh->escape($data['text']) . "'
				WHERE id = '" . (int)$data['id'] . "'
		";
		return $this->dbh->exec($sql);
	}

	public function get_parents($category_id=0){
		$sql = "SELECT * FROM gallery_categories WHERE id<>'".(int)$category_id."'";
		return $this->dbh->query($sql);
	}
	
	public function add_category($data) {
		
		$sql = "INSERT INTO gallery_categories (name, text, preview, image, url, title, keywords, description, dir, sub) VALUES (
					'" . $this->dbh->escape($data['name']) . "',
					'" . $this->dbh->escape($data['text']) . "',
					'" . $this->dbh->escape($data['preview']) . "',
					'" . $this->dbh->escape($data['image']) . "',
					'" . $this->dbh->escape($data['url']) . "',
					'" . $this->dbh->escape($data['title']) . "',
					'" . $this->dbh->escape($data['keywords']) . "',
					'" . $this->dbh->escape($data['description']) . "',
					'" . $this->dbh->escape($data['dir']) . "',
					'" . $this->dbh->escape($data['parent']) . "'
		)";
		
		$this->dbh->exec($sql);
		return $this->dbh->lastInsertId();
	}
	
	public function edit_category($data) {
		if($data['new_image']) {
			$category_info = $this->get_category($data['id']);
			$this->delete_image($category_info['image'], $category_info['dir']);
			$data['image'] = $data['new_image'];
		}
		$sql = "UPDATE gallery_categories SET
					name = '" . $this->dbh->escape($data['name']) . "',
					text = '" . $this->dbh->escape($data['text']) . "',
					preview = '" . $this->dbh->escape($data['preview']) . "',
					image = '" . $this->dbh->escape($data['image']) . "',
					url = '" . $this->dbh->escape($data['url']) . "',
					title = '" . $this->dbh->escape($data['title']) . "',
					keywords = '" . $this->dbh->escape($data['keywords']) . "',
					description = '" . $this->dbh->escape($data['description']) . "',
					sub = '" . $this->dbh->escape($data['parent']) . "'
				WHERE id = '" . (int)$data['id'] . "'";
		
		return $this->dbh->exec($sql);
	}
	
	public function delete_image($image, $category_dir = '') {
		if(!$category_dir) {
			$sql = "SELECT i.*, c.dir  FROM gallery_items i 
						LEFT JOIN gallery_categories c ON i.category_id = c.id
						WHERE i.image = '" . $this->dbh->escape($image) . "' 
						GROUP BY i.image";
			$result = $this->dbh->row($sql);
			if(!$result) {
				return 0;
			}
			$category_dir = $result['dir'];
		}
		$count_deleted = 0;
		if(file_exists(ROOT_DIR . '/uploads/modules/gallery/' . $category_dir . '/' . $image)) {
			@unlink(ROOT_DIR . '/uploads/modules/gallery/' . $category_dir . '/' . $image);
			$count_deleted++;
		}
		if(file_exists(ROOT_DIR . '/uploads/modules/gallery/' . $category_dir . '/mini/' . $image)) {
			@unlink(ROOT_DIR . '/uploads/modules/gallery/' . $category_dir . '/mini/' . $image);
			$count_deleted++;
		}
		return $count_deleted;
	}
	
	public function delete_item($id) {
		$result = $this->dbh->row("SELECT * FROM gallery_items WHERE id = '" . (int)$id . "'");
		$this->delete_image($result['image']);
		return $this->dbh->exec("DELETE FROM gallery_items WHERE id = '" . (int)$id . "'");
	}
	
	public function delete_category($id) {
		$category_info = $this->get_category($id);
		$results = $this->get_items($id);
		foreach($results as $result) {
			$this->delete_item($result['id']);
		}
		@rmdir(ROOT_DIR . '/uploads/modules/gallery/' . $category_info['dir']);
		return $this->dbh->query("DELETE FROM gallery_categories WHERE id = '" . (int)$id . "'");
	}
	public function save_order(){
		
		foreach ($_POST as $key => $value) {
			if (mb_strpos($key, 'order_') !== false) {
				$id = str_replace('order_', '', $key);
				$r =$this->dbh->exec("UPDATE gallery_items SET sort = '".$value."' WHERE id = '".$id ."';");
				if(!$r[0]) {return 'Ошибки при сохранении';}
			}

		}
		if ($r[0]) {
			return 'Сортировка сохранена';
		}
		else {
			return 'Ошибки при сохранении';
		}


	}
	
	
}
