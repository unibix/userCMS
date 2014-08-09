<?php 
/*
* main component's model
*/

class model_component_core_config {

	public $dbh;
	
	function __construct($dbh){
		$this->dbh = $dbh;
	}
	
	public function get_config() {
		if(file_exists('config.ini')) {
			return parse_ini_file('config.ini');
		} else {
			return false;
		}
	}
	
	public function update_config($data = array()) {
		if ( file_exists('config.ini') ) {
			$fp = fopen('config.ini',"w");
			foreach ($data as $key => $value) {
				fwrite($fp, $key . '="' . $value . "\"\r\n");
			}
			fclose($fp);
			
			return true;
		} else {
			return false; 
		}
	}
	
	public function get_themes() {
		$core_themes = scandir(ROOT_DIR . '/user_cms/themes');
		$themes = scandir(ROOT_DIR . '/themes');
		unset($core_themes[0], $core_themes[1], $themes[0], $themes[1]);
		return array_merge($themes, $core_themes);
	}
}