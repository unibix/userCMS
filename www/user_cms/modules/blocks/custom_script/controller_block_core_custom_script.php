<?php class controller_block_core_custom_script extends block {
	/*
	* Блок custom_script
	* позволяет вставить блок выполняемого кода
	*/

	public $dir = ROOT_DIR . '/uploads/modules/custom_script';//директория где будут храниться файлы с кодом

	function action_index($data) {
		$file = $this->dir . '/' .  $data['params'] . '.php';
		if(file_exists($file)){
			ob_start();
	        include $file;
	        $this->page['html'] = ob_get_clean();
		}else{
			echo $data['name'] . ': файл ' . $file . ' не найден';
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
	
	public function action_settings($info) {
		$file_name = $this->dir . '/' . $info['params'] . '.php';
		
		if(isset($_POST['custom_script'])) {
			file_put_contents($file_name, $_POST['custom_script']);
		}
		
		$this->data['code'] = '';

		if(file_exists($file_name)) {
			$this->data['code'] = file_get_contents($file_name);
		} else {
			$this->data['error'] = 'Не найден файл ' . $file_name;
		}
		
		$this->data['file_name'] = $info['params'];
		
		$this->data['page_name'] = 'Настройки модуля "' . $info['name'] . '"';
		$this->page['html'] = $this->load_view('form') . '';
		return $this->page;
	}
	
	public function action_deactivate($info) {

		$file_name = $this->dir . '/' . $info['params'] . '.php';
		if(file_exists($file_name)) {
			unlink($file_name);
		}
	}
} 