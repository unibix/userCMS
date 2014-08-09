<?php


class controller_addon_core_jquery extends addon  {

	function action_index() {
		$this->page['head'] = $this->add_js_file(SITE_URL . '/user_cms/modules/addons/jquery/jquery-1.7.2.min.js');
		return $this->page;
	}
	public function action_delete() {
		core::print_r(' jquery action delete');
	}
}