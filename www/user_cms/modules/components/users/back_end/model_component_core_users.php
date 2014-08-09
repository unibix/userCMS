<?php 
/*
* main component's model
*/

class model_component_core_users {

	public $dbh;
	
	function __construct($dbh){
		$this->dbh = $dbh;
	}
	
	public function authorisation($login, $password) {
		$sql = "SELECT * FROM users WHERE login = '" . $this->dbh->escape($login) . "' AND password = '" . md5($password) . "' LIMIT 1 ";
		if ($this->dbh->query_count($sql) === 1) {
			return true;
		}
		return false;
	}	
	
	public function get_user($login) {
		$sql = "SELECT * FROM users WHERE login = '" . $this->dbh->escape($login) . "' LIMIT 1 ";
		return $this->dbh->row($sql);
	}	
	
	public function get_user_by_id($id) {
		$sql = "SELECT * FROM users WHERE id = '" . (int)$id . "' LIMIT 1 ";
		return $this->dbh->row($sql);
	}
	
	public function get_users($order = 'id ASC') {
		$sql = "SELECT * FROM users ORDER BY ".$order." ";
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
		
		return $this->dbh->exec($sql);
	}
	
}