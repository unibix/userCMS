<?php 
class controller_component_core_users extends component {
	protected $errors = array();
	protected $captcha_suffix = '_profile';
	protected $first_try = null;
	private $user = array();

	public function __construct($config, $url, $component, $dbh){
		parent::__construct($config, $url, $component, $dbh);
		$this->user = $this->get_global_data('user');

	}
	
	public function action_index() {
		$user = $this->get_global_data('user');
		
		if (!$user) {
			return $this->index_not_logged();
		} else {
			return $this->index_logged();
		}
	}
	
	protected function index_logged() {
		$user = $this->user;
		if(!$user)return $this->index_not_logged();
		$this->page['title'] = $this->data['page_name'] = 'Профиль пользователя';
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs($this->data['page_name'], '');
		$this->data['user'] = $user;
		$this->page['html'] = $this->load_view('index_logged');
		return $this->page;

		
	}
	
	protected function index_not_logged() {
		$this->data['href_register'] = SITE_URL . '/' . $this->url['component'] . '/register';
		$this->data['href_login'] = SITE_URL . '/' . $this->url['component'] . '/login';
		
		$this->data['page_name'] = $this->component_info['name'];
	
		$this->page['html'] = $this->load_view('index_not_logged');
		return $this->page;
	}
	
	public function action_register() {
		if ($this->get_global_data('user')) { // юзер залогинен
			$this->redirect(SITE_URL . '/' . $this->url['component']);
		}
		if (isset($_POST['users_register'])) {
			if ($this->validate_register()) {
				$user_data = array(
					'login' => $_POST['login'],
					'password' => $_POST['password'],
					'email' => $_POST['email'],
					'access_level' => $this->component_config['default_access_level']
				);
				
				$this->model->add_user($user_data);
				
				$_SESSION['auth'] = 1;
				$_SESSION['login'] = $_POST['login'];
				$_SESSION['access'] = $this->component_config['default_access_level'];
				
				$this->unset_tried();
				
				if (isset($_SESSION['users_redirect'])) {
					$redirect = $_SESSION['users_redirect'];
					unset($_SESSION['users_redirect']);
				} else {
					$redirect = SITE_URL . '/' . $this->url['component'];
				}
				
				$this->redirect($redirect);
			} else {
				$this->set_tried();
			}
		}
		
		if (isset($_POST['login'])) {
			$this->data['login'] = $_POST['login'];
		} else {
			$this->data['login'] = '';
		}
		
		if (isset($_POST['email'])) {
			$this->data['email'] = $_POST['email'];
		} else {
			$this->data['email'] = '';
		}
		
		if (!$this->is_first_try()) {
			$this->data['captcha'] = true;
			$this->data['src_captcha'] = SITE_URL . '/user_cms/helpers/captcha.php?suffix=' . $this->captcha_suffix;
		} else {
			$this->data['captcha'] = false;
		}
		
		$this->data['page_name'] = 'Регистрация';
		
		$this->load_helper('breadcrumbs');
		$this->helper_breadcrumbs->add('Главная', SITE_URL);
		$this->helper_breadcrumbs->add($this->component_info['name'], SITE_URL . '/' . $this->url['component']);
		$this->helper_breadcrumbs->add('Регистрация', SITE_URL . '/' . $this->url['component'] . '/register');
		
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->render();
		
		$this->data['errors'] = $this->errors;
		
		$this->page['head'] = $this->add_css_file(SITE_URL . '/user_cms/modules/components/users/front_end/views/style.css');
		$this->page['title'] = 'Регистрация';
		$this->page['html'] = $this->load_view('register');
		return $this->page;
	}
	
	public function action_login() {
		if ($this->get_global_data('user')) { // юзер залогинен
			$this->redirect(SITE_URL . '/' . $this->url['component']);
		}
	
		if (isset($_POST['users_login'])) {
			if ($this->validate_login()) {
				if ($this->model->authorisation($_POST['login'], $_POST['password'])) {				
					$user = $this->model->get_user($_POST['login']);
					
					$_SESSION['auth'] = 1;
					$_SESSION['login'] = $user['login'];
					$_SESSION['access'] = (int)$user['access_level'];
					
					$this->unset_tried();
					
					if (isset($_SESSION['users_redirect'])) {
						$redirect = $_SESSION['users_redirect'];
						unset($_SESSION['users_redirect']);
					} else {
						$redirect = SITE_URL . '/' . $this->url['component'];
					}
					
					$this->redirect($redirect);
				} else {
					$this->errors[] = 'Неверное имя пользователя и/или пароль';
				}
			}
			
			$this->set_tried();
		}
		
		if (isset($_POST['login'])) {
			$this->data['login'] = $_POST['login'];
		} else {
			$this->data['login'] = '';
		}
		
		if (!$this->is_first_try()) {
			$this->data['captcha'] = true;
			$this->data['src_captcha'] = SITE_URL . '/user_cms/helpers/captcha.php?suffix=' . $this->captcha_suffix;
		} else {
			$this->data['captcha'] = false;
		}
		
		$this->data['page_name'] = 'Авторизация';
		

		$this->helper_breadcrumbs->add('Логин', '');
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->render();
		
		$this->data['errors'] = $this->errors;
		
		$this->page['head'] = $this->add_css_file(SITE_URL . '/user_cms/modules/components/users/front_end/views/style.css');
		$this->page['title'] = 'Авторизация';
		$this->page['html'] = $this->load_view('login');
		return $this->page;
	}

	public function action_logout() {
		if(isset($_SESSION['auth'])) {
			unset($_SESSION['auth']);
			unset($_SESSION['access']);
			unset($_SESSION['login']);
		}
		$this->redirect(SITE_URL . '/users/login');
		exit();
	}

