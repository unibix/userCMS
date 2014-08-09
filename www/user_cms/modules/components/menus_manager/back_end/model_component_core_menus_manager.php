<?php 
/*
* main component's model
*/

class model_component_core_menus_manager extends model {

	/*
		
	*/
	public function get_menus_list() {
		return $this->dbh->query("SELECT m.*, COUNT(i.id) AS count FROM menus m LEFT JOIN menus_items i ON m.id = i.menu_id GROUP BY m.id");
	}
	
	public function get_menu($menu_id = 0) {
		return $this->dbh->row("SELECT * FROM menus WHERE id = '" . (int)$menu_id . "' LIMIT 1");
	}
	
	public function add_menu($data = array()) {
		$sql = "INSERT INTO menus (name, class)
							VALUES ('" . $this->dbh->escape($data['name']) . "', '" . $this->dbh->escape($data['class']) . "')";
		$this->dbh->exec($sql);
		return $this->dbh->lastInsertId();
	}
	
	public function edit_menu($data = array()) {
		$sql = "UPDATE menus SET 
					name = '" . $this->dbh->escape($data['name']) . "',
					class = '" . $this->dbh->escape($data['class']) . "'
				WHERE id = '" . (int)$data['id'] . "'";
		return $this->dbh->exec($sql);
	}
	
	public function delete_menu($menu_id = 0) {
		return $this->dbh->exec("DELETE FROM menus WHERE id = '" . (int)$menu_id . "'");
	}
	
	public function get_menu_item($item_id = 0) {
		return $this->dbh->row("SELECT * FROM menus_items WHERE id = '" . (int)$item_id . "' LIMIT 1");
	}
	
	public function get_menu_items($menu_id = 0, $params = array()) {
		$sql = "SELECT * FROM menus_items WHERE menu_id = '" . (int)$menu_id . "'";
		
		if(isset($params['parent_id'])) {
			$sql .= " AND parent_id = '" . (int)$params['parent_id'] . "'";
		}
		
		if(isset($params['sort'])) {
			$sql .= " ORDER BY " . $params['sort'] . " ";
		} else {
			$sql .= " ORDER BY menu_id DESC ";
		}
		
		if(isset($params['tree']) && $params['tree']===true) {
			$items = $this->dbh->query($sql);
			foreach($items as $i => $item) {
				$params['parent_id'] = $item['id'];
				$items[$i]['children'] = $this->get_menu_items($menu_id, $params);
			}
			return $items;
		}
		
		return $this->dbh->query($sql);
	}
	
	public function get_items_list($menu_id, $parent_id = 0, $modify = true, $data = array(), $exception_id = 0) {
		$results = $this->get_menu_items($menu_id, array('parent_id' => $parent_id, 'sort' => 'sort ASC'));
		
		foreach($results as &$result) {
			if((int)$parent_id !== 0) {
				if($modify) {
					$result['name'] = $data[$parent_id]['name'] . ' &rsaquo; ' . $result['name'];
				}
			}
			
			if ($exception_id != $result['id']) {
				$data[$result['id']] = $result;
				$data = $this->get_items_list($menu_id, $result['id'], $modify, $data, $exception_id);
			}
		}
		
		return $data;
	}
	
	public function add_menu_item($data = array()) {
		$items = $this->dbh->query("SELECT * FROM menus_items WHERE menu_id = '" . (int)$data['menu_id'] . "' AND parent_id = '" . (int)$data['parent_id'] . "' ORDER BY sort DESC LIMIT 1");

		if ($items) {
			$data['sort'] = $items[0]['sort'] + 1;
		} else {
			$data['sort'] = 1;
		}
		
		$sql = "INSERT INTO menus_items (parent_id, menu_id, name, url, sort)
					VALUES ('" . (int)$data['parent_id'] . "', '" . (int)$data['menu_id'] . "', '" . $this->dbh->escape($data['name']) . "', '" . $this->dbh->escape($data['url']) . "', '" . $data['sort'] . "')";
		
		$this->dbh->exec($sql);
		
		return $this->dbh->lastInsertId();
	}
	
	public function edit_menu_item($data = array()) {
		$sql = "UPDATE menus_items SET 
					menu_id = '" . (int)$data['menu_id'] . "',
					parent_id = '" . (int)$data['parent_id'] . "',
					name = '" . $this->dbh->escape($data['name']) . "',
					url = '" . $this->dbh->escape($data['url']) . "',
					sort = '" . (int)$data['sort'] . "'
				WHERE id = '" . (int)$data['id'] . "'";
				
		return $this->dbh->exec($sql);
	}
	
	public function delete_menu_item($item_id = 0) {
		$count_del = 0;
		$item = $this->get_menu_item($item_id);
		$children = $this->get_menu_items($item['menu_id'], array('parent_id' => $item_id));
		foreach($children as $child) {
			$count_del += (int)$this->delete_menu_item($child['id']);
		}
		$count_del += (int)$this->dbh->exec("DELETE FROM menus_items WHERE id = '" . (int)$item_id . "'");
		return $count_del;
	}
	
	public function change_item_sort($item_id, $direction = 'before') {
		$items = $this->dbh->query("SELECT mi.* FROM menus_items mi LEFT JOIN menus_items mi2 ON mi2.id = '" . (int)$item_id . "'
										WHERE mi.parent_id = mi2.parent_id AND mi.menu_id = mi2.menu_id
											ORDER BY mi.sort ASC");
		if ($items) {
			for ($i=0; $i<count($items); $i++) {
				if ($items[$i]['id'] == $item_id) {
					// ищем элемент, с которым нужно поменяться местами
					if ($direction == 'before') {
						if ($i===0) { // попытка сдвинуть первый элемент еще ниже
							return false;
						}
						
						$replace_item = $items[($i-1)];
						
					} else {
						if ($i+1 >= count($items)) { // попытка сдвинуть последний элемент еще дальше
							return false;
						}
						
						$replace_item = $items[($i+1)];
					}
					
					$search_item = $items[$i];
					
					$sql = "UPDATE menus_items SET sort = '" . $search_item['sort'] . "' WHERE id = '" . $replace_item['id'] . "';
							UPDATE menus_items SET sort = '" . $replace_item['sort'] . "' WHERE id = '" . $search_item['id'] . "'";
					
					return $this->dbh->exec($sql);
				}
			}
		}
	}
	
	public function count_items_sort($menu_id, $parent_id = 0) {
		if (!isset($sql)) {
			static $sql = '';
		}
		
		$results = $this->dbh->query("SELECT * FROM menus_items WHERE parent_id = '" . (int)$parent_id . "' AND menu_id = '" . (int)$menu_id . "' ORDER BY sort ASC");
		
		foreach ($results as $key => $result) {
			$sql .= "UPDATE menus_items SET sort = '" . ($key+1) . "' WHERE id = '" . (int)$result['id'] . "'; ";
			
			$this->count_items_sort($menu_id, $result['id']);
		}
		
		if ($parent_id == 0) {		
			$res = $this->dbh->exec($sql);
			unset($sql);
			return $res;
		}
	}
	
}