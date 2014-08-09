<?php 

/**
* класс пользователей
*/
class controller_component_core_users extends component {
	
	public function action_index() {
	
		if(isset($this->url['params']['success']) && $this->url['params']['success'] == 'add' && isset($this->url['params']['added'])) {
			$this->data['success'] = 'Пользователь добавлен';
			$this->data['added_id'] = $this->url['params']['added'];
		} else {
			$this->data['success'] = '';
			$this->data['added_id'] = '';
		}
		
		if(isset($this->url['params']['success']) && $this->url['params']['success'] == 'del') {
			$this->data['success'] = 'Пользователь удален';
		}

		$this->data['users'] = $this->model->get_users();
	
		$this->data['bread_crumbs'] = 'Вы на главной странице.';
		$this->data['page_name'] = 'Пользователи';

		$page['title'] = 'Пользователи';
		$page['keywords'] = 'друиге ключи';
		$page['description'] = 'другое описание';
		$page['html'] = $this->load_view();

		return $page;
	}
	

	public function action_login() {
	
		$this->data['errors'] = array();
		
		if(isset($_POST['login'])){
			if(isset($_POST['username']) && !empty($_POST['username'])) {
				$login = $_POST['username'];
			} else {
				$this->data['errors'][] = 'Введите логин';
			}
			
			if(isset($_POST['password']) && !empty($_POST['password'])) {
				$password = $_POST['password'];
			} else {
				$this->data['errors'][] = 'Введите пароль';
			}
			
			if(isset($login) && isset($password)) {
				if ($this->model->authorisation($login, $password)) {
					
					$user = $this->model->get_user($login);
						$_SESSION['auth'] = 1;
						$_SESSION['login'] = $login;
						$_SESSION['access'] = (int)$user['access_level'];
						
					if($_SESSION['access'] >= 1) {
						$redirect = SITE_URL;
						if (isset($_SESSION['backend_route'])) {
							$redirect .= $_SESSION['backend_route'];
							unset($_SESSION['backend_route']);
						} else {
							$redirect .= '/admin';
						}
						
						$this->redirect($redirect);
					} else {
						$this->data['errors'][] = 'Доступ запрещен';
					}
				} else {
					$this->data['errors'][] = 'Неверный логин или пароль';
				}
			}
		}

		$page['title'] = 'Вход';
		$page['keywords'] = '';
		$page['description'] = '';
		$page['html'] = $this->load_view('login');
		$page['theme']['file'] = 'login';
		return $page;
	}
	
	public function action_logout() {
		if(isset($_SESSION['auth'])) {
			unset($_SESSION['auth']);
			unset($_SESSION['access']);
			unset($_SESSION['login']);
		}
		$this->redirect(SITE_URL . '/admin/users/login');
		exit();
	}
	
	public function action_edit() {
	
		if(isset($this->url['actions'][1])) { 
			$user_id = (int)$this->url['actions'][1];
		} else {
			$user_id = 0;
		}
		
		$this->data['errors'] = array();
		
		if(isset($_POST['edit_user'])) {
		
			$data = array();
		
			if(isset($_POST['login']) && !empty($_POST['login'])) {
				$data['login'] = $_POST['login'];
			} else {
				$this->data['errors'][] = 'Вы не указали логин';
			}
			
			if(isset($_POST['password']) && !empty($_POST['password'])) {
				$data['password'] = $_POST['password'];
			}
			
			if(isset($_POST['email']) && !empty($_POST['email'])) {
				$data['email'] = $_POST['email'];
			} else {
				$this->data['errors'][] = 'Вы не указали E-mail';
			}
			
			if(isset($_POST['access_level']) && !empty($_POST['access_level'])) {
				$data['access_level'] = 2;
			} else {
				$data['access_level'] = 0;
			}
		
			if(!$this->data['errors'] && $user_id !== 0) {
				$data['id'] = $user_id;
				if($this->model->edit_user($data)) {
					$this->redirect(SITE_URL . '/admin/users/edit/' . $user_id . '/success=1');
				}
			}
		}
		
		$this->data['user'] = $this->model->get_user_by_id($user_id);
	
		$this->data['bread_crumbs'] = 'Вы на главной странице.';
		$this->data['page_name']    = 'Редактирование пользователя';
		$this->data['text_submit']  = 'Сохранить изменения';
		$this->data['name_submit']  = 'edit_user';

		$page['title'] = 'Редактирование пользователя';
		$page['keywords'] = 'друиге ключи';
		$page['description'] = 'другое описание';
		$page['html'] = $this->load_view('form');

		return $page;
	}
	
	public function action_add() {
		
		$this->data['errors'] = array();
		
		if(isset($_POST['add_user'])) {
		
			$data = array();
		
			if(isset($_POST['login']) && !empty($_POST['login'])) {
				$data['login'] = $_POST['login'];
			} else {
				$this->data['errors'][] = 'Вы не указали логин';
				$data['login'] = '';
			}
			
			if(isset($_POST['password']) && !empty($_POST['password'])) {
				$data['password'] = $_POST['password'];
			} else {
				$this->data['errors'][] = 'Пользователь без пароля? Вы, должно быть, шутите.';
			}
			
			if(isset($_POST['email']) && !empty($_POST['email'])) {
				$data['email'] = $_POST['email'];
			} else {
				$this->data['errors'][] = 'Вы не указали E-mail';
				$data['email'] = '';
			}
			
			if(isset($_POST['access_level']) && !empty($_POST['access_level'])) {
				$data['access_level'] = 2;
			} else {
				$data['access_level'] = 0;
			}
		
			if(!$this->data['errors']) {
				if($this->model->add_user($data)) {
					$this->redirect(SITE_URL . '/admin/users/success=add/added=' . $this->dbh->lastInsertId());
				} else {
					$this->redirect(SITE_URL . '/admin/users/add');
				}
				
			} else {
				$this->data['user'] = $data;
			}
			
		} else {
			$this->data['user'] = array(
				'login' => '',
				'email' => '',
				'access_level' => ''
			);
		}
		

	
		$this->data['bread_crumbs'] = 'Вы на главной странице.';
		$this->data['page_name']    = 'Добавление нового пользователя';
		$this->data['text_submit']  = 'Добавить пользователя';
		$this->data['name_submit']  = 'add_user';

		$page['title'] = 'Добавление нового пользователя';
		$page['keywords'] = 'друиге ключи';
		$page['description'] = 'другое описание';
		$page['html'] = $this->load_view('form');

		return $page;
	
	}
	
	public function action_delete() {
		if(isset($this->url['actions'][1])) { 
		
			$user_id = (int)$this->url['actions'][1];
			
			if($this->model->delete_user($user_id)) {
				$this->redirect(SITE_URL . '/admin/users/success=del');
			}
		}
	}
}