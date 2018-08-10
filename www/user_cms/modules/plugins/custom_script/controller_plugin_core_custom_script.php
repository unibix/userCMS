<?php class controller_plugin_core_custom_script extends plugin {

	public $dir = ROOT_DIR . '/uploads/modules/custom_script';

	function action_index($plugin) {
		if($this->run_params != $plugin['id'])return;
		$file = $this->dir . '/' . $plugin['params'] . '.php';
		if(file_exists($file)){
			ob_start();
			include $file;
			$this->page['html'] = ob_get_clean();
		}else{
			echo $plugin['name'] . ' (id ' . $plugin['id'] . '): файл ' . $file . ' не найден';
		}
		return $this->page;
	}

	function action_activate() {
		if(!is_dir($this->dir))mkdir($this->dir);
		$this->data['file_name'] = rand();
		$this->data['code'] = '';
		
		if(isset($_POST['custom_script'])) {
			$file_name = $this->dir . '/' . $_POST['file_name'] . '.php';
			file_put_contents($file_name, $_POST['custom_script']);
			$this->page['params'] = $_POST['file_name'];
		}
		
		$this->page['html'] = $this->load_view('form');
		return $this->page;
	}
	public function action_settings($plugin) {
		$file_name = $this->dir . '/' . $plugin['params'] . '.php';
		
		if(isset($_POST['custom_script'])) {
			file_put_contents($file_name, $_POST['custom_script']);
		}
		
		$this->data['text'] = '';

		if(file_exists($file_name)) {
			$this->data['code'] = file_get_contents($file_name);
		} else {
			$this->data['error'] = 'Не найден файл ' . $file_name;
		}
		
		$this->data['file_name'] = $plugin['params'];
		
		$this->data['page_name'] = 'Настройки модуля "' . $plugin['name'] . '"';
		$this->page['html'] = $this->load_view('form');
		return $this->page;
	}
	public function action_deactivate($plugin) {
		$file_name = $this->dir . '/' . $plugin['params'] . '.php';
		if(file_exists($file_name)) {
			unlink($file_name);
		}
	}
} 