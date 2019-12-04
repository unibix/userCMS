<?php 

class helper_validate {

	public function safestr($str, $replace = true){
		if($replace) {
			return str_replace("\n","<br />",str_replace("\r\n","<br />", htmlspecialchars(strip_tags($str))));
		} else {
			return htmlspecialchars(strip_tags($str));
		}
	}
	
	public function email($mail){
		return preg_match("/^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9\-]{2,}\.[a-zA-Z0-9\-\.]+$/i", $mail);
	}
	
	public function phone($phone) {
		return preg_match("/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{6,10}$/", $phone);
	}
	
}

 ?>