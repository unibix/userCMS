<?php 

/**
* main plugin class
*/
class plugin extends module
{
	public $view;
	public $view_dir;
	public $plugin_dir;
	public $plugin_dir_core;
	public $page;
	public $model;
	
	function __construct($config, $url, $plugin_name, $dbh) {
		parent::__construct($config, $url, $plugin_name, $dbh);
		
  		$this -> view_dir         = ROOT_DIR .          '/modules/plugins/'.$plugin_name.'/views';
  		$this -> view_dir_core    = ROOT_DIR . '/user_cms/modules/plugins/'.$plugin_name.'/views';
  		$this -> page['html']             = '';
		$this -> page['head']             = '';
		$this -> plugin_dir            = ROOT_DIR . '/modules/components/'.$plugin_name.'/'.END_NAME;
		$this -> plugin_dir_core       = ROOT_DIR . '/user_cms/modules/components/'.$plugin_name.'/'.END_NAME;
		$this -> plugin_name           = $plugin_name;
	//	$this -> model                    = $this->load_model();


  	}

	public function load_view($name='index')
	{
		$view_file = $this->view_dir . '/' . $name .'.tpl';
		$view_file_core = $this->view_dir_core . '/' . $name .'.tpl';
		if($this->data) {
			extract($this->data);
		}
		if (file_exists($view_file)) {
	        ob_start();
	        include $view_file;
	        return ob_get_clean();
	    } elseif (file_exists($view_file_core)) {
	        ob_start();
	        include $view_file_core;
	        return ob_get_clean();
	    } else {
	    	exit('Error: file not found: ' . $view_file);
	    }
	}
	
	function load_model($type = '', $name = '') {
		if(!$name || !$type) { // подгружаем родной компонент
			$model_full_name = 'model_plugin_' . $this->plugin_name;
			return new $model_full_name($this->dbh);
		} else {
			$model_full_name = 'model_' . $type . '_' . $name;
			$this->$model_full_name = new $model_full_name($this->dbh);
		}
	}
	
}