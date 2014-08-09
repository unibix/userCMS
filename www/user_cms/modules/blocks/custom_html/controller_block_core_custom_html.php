<?php
/**
* 
*/
class controller_block_core_custom_html extends block
{
	function action_index($data) {
		$file = $data['params'];
		$this->page['html'] = file_get_contents(ROOT_DIR . '/modules/blocks/custom_html/html/' . $file . '.html');
		//$this->page['head'] = '<!-- start -->' . "\n\t";
		return $this->page;
	}
	
	function action_activate() {
		$this->data['file_name'] = rand();
		$this->data['text'] = '';
		
		if(isset($_POST['html_code'])) {
			$file_name = ROOT_DIR . '/modules/blocks/custom_html/html/' . $_POST['file_name'] . '.html';
			file_put_contents($file_name, $_POST['html_code']);
			$this->page['params'] = $_POST['file_name'];
		}
		
		$this->page['html'] = $this->load_view('form') . '';
		return $this->page;
	}
	
	public function action_settings($info) {
		$file_name = ROOT_DIR . '/modules/blocks/custom_html/html/' . $info['params'] . '.html';
		
		if(isset($_POST['html_code'])) {
			file_put_contents($file_name, $_POST['html_code']);
		}
		
		$this->data['text'] = '';

		if(file_exists($file_name)) {
			$this->data['text'] = file_get_contents($file_name);
		} else {
			$this->data['error'] = 'Не найден файл ' . $file_name;
		}
		
		$this->data['file_name'] = $info['params'];
		
		$this->data['page_name'] = 'Настройки модуля "' . $info['name'] . '"';
		$this->page['html'] = $this->load_view('form') . '';
		return $this->page;
	}
	
	public function action_deactivate($info) {
		$file_name = ROOT_DIR . '/modules/blocks/custom_html/html/' . $info['params'] . '.html';
		if(file_exists($file_name)) {
			unlink($file_name);
		}
	}

}