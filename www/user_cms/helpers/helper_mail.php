<?php 

class helper_mail {

	
	public $from_name = 'Robot UserCMS';
	public $from_email = 'noreply@usercms.ru';
	public $mail_target = '';
	public $subject = 'Re: no subject';
	
	public function __construct($data = array()) {
		if(isset($data) && is_array($data)) {
			foreach($data as $key => $value) {
				if(isset($this->$key)) {
					$this->$key = $value;
				}
			}
		}
	}
	
	protected function message_headers(){
		$headers = "Date: ".date("D, d M Y H:i:s")." UT\r\n";
		$headers.= "MIME-Version: 1.0\r\n";
		$headers.= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
		$headers.= "Content-Transfer-Encoding: 8bit\r\n";
		$headers.= "From: =?UTF-8?B?".base64_encode($this->from_name)."?= <".$this->from_email.">\r\n";
		$headers.= "X-Priority: 3";
		$headers.= "X-Mailer: PHP/".phpversion()."\r\n";
		return $headers;
	}
	
	public function send($message = '') {
		$headers = $this->message_headers();
		$subject = "=?UTF-8?B?".base64_encode($this->subject)."?=";
		return mail($this->mail_target, $subject , $message, $headers);
	}
}

 ?>