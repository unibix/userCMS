<?php 

class helper_usercms {

	public function textarea_replace($html) {
		$search = array('<textarea', '</textarea>');
		$replace = array('<usercms_textarea', '</usercms_textarea>');
		return str_replace($search, $replace, $html);
	}
	
	public function textarea_replace_back($html) {
		$search = array('<usercms_textarea', '</usercms_textarea>');
		$replace = array('<textarea', '</textarea>');
		return str_replace($search, $replace, $html);
	}
}

 ?>