	public function action_password_recovery_request(){
        $errors = array();
        if (isset($_POST['email'])) {
            if($this->model->password_recovery_request($_POST['email'])){
                $_SESSION['success_pass_request'] = true;
                $this->redirect(SITE_URL . '/' . $this->url['component'] . '/' . $this->url['actions'][0]);
            }else{
                $errors[] = 'Неправильный адрес электронной почты или пользователь с таким адресом не существует на сайте';
            }
        }
		$success = isset($_SESSION['success_pass_request'])?$_SESSION['success_pass_request']:false;
        unset($_SESSION['success_pass_request']);
        $this->page['title'] = $this->data['page_name'] = 'Восстановление пароля';
        $this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs($this->data['page_name'], '');
        $this->data['success'] = $success;
        $this->data['errors'] = $errors;
        $this->page['title'] = 'Восстановление пароля';
        $this->page['html'] = $this->load_view('reset_password_request');
        return $this->page;

	}

	public function action_password_recovery(){
		$errors = array();
		if(!isset($_GET['p']) && !isset($_SESSION['success_password_change'])) return $this->action_404();
        $success = isset($_SESSION['success_password_change'])?$_SESSION['success_password_change']:false;
        if (isset($_POST['password']) && isset($_POST['password2'])) {
        	if($_POST['password'] !== $_POST['password2'])$errors[] = 'Пароли не совпадают';
        	if(mb_strlen(trim($_POST['password'])) < 6 )$errors[] = 'Длина пароля не может быть короче 6 символов';

        	if(count($errors) == 0){
        		$new_password = trim(htmlspecialchars(strip_tags($_POST['password'])));
	            if($this->model->reset_password($_GET['p'], $new_password)){
	            	$_SESSION['success_password_change'] = 1;
	            	$this->redirect(SITE_URL . '/' . $this->url['component'] . '/' . $this->url['actions'][0] . '/?p=');
	            }else{
	            	$errors[] = 'Ошибка при изменении пароля. Обратитесь к администратору';
	            }
	        }
	           
        }
        unset($_SESSION['success_password_change']);
        $this->data['success'] = $success;
        $this->data['errors'] = $errors;
        $this->page['title'] = 'Сброс пароля';
        $this->page['html'] = $this->load_view('reset_password');
        return $this->page;
	}
	
	protected function validate_register() {
		$this->load_helper('validate');
		
		if (!isset($_POST['email']) || !$this->helper_validate->email($_POST['email'])) {
			$this->errors[] = 'Укажите Email';
		} elseif ($this->model->get_user($_POST['email'], 'by_email')) {
			$this->errors[] = 'Пользователь с таким email уже существует';
		}
		
		if (!isset($_POST['login']) || empty($_POST['login'])) {
			$this->errors[] = 'Укажите логин';
		} elseif ($this->model->get_user($_POST['login'])) {
			$this->errors[] = 'Пользователь с таким логином уже существует';
		} else {
			if (!preg_match('/^[a-zA-Z_\-0-9]{3,32}$/', $_POST['login'])) {
				$this->errors[] = 'Логин может содержать только латинские символы, цифры, дефис, нижнее подчеркивание';
			}
			if (mb_strlen($_POST['login'],'UTF-8') < 3 || mb_strlen($_POST['login'],'UTF-8') > 32) {
				$this->errors[] = 'Логин должен быть от 3 до 32 символов';
			}
		}
		
		if (!$this->is_first_try() && (!isset($_SESSION['captcha' . $this->captcha_suffix]) || !isset($_POST['captcha']) || empty($_POST['captcha']) || $_SESSION['captcha' . $this->captcha_suffix] !== $_POST['captcha'])) {
			$this->errors[] = 'Неверные символы';
		}
		
		if (!isset($_POST['password']) || empty($_POST['password'])) {
			$this->errors[] = 'Укажите пароль';
		} elseif (mb_strlen($_POST['password'],'UTF-8') < 6 || mb_strlen($_POST['password'],'UTF-8') > 16) {
			$this->errors[] = 'Пароль должен быть от 6 до 16 символов';
		} elseif (!isset($_POST['password_2']) || empty($_POST['password_2']) || $_POST['password'] !== $_POST['password_2']) {
			$this->errors[] = 'Пароли не совпадают';
		}
		
		if ($this->errors) {
			return false;
		} else {
			return true;
		}
	}
	
	protected function validate_login() {
		if (!isset($_POST['login']) || empty($_POST['login'])) {
			$this->errors[] = 'Введите имя пользователя';
		}
		
		if (!isset($_POST['password']) || empty($_POST['password'])) {
			$this->errors[] = 'Введите пароль';
		}
		
		if (!$this->is_first_try() && (!isset($_SESSION['captcha' . $this->captcha_suffix]) || !isset($_POST['captcha']) || empty($_POST['captcha']) || $_SESSION['captcha' . $this->captcha_suffix] !== $_POST['captcha'])) {
			$this->errors[] = 'Неверные символы';
		}
		
		if ($this->errors) {
			return false;
		} else {
			return true;
		}
	}
	
	// проверка пытался ли юзер залогиниться/зарегиться - используется для вывода капчи
	protected function is_first_try() {
		if ($this->first_try === null) {
			return (!isset($_COOKIE['users_try']) && !isset($_SESSION['users_try']));
		} else {
			return $this->first_try;
		}
	}
	
	protected function set_tried() {
		$this->first_try = false;
		setcookie('users_try', time());
		$_SESSION['users_try'] = time();
	}
	
	protected function unset_tried() {
		$this->first_try = true;
		if (isset($_COOKIE['users_try'])) setcookie('users_try', 1, time()-1);
		if (isset($_SESSION['users_try'])) unset($_SESSION['users_try']);
	}


}