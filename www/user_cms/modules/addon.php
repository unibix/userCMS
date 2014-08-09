<?php 

/**
* main addon class
*/
class addon extends module
{
	public $view;
	public $view_dir;
	public $addon_dir;
	public $addon_dir_core;
	public $page;
	public $model;
	
	function __construct($config, $url, $addon_name, $dbh) {
		parent::__construct($config, $url, $addon_name, $dbh);

  		$this -> view_dir         = ROOT_DIR .          '/modules/addons/'.$addon_name.'/views';
  		$this -> view_dir_core    = ROOT_DIR . '/user_cms/modules/addons/'.$addon_name.'/views';
  		$this -> page['html']             = '';
		$this -> page['head']             = '';
		$this -> addon_dir            = ROOT_DIR . '/modules/components/'.$addon_name.'/'.END_NAME;
		$this -> addon_dir_core       = ROOT_DIR . '/user_cms/modules/components/'.$addon_name.'/'.END_NAME;
		$this -> addon_name           = $addon_name;
	//	$this -> model                    = $this->load_model();

  	}

	public function load_view($name='index')
	{
		$view_file = $this->view_dir . '/' . $name .'.tpl';
		$view_file_core = $this->view_dir_core . '/' . $name .'.tpl';
		extract($this->data);
		if (file_exists($view_file)) {
	        ob_start();
	        include $view_file;
	        return ob_get_clean();
	    } 
	    elseif (file_exists($view_file_core)) {
	        ob_start();
	        include $view_file_core;
	        return ob_get_clean();
	    } 
	    else {
	    	exit('Error #8: files not found: ' . $view_file_core);
	    }
	}

	function load_model() {
		$model_full_name = 'model_addon_' . $this->addon_name;
		//core::print_r($model_full_name, 'Загружаем модель: ' . $this->component_name);
		return new $model_full_name($this->dbh);
	}
}