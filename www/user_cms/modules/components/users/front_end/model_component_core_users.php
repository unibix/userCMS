<?php 
class model_component_core_users extends model {
	public function authorisation($login, $password) {
		$sql = "SELECT * FROM users WHERE login = '" . $this->dbh->escape($login) . "' AND password = '" . md5($password) . "' LIMIT 1 ";
		if ($this->dbh->query_count($sql) === 1) {
			return true;
		}
		return false;
	}
	
	public function get_user($data, $type = 'by_login') {
		$sql = "SELECT * FROM users WHERE ";
		
		if ($type == 'by_id') {
			$sql .= "id = '" . $this->dbh->escape($data) . "'";
		} elseif ($type == 'by_email') {
			$sql .= "email = '" . $this->dbh->escape($data) . "'";
		} else {
			$sql .= "login = '" . $this->dbh->escape($data) . "'";
		}
		
		$sql .= " LIMIT 1 ";
		return $this->dbh->row($sql);
	}	
	
	public function get_user_by_id($id) {
		return $this->get_user($id, 'by_id'); // äëÿ ñîâìåñòèìîñòè ñ ïðåäûäóùèìè âåðñèÿìè
	}
	
	public function get_users($data = array()) {
		$sql = "SELECT * FROM users ";
		if (isset($data['sort'])) {
			$sql .= "ORDER BY " . $this->dbh->escape($data['sort']) . " ";
		} else {
			$sql .= "ORDER BY id ASC ";
		}
		
		if (isset($data['limit'])) {
			$sql .= "LIMIT " . $this->dbh->escape($data['limit']) . " ";
		}
		
		return $this->dbh->query($sql);
	}
	
	public function delete_user($id) {
		$sql = "DELETE FROM users WHERE id = '" . (int)$id . "'";
		return $this->dbh->exec($sql);
	}	
	
	public function edit_user($data = array()) {
		$sql = "UPDATE users SET
			login = '" . $this->dbh->escape($data['login']) . "',
			email = '" . $this->dbh->escape($data['email']) . "',
			access_level = '" . (int)$data['access_level'] . "',
			date_edit = '" . time() . "' ";
			
		if(isset($data['password']) && !empty($data['password'])) {
			$sql .= ", password = '" . md5($data['password']) . "' ";
		}
		
		$sql .= " WHERE id = '" . $data['id'] . "'";
		
		return $this->dbh->exec($sql);
	}	
	
	public function add_user($data = array()) {
		$sql = "INSERT INTO users (login, password, email, date_add, date_edit, access_level, active) VALUES (
				'" . $this->dbh->escape($data['login']) . "',
				'" . md5($data['password']) . "',
				'" . $this->dbh->escape($data['email']) . "',
				'" . time() . "',
				'" . time() . "',
				'" . (int)$data['access_level'] . "',
				'1'
			)";
			
		$this->dbh->exec($sql);
		
		return $this->dbh->lastInsertId();
	}

	public function send_email($addr, $subject, $text)
    {
    	$helper_path = '';
    	if(file_exists(ROOT_DIR.'/modules/helpers/helper_mail.php')) {
			$helper_path = ROOT_DIR.'/modules/helpers/helper_mail.php'
    	} else {	
    		$helper_path = ROOT_DIR.'/user_cms/modules/helpers/helper_mail.php';
    	}
        require_once($helper_path);
        $this->helper_mail = new helper_mail;
        $this->helper_mail->from_name = 'Робот ' . SITE_NAME;
        $this->helper_mail->from_email = 'robot@'.$_SERVER['HTTP_HOST'];
        $this->helper_mail->mail_target = $addr;
        $this->helper_mail->subject = $subject;
        return $this->helper_mail->send($text);
    }

	public function password_recovery_request($email){
        $email = $this->dbh->escape($email);
        $user = $this->dbh->row("SELECT * FROM users WHERE email='$email' LIMIT 1");
        if(!$user)return false;
        $link = SITE_URL . '/users/password_recovery?p=' . urlencode(base64_encode($email));
        $subject = 'Запрос на изменение пароля!';
        $message = '<p>Мы получили запрос на сброс Вашего пароля.<br>Перейдите по ссылке ' . $link . ' для ввода нового пароля</p><p>Если вы не запрашивали сброс пароля, немедленно войдите в аккаунт и поменяйте и логин, и пароль. Никому не передавайте свой логин и пароль!</p>';
        return $this->send_email($user['email'], $subject, $message);
    }

    public function reset_password($email, $new_password)
    {
        $email = $this->dbh->escape(base64_decode(urldecode($email)));
        $user = $this->dbh->row("SELECT * FROM users WHERE email='$email' AND access_level=0 LIMIT 1");
        if (!$user) {
            return false;
        }
        if ($user['email'] == $email) {
            $hash = md5($new_password);
            $this->dbh->exec("UPDATE users SET password='$hash' WHERE id=$user[id]");
            $subject = 'Ваш пароль изменен!';
            $message = '<p>' . SITE_URL . '<p>Ваш пароль успешно изменен.<br>Новый пароль: '.$new_password.'</p><p>Если вы не меняли свой пароль, немедленно войдите в аккаунт и поменяйте и логин, и пароль или свяжитесь с администратором сайта по адресу ' . SITE_EMAIL . '. Никому не передавайте свой логин и пароль!</p>';
        } else {
            $_SESSION['deny_reset_password'] = true;
            $subject = 'Ваш аккаунт пытались взломать!';
            $message = '<p>Мы выявили и успешно блокировали попытку взлома вашего аккаунта! Ни в коем случае не передавайте ваши данные посторонним!</p>';
        }
        return $this->send_email($user['email'], $subject, $message);
    }

}