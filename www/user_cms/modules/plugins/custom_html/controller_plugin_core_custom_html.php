<?php class controller_plugin_core_custom_html extends plugin {
	public $dir = ROOT_DIR . '/uploads/modules/custom_html';

	function action_index($plugin) {
		if($this->run_params != $plugin['id'])return;
		$file = $this->dir . '/' . $plugin['params'] . '.html';
		$this->page['html'] = file_exists($file) ? file_get_contents($file) : '';
		return $this->page;
	}

	function action_activate() {
		if(!is_dir($this->dir))mkdir($this->dir);
		$this->data['file_name'] = rand();
		$this->data['text'] = '';
		
		if(isset($_POST['html_code'])) {
			$file_name = $this->dir . '/' . $_POST['file_name'] . '.html';
			file_put_contents($file_name, $_POST['html_code']);
			$this->page['params'] = $_POST['file_name'];
		}
		
		$this->page['html'] = $this->load_view('form');
		return $this->page;
	}
	public function action_settings($plugin) {
		$file_name = $this->dir . '/' . $plugin['params'] . '.html';
		
		if(isset($_POST['html_code'])) {
			file_put_contents($file_name, $_POST['html_code']);
		}
		
		$this->data['text'] = '';

		if(file_exists($file_name)) {
			$this->data['text'] = file_get_contents($file_name);
		} else {
			$this->data['error'] = 'Не найден файл ' . $file_name;
		}
		
		$this->data['file_name'] = $plugin['params'];
		
		$this->data['page_name'] = 'Настройки модуля "' . $plugin['name'] . '"';
		$this->page['html'] = $this->load_view('form');
		return $this->page;
	}
	public function action_deactivate($plugin) {
		$file_name = $this->dir . '/' . $plugin['params'] . '.html';
		if(file_exists($file_name)) {
			unlink($file_name);
		}
	}

} 