<?php

class model_component_core_theme_manager extends model
{
	public function get_themes($core = false) {
		if($core) {
			$path = ROOT_DIR . '/user_cms/themes';
		} else {
			$path = ROOT_DIR . '/themes';
		}

		$themes = array();
		$themes_dir = scandir($path);
		
		foreach($themes_dir as $theme_name) {
			if($theme_name != '.' && $theme_name != '..') {
			
				$themes[$theme_name] = array();
				$themes[$theme_name]['name'] = $theme_name;
				$themes[$theme_name]['files'] = array();
				$themes[$theme_name]['folders'] = array();
				$themes[$theme_name]['is_core_theme'] = (bool)$core;
				
				$theme_dir = scandir($path . '/' . $theme_name);
				
				foreach($theme_dir as $item) {
					$path_info = pathinfo($path . '/' . $theme_name . '/' . $item);

					if($item != '.' && $item != '..') {
						if(is_dir($path . '/' . $theme_name . '/' . $item)) {
							$themes[$theme_name]['folders'][$item] = array();
						} elseif(isset($path_info['extension']) && ($path_info['extension']=='js' || $path_info['extension']=='css' || $path_info['extension']=='tpl')) {
							$themes[$theme_name]['files'][] = $item;
						}
					}
				}
				
				// проходим по вложенным папкам
				foreach($themes[$theme_name]['folders'] as $folder => $value) {
					$subfolders = scandir($path . '/' . $theme_name . '/' . $folder);
					
					foreach($subfolders as $subitem) {
						$path_info = pathinfo($path . '/' . $theme_name . '/' . $folder . '/' . $subitem);
						if(isset($path_info['extension']) && ($path_info['extension']=='js' || $path_info['extension']=='css' || $path_info['extension']=='tpl')) {
							$themes[$theme_name]['folders'][$folder][] = $subitem;
						}
					}
				}
			}
		}
		
		if($core) {
			return $themes;
		}
		return array_merge($themes, $this->get_themes(true));
	}
	
	public function get_theme($theme_name) {
		$themes = $this->get_themes(false);
		if(isset($themes[$theme_name])) {
			return $themes[$theme_name];
		}
		return array();
	}
	
	public function edit_theme($path, $filename) {
		
	}

}