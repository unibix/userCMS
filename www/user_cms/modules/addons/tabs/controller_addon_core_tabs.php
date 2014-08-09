<?php

class controller_addon_core_tabs extends addon {

	function action_index() {
		$this->page['head'] = $this->add_js_file(SITE_URL . '/user_cms/modules/addons/tabs/tabs.js');
		return $this->page;
	}
	
	public function action_delete() {
		core::print_r(' tabs action delete в разработке');
	}
	
	public function action_activate() {
		$page = array();
		$page['html'] = 'параметры аддона "вкладки"';
		return $page;
	}
}