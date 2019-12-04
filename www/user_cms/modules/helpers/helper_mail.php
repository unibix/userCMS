<?php 

class helper_mail {

    public $from_name = '';
    public $from_email = '';
    public $mail_target = '';
    public $subject = '';
    private $attach = Array();
    
    public function __construct($data = array()) {
        if(isset($data) && is_array($data)) {
            foreach($data as $key => $value) {
                if(isset($this->$key)) {
                    $this->$key = $value;
                }
            }
        }
    }

    public function add_attach($filename) {
        if (file_exists($filename)) $this->attach[] = $filename;
    }
    
    public function send($message)
    {
        $mb_internal_encoding = mb_internal_encoding();
        mb_internal_encoding('UTF-8');

        $plain_message = strip_tags($message);

        $headers = "Date: ".date("r")."\r\n";
        $headers.= "From: =?UTF-8?B?".base64_encode($this->from_name)."?= <".$this->from_email.">\r\n";
        $headers.= "Reply-To: <".$this->from_email.">\r\n";
        $headers.= "Return-Path: <".$this->from_email.">\r\n";
        $headers.= "MIME-Version: 1.0\r\n";

        $subject = "=?UTF-8?B?".base64_encode($this->subject)."?=";
        
        $body = '';
        $boundary = md5(time());
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
        if ($this->attach) {

            $body  = "\r\n--$boundary\r\n"; 
            $body .= "Content-Type: text/html; charset=UTF-8\r\n";
            $body .= "Content-Transfer-Encoding: 8bit\r\n";
            $body .= "\r\n";
            $body .= '<html>' . $message . '</html>';
            $body .= "\r\n--$boundary\r\n"; 
            $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $body .= "Content-Transfer-Encoding: 8bit\r\n";
            $body .= "\r\n";
            $body .= $plain_message;

            foreach ($this->attach as $path) {
                $filename = mb_substr($path, mb_strrpos($path, '/'));
                $body .= "\r\n--$boundary\r\n"; 
                $body .= "Content-Type: application/octet-stream\r\n";  
                $body .= "Content-Transfer-Encoding: base64\r\n"; 
                $body .= "Content-Disposition: attachment; filename*=UTF-8''".str_replace('+', '%20', urlencode($filename))."\r\n"; 
                $body .= "\r\n";
                $body .= chunk_split(base64_encode(file_get_contents($path)));
            }
        
        } else {
            $body .= "\r\n--$boundary\r\n"; 
            $body .= "Content-Type: text/html; charset=UTF-8\r\n";
            $body .= "Content-Transfer-Encoding: 8bit\r\n";
            $body .= "\r\n";
            $body .= '<html>' . $message . '</html>';
            $body .= "\r\n--$boundary\r\n"; 
            $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $body .= "Content-Transfer-Encoding: 8bit\r\n";
            $body .= "\r\n";
            $body .= $plain_message;
        }
        $body .= "\r\n--$boundary--\r\n";
        mb_internal_encoding($mb_internal_encoding);
        return mail($this->mail_target, $subject, $body, $headers);
    }
}
