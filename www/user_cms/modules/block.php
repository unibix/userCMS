<?php 

/**
* main block class
*/
class block extends module
{
	public $view;
	public $view_dir;
	public $block_dir;
	public $block_dir_core;
	public $block_name;
	public $page;
	public $model;
	
	function __construct($config, $url, $block_name, $dbh) {
		parent::__construct($config, $url, $block_name, $dbh);
		
  		$this -> view_dir         = ROOT_DIR .          '/modules/blocks/'.$block_name.'/views';
  		$this -> view_dir_core    = ROOT_DIR . '/user_cms/modules/blocks/'.$block_name.'/views';
  		$this -> page['html']             = '';
		$this -> page['head']             = '';
		$this -> block_dir            = ROOT_DIR . '/modules/blocks/'.$block_name;
		$this -> block_dir_core       = ROOT_DIR . '/user_cms/modules/blocks/'.$block_name;
		$this -> block_name           = $block_name;
		$this -> model                = $this->load_model();
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
	    } elseif (file_exists($view_file_core)) {
	        ob_start();
	        include $view_file_core;
	        return ob_get_clean();
	    } 
	    else {
	    	exit('Error: file not found: ' . $view_file);
	    }
	}
	
	public function load_model($type = '', $name = '') {
		if(!$name || !$type) { // подгружаем родной компонент
			$model_full_name = 'model_block_' . $this->block_name;
			if (file_exists($this->block_dir . '/' . $model_full_name . '.php')) {
				return new $model_full_name($this->dbh);
			} else {
				return null;
			}
		} else {
			$model_full_name = 'model_' . $type . '_' . $name;
			$this->$model_full_name = new $model_full_name($this->dbh);
		}
	}
	
}