<?php


class controller_addon_core_jquery extends addon  {

	function action_index() {
		$this->page['head'] = $this->add_js_file('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js');
		return $this->page;
	}
	public function action_delete() {
		core::print_r(' jquery action delete');
	}
}