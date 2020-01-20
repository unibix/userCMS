<?php 
/*
* модель для менеджера файлов
*/

class model_component_core_modules_manager extends model {

	public function get_activated_modules($data = array(), $with_max_sort_value = false){
		if($with_max_sort_value) {
			$max = ", MAX(sort) as max_sort";
		} else {
			$max = '';
		}

		$sql = "SELECT * {$max} FROM activated_modules ";
		
		if (isset($data['back_end'])) {
			$sql .= "WHERE back_end = '" . $data['back_end'] . "'";
		}
		
		if (isset($data['sort'])) {
			$sql .= "ORDER BY " . $this->dbh->escape($data['sort']);
		} else {
			$sql .= "ORDER BY sort ASC, type, position, back_end";
		}

		$r = $this->dbh->query($sql);

		// Чтобы ещё и по алфавиту сортировалось
		usort($r, function($a, $b){
		    if($a['position'] === $b['position'])
		        return 0;
		        
		    return $a['position'] > $b['position'] ? 1 : -1;
		});

		$addons = [];
		$blocks = [];
		$plugins = [];

		foreach ($r as $module) {
			if($module['type'] == 'addon') {
				$addons[] = $module;
			}
			if($module['type'] == 'plugin') {
				$plugins[] = $module;
			}
			if($module['type'] == 'block') {
				$blocks[] = $module;
			}
		}

		return array_merge($addons, $plugins, $blocks);
	}
	
	public function get_installed_modules(){
		$sql = "SELECT * FROM installed_modules ORDER BY dir ASC, name ASC, id DESC";
		return $this->dbh->query($sql);
	}
	
	public function get_module_name($id){
		$module = $this->get_module_info($id);
		return $module['dir'];
	}
	
	public function install_module($data = array()){
		$sql = "INSERT INTO installed_modules (	name, type, version,dir,description, date_add)
					VALUES(
					'" . $this->dbh->escape($data['name']) . "',
					'" . $this->dbh->escape($data['type']) . "',
					'" . $this->dbh->escape($data['version']) . "',
					'" . $this->dbh->escape($data['dir']) . "',
					'" . $this->dbh->escape($data['description']) . "',
					'" . time() . "'
					)";
					
		return $this->dbh->exec($sql);

	}
	
	public function update_module($data = array()){
		$sql = "UPDATE installed_modules SET 
					name        = '" . $this->dbh->escape($data['name']) . "',
					version     = '" . $this->dbh->escape($data['version']) . "',
					date_add    = '" . time() . "',
					description = '" . $this->dbh->escape($data['description']) . "'

				WHERE 	type = '" . $this->dbh->escape($data['type']) . "' AND
						dir = '" . $this->dbh->escape($data['dir']) . "' 
						
				";
				
		$this->dbh->query($sql);
					
		return $this->dbh->exec($sql);
	}

	public function activate_module($data = array()){
		$sql = "INSERT INTO activated_modules (	name, type, module_id, module_dir, params, sections, position, back_end, sort, date_edit)
					VALUES(
					'" . $this->dbh->escape($data['name']) . "',
					'" . $this->dbh->escape($data['type']) . "',
					'" . $this->dbh->escape($data['module_id']) . "',
					'" . $this->dbh->escape($data['module_dir']) . "',
					'" . $this->dbh->escape($data['params']) . "',
					'" . $this->dbh->escape($data['sections']) . "',
					'" . $this->dbh->escape($data['position']) . "',
					'" . (int)$data['back_end'] . "',
					'" . (int)$data['sort'] . "',
					'" . time() . "'
					)";
					
		return $this->dbh->exec($sql);
	}
	
	public function update_activated_module($data = array()) {
		$sql = "UPDATE activated_modules SET
					name      = '" . $this->dbh->escape($data['name']) . "',
					position  = '" . $this->dbh->escape($data['position']) . "',
					back_end  = '" . (int)$data['back_end'] . "',
					sections  = '" . $this->dbh->escape($data['sections']) . "', ";
					
		if($data['params']) {			
			$sql .= "params    = '" . $this->dbh->escape($data['params']) . "', ";
		}
		
		$sql .= " date_edit = '" . time() . "'
				 WHERE id = '" . (int)$data['id'] . "'";

		return $this->dbh->exec($sql);
	}
	
