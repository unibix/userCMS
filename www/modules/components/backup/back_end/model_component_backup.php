<?php 

class model_component_backup extends model_component_core_backup {
	
	public function get_backups_list() {
		if (is_dir(ROOT_DIR . '/temp/backups')) {
			$backup_dir = scandir(ROOT_DIR . '/temp/backups');
			return array_values(array_diff($backup_dir, array('.', '..')));			
		}
		return array();
	}
	
}