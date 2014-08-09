<?php 

class controller_addon_core_redirect_301 extends addon {
	public function action_index($addon) {
		$results = explode("\n", $addon['params']);
		
		foreach ($results as $result) {
			$urls = explode('|', $result);
			if (isset($urls[1]) && $this->url['request_uri'] == trim($urls[0])) {
				header('HTTP/1.1 301 Moved Permanently');
				header('Location: ' . SITE_URL . trim($urls[1])); 
			}
		}
	}
	
	public function action_activate() {
		return $this->get_form();
	}
	
	public function action_settings($addon) {
		return $this->get_form($addon);
	}
	
	private function get_form($addon = array()) {
		$page = array();
		
		if(isset($_POST['activate']) || isset($_POST['edit_settings'])) {
			$this->page['params'] = $this->data['params'] = $_POST['params'];
		} elseif (isset($addon['params'])) {
			$this->data['params'] = $addon['params'];
		} else {
			$this->data['params'] = '';
		}
		
		$this->page['html'] = $this->load_view('form');
		return $this->page;
	}
	
	public function action_deactivate() {
		
	}
}