<?php 

class helper_mail {

	public $charset = 'UTF-8';
	public $from_name = '';
	public $from_email = '';
	public $mail_target = '';
	public $subject = '';
	
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
		$headers.= "Subject: =?".$this->charset."?B?".base64_encode($this->subject)."?=\r\n";
		$headers.= "MIME-Version: 1.0\r\n";
		$headers.= "Content-Type: text/html; charset=\"".$this->charset."\"\r\n";
		$headers.= "Content-Transfer-Encoding: 8bit\r\n";
		// $headers.= "To: ".$this->mail_target." <".$this->mail_target.">\r\n";
		$headers.= "From: =?".$this->charset."?B?".base64_encode($this->from_name)."?= <".$this->from_email.">\r\n";
		$headers.= "X-Priority: 3";
		$headers.= "X-Mailer: PHP/".phpversion()."\r\n";
		return $headers;
	}
	
	public function send($data = '') {
		$headers = $this->message_headers();
		return mail($this->mail_target, $this->subject, $data, $headers);
	}
}

 ?>