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
		return $this->get_user($id, 'by_id'); // для совместимости с предыдущими версиями
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
}