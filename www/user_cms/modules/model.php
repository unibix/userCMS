<?php 

/**
* main component
*/
class model {

	public $dbh;
	
	public function __construct($dbh){
		$this->dbh = $dbh;
	}
	
	protected function get_component_config($component_name) {
		return module::get_component_config($component_name);
	}
	
	protected function get_component_info($component_name) {
		return module::get_component_info($component_name);
	}
	
	protected function get_global_data($key) {
		return module::get_global_data($key);
	}
	
	protected function set_global_data($key, $value) {
		module::set_global_data($key, $value);
	}
}