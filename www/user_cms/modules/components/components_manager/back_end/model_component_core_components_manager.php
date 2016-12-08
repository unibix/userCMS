<?php 
/*
* модель для менеджера файлов
*/

class model_component_core_components_manager {

	public $dbh;
	
	function __construct($dbh){
		$this->dbh = $dbh;		
	}

	public function get_components(){
		$i=0;
		$list = array();
		$tmp_saved_modules = array();
		$core_dirs = array(0=>'', 1=>'/user_cms');
		for ($core_key=0; $core_key<2; $core_key++) {
			if (is_dir(ROOT_DIR . $core_dirs[$core_key] . '/modules/components')) {
				if ($handle = opendir(ROOT_DIR . $core_dirs[$core_key] . '/modules/components')) {
					while (false !== ($entry = readdir($handle))) {
						if($entry != '.' and $entry != '..') {
							if (!isset($tmp_saved_modules[$entry])) {
								$list[$i]['dir']=$entry;
								$file = file_exists(ROOT_DIR . $core_dirs[$core_key] . '/modules/components/'.$entry.'/back_end/component.ini') ? ROOT_DIR . $core_dirs[$core_key] . '/modules/components/'.$entry.'/back_end/component.ini' : ROOT_DIR . '/user_cms/modules/components/'.$entry.'/back_end/component.ini';
								if(file_exists($file)) {
									$config = parse_ini_file($file, true);
								}
								else {
									$config=array('name'=>$entry,'dir'=>$entry);
								}
								$list[$i]['name']=$config['name'];
								foreach($config as $key => $value) {
									$list[$i][$key]=$value;
								}
								$i++;
								$tmp_saved_modules[$entry] = 1;
								//echo $entry . '---' . $core_key . "<br>";
							}
						}
						
					}
					closedir($handle);
				}
			}
		}
		unset($tmp_saved_modules);
		return $list;
	}
	
	public function get_activated_components($all = false) {
		$sql = "SELECT * FROM main ";
		
		if(!$all) {
			$sql .= "WHERE component != 'pages' ";
		}
		
		$sql .= "GROUP BY component ORDER BY date_edit DESC, date_add DESC";
		
		$results = $this->dbh->query($sql);
		
		foreach ($results as &$result) {
			$file = file_exists(ROOT_DIR . '/modules/components/' . $result['component'] . '/back_end/component.ini') ? ROOT_DIR . '/modules/components/' . $result['component'] . '/back_end/component.ini' : ROOT_DIR . '/user_cms/modules/components/' . $result['component'] . '/back_end/component.ini';
			if (file_exists($file)) {
				$result['config'] = parse_ini_file($file);
			} else {
				$result['config'] = array();
			}
		}
		
		return $results;
	}
	
	public function activate($data) {
		$sql = "INSERT INTO main (parent_id, name, title, keywords, description, component, url, date_add, date_edit)
						VALUES (
							'0',
							'" . $this->dbh->escape($data['name']) . "',
							'" . $this->dbh->escape($data['title']) . "',
							'" . $this->dbh->escape($data['keywords']) . "',
							'" . $this->dbh->escape($data['description']) . "',
							'" . $this->dbh->escape($data['component_dir']) . "',
							'" . $this->dbh->escape($data['url']) . "',
							'" . time() . "',
							'" . time() . "'
						)";
		return $this->dbh->exec($sql);
	}
	
	public function deactivate($id) {
		return $this->dbh->exec("DELETE FROM main WHERE id = '" . (int)$id . "'");
	}
	
	public function get_component($data, $by_id = true) {
		$sql = "SELECT * FROM main WHERE ";
		if($by_id) {
			$sql .= "id = '" . (int)$data . "'";
		} else {
			$sql .= "component = '" . (int)$data . "'";
		}
		
		return $this->dbh->row($sql);
	}
	
	public function edit($data) {
		$sql = "UPDATE main SET 
					name = '" . $this->dbh->escape($data['name']) . "',
					title = '" . $this->dbh->escape($data['title']) . "',
					keywords = '" . $this->dbh->escape($data['keywords']) . "',
					description = '" . $this->dbh->escape($data['description']) . "',
					url = '" . $this->dbh->escape($data['url']) . "',
					date_edit = '" . time() . "'
				WHERE id = '" . (int)$data['id'] . "'";
				
		return $this->dbh->exec($sql);
	}
	
	public function set_component_full_config($component_name, $data) {
		$ini_content = '';
		
		foreach ($data as $key => $value) {
			if (is_array($value)) {
				$ini_content .= '['.$key.']'."\n";
				foreach ($value as $key2 => $value2) $ini_content .= $key2.'="'.$value2.'"'."\n";
			} else {
				$ini_content .= $key.'="'.$value.'"'."\n";
			}
		}
		
        $ini_path = 
            file_exists(ROOT_DIR.'/modules/components/'.$component_name.'/back_end/component.ini')
            ? ROOT_DIR.'/modules/components/'.$component_name.'/back_end/component.ini'
            : ROOT_DIR.'/user_cms/modules/components/'.$component_name.'/back_end/component.ini';

		file_put_contents($ini_path, $ini_content);
	}
	
	public function get_component_full_config($component_name) {
		$ini_path = 
            file_exists(ROOT_DIR.'/modules/components/'.$component_name.'/back_end/component.ini')
            ? ROOT_DIR.'/modules/components/'.$component_name.'/back_end/component.ini'
            : ROOT_DIR.'/user_cms/modules/components/'.$component_name.'/back_end/component.ini';
		
        if (file_exists($ini_path) && is_readable($ini_path)) {
			return parse_ini_file($ini_path, true);
		} else {
			return array();
		}
	}

}