	public function deactivate_module($id = 0) {
		return $this->dbh->exec("DELETE FROM activated_modules WHERE id = '" . (int)$id . "'");
	}
	
	public function get_module_info($module_id) {
		$sql = "SELECT * FROM installed_modules WHERE id='".(int)$module_id."' LIMIT 1";
		return $this->dbh->row($sql);
	}
	
	public function get_active_module_info($module_id) {
		$sql = "SELECT * FROM activated_modules WHERE id='".(int)$module_id."' LIMIT 1";
		return $this->dbh->row($sql);
	}
	
	public function get_modules_sections() { 
		$sections = array();
		
		$results = $this->dbh->query("SELECT * FROM main ORDER BY CASE component WHEN 'pages' THEN 0 END DESC, id ASC");
		
		foreach ($results as $result) {
			$sections[$result['id']] = array(
				'main_id'   => $result['id'],
				'name'      => $result['name'],
				'component' => $result['component']
			);
		}
		
		return $sections; 
	}
	
	public function add_section_to_module($main_id, $activated_module_id) {
		$result = $this->dbh->row("SELECT * FROM activated_modules WHERE id = '" . (int)$activated_module_id . "'");
		if ($result) {
			$sections = unserialize($result['sections']);
			$sections[] = (int)$main_id;
			$sections = serialize(array_unique($sections));
			return $this->dbh->exec("UPDATE activated_modules SET sections = '" . $this->dbh->escape($sections) . "' WHERE id = '" . (int)$activated_module_id . "'");
		} else {
			return false;
		}
	}
	
	public function change_activated_module_sort($item_id, $direction = 'before', $back_end = 0, $replace_item_id) {
		$items = $this->dbh->query("SELECT id, sort FROM activated_modules WHERE back_end = '" . (int)$back_end . "' AND (id = {$item_id} OR id = $replace_item_id) ORDER BY sort ASC");
		$sql = "";
		if(!empty($items)) {
			foreach ($items as $module) {
				if($module['id'] == $replace_item_id) {
					$sql .= "UPDATE activated_modules SET sort = '" . $module['sort'] . "' WHERE id = '" . $item_id . "';";
				} elseif($module['id'] == $item_id) {
					$sql .= "UPDATE activated_modules SET sort = '" . $module['sort'] . "' WHERE id = '" . $replace_item_id . "';";
				}
			}
			return $this->dbh->exec($sql);
		}
	}
	
	public function count_activated_modules_sort($back_end = 0) {
		$sql = '';
		
		$results = $this->dbh->query("SELECT * FROM activated_modules WHERE back_end = '" . (int)$back_end . "' ORDER BY sort ASC");
		
		foreach ($results as $key => $result) {
			$sql .= "UPDATE activated_modules SET sort = '" . ($key+1) . "' WHERE id = '" . (int)$result['id'] . "'; ";
		}

		return $this->dbh->exec($sql);
	}
	
	public function delete_module($module) {
		$this->dbh->exec("SELECT * FROM installed_modules WHERE id = '" . (int)$module['id'] . "'");
		
		$module_dir = ROOT_DIR . '/modules/' . $module['type'] . 's/' . $module['dir'];
		$module_dir_core = ROOT_DIR . '/user_cms/modules/' . $module['type'] . 's/' . $module['dir'];
		
		function delTree($dir) {
		   $files = array_diff(scandir($dir), array('.','..'));
			foreach ($files as $file) {
			  (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
			}
			return rmdir($dir);
		}
		
		if (is_dir($module_dir)) {
			delTree($module_dir);
		}
		
		if (is_dir($module_dir_core)) {
			delTree($module_dir_core);
		}

        $this->dbh->exec("DELETE FROM installed_modules WHERE id = '".(int)$module['id']."'");      
        $this->dbh->exec("DELETE FROM activated_modules WHERE module_id = '".(int)$module['id']."'");		
	}
}