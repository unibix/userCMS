<?php 
/*
* main component's model
*/

class model_component_core_files_manager {

	public $dbh;
	
	function __construct($dbh){
		$this->dbh = $dbh;
	}
	
	public function get_files($dir) {

			return scandir(ROOT_DIR . $dir );

	}
	
}