<?php 

/**
* класс менеджера модулей
*/
class controller_component_core_components_manager extends component {
	
	// вывод  активированных модулей
	public function action_index() {
		if (isset($_SESSION['success'])) {
			$this->data['success'] = $_SESSION['success'];
			unset($_SESSION['success']);
		} else {
			$this->data['success'] = null;
		}
		
		$this->data['components_list'] = $this->model->get_components();
		
		foreach ($this->data['components_list'] as &$component) {
			$actions = array();
			
			foreach($component as $key => $value) {
				if(strpos($key, 'action_') === 0) {
					$key = str_replace('action_', '', $key);
					$actions[] = array(
						'text' => $value,
						'href' => SITE_URL . '/admin/' . $component['dir'] . '/' . $key
					);
				}
			}
			
			$component['actions'] = $actions;
			
			$info = $this->get_component_info($component['dir']);
			
			if ($info && $info['id'] != 1) {
				$component['href'] = SITE_URL . '/' . $info['url'];
			} else {
				$component['href'] = false;
			}
		}
		
		usort($this->data['components_list'], array($this, 'compare'));
		
		
		$this->data['page_name'] = 'Менеджер компонентов';
		$this->page['title'] = 'Менеджер компонентов';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view();

		return $this->page;
	}
	
	public function action_activate() {
		$this->data['errors'] = array();
	
		$installed_components = $this->model->get_components();
		
		$activated_components = array();
		
		foreach($this->model->get_activated_components() as $component) {
			$activated_components[] = $component['component'];
		}
		
		$this->data['components'] = array();
		
		foreach($installed_components as $component) { 
			if (!in_array($component['dir'], $activated_components)  // исключаем из списка уже установленные компоненты
			 && (file_exists(ROOT_DIR . '/modules/components/' . $component['dir'] . '/front_end/controller_component_' . $component['dir'] . '.php') || file_exists(ROOT_DIR . '/user_cms/modules/components/' . $component['dir'] . '/front_end/controller_component_core_' . $component['dir'] . '.php')) // исключаем из списка компоненты, используемые только в backend
			 && $component['dir'] != 'pages') {
				
				$this->data['components'][] = $component;
			}
		}
		
		usort($this->data['components'], array($this, 'compare'));
		
		if (isset($_POST['component'])) {
			$this->data['component_dir'] = $_POST['component'];
		} elseif (isset($this->url['actions'][1])) {
			$this->data['component_dir'] = $this->url['actions'][1];
		} else {
			$this->data['component_dir'] = false;
		}
		
		if (isset($_POST['name'])) {
			$this->data['name'] = $_POST['name'];
			
			if (empty($_POST['name'])) {
				$this->data['errors'][] = 'Не заполнено название компонента';
			}
		} else {
			$this->data['name'] = '';
		}

		if (isset($_POST['title'])) {
			$this->data['title'] = $_POST['title'];
		} else {
			$this->data['title'] = '';
		}
				
		if (isset($_POST['keywords'])) {
			$this->data['keywords'] = $_POST['keywords'];
		} else {
			$this->data['keywords'] = '';
		}
		
		if (isset($_POST['description'])) {
			$this->data['description'] = $_POST['description'];
		} else {
			$this->data['description'] = '';
		}		
		
		if (isset($_POST['url'])) {
			if (empty($_POST['url'])) {
				$this->data['url'] = $this->data['component_dir'];
			} else {
				$this->data['url'] = $_POST['url'];
			}
		} else {
			$this->data['url'] = '';
		}
		
		if (isset($_POST['component_info']) && !$this->data['errors']) {
			$component = $this->data['component_dir'];
			
			$this->model->activate($this->data);
			
			if (file_exists(ROOT_DIR . '/modules/components/' . $component . '/back_end/controller_component_' . $component . '.php')) {
				$class_name = 'controller_component_' . $component;
				if (!class_exists($class_name)) {
					$class_name = 'controller_component_core_' . $component;
				}
				$obj = new $class_name($this->config, $this->url, array('name' => $component, 'view' => 'index'), $this->dbh);
				if (method_exists($obj,'action_activate')) {
					$obj->action_activate();
				}
			}
			
			$_SESSION['success'] = 'Компонент "' . $component . '" успешно активирован';
			
			$this->redirect(SITE_URL . '/admin/components_manager');
		}
		
		$this->data['text_submit'] = 'Активировать';
		$this->data['page_name'] = 'Активация компонента';
		$this->page['title'] = 'Активация компонента';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('form');
		
		return $this->page;
	}
	
	public function action_activated() {
		$this->data['components'] = $this->model->get_activated_components();
		
		usort($this->data['components'], array($this, 'compare'));
		
		$this->data['page_name'] = 'Активированные компоненты';
		$this->page['title'] = 'Активированные компоненты';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('activated');
		return $this->page;
	}
	
	public function action_edit() {
		$this->data['errors'] = array();
		
		$component_info = $this->model->get_component($this->url['actions'][1]);
		
		$this->data['id'] = $this->url['actions'][1];
		
		if (isset($_POST['name'])) {
			$this->data['name'] = $_POST['name'];
			
			if (empty($_POST['name'])) {
				$this->data['errors'][] = 'Не заполнено название компонента';
			}
		} else {
			$this->data['name'] = $component_info['name'];
		}

		if (isset($_POST['title'])) {
			$this->data['title'] = $_POST['title'];
		} else {
			$this->data['title'] = $component_info['title'];
		}
				
		if (isset($_POST['keywords'])) {
			$this->data['keywords'] = $_POST['keywords'];
		} else {
			$this->data['keywords'] = $component_info['keywords'];
		}
		
		if (isset($_POST['description'])) {
			$this->data['description'] = $_POST['description'];
		} else {
			$this->data['description'] = $component_info['description'];
		}		
		
		if (isset($_POST['url'])) {
			if (empty($_POST['url'])) {
				$this->data['url'] = $this->data['component_dir'];
			} else {
				$this->data['url'] = $_POST['url'];
			}
		} else {
			$this->data['url'] = $component_info['url'];
		}
		
		if (isset($_POST['component_info']) && !$this->data['errors']) {
			$this->model->edit($this->data);
			
			$this->redirect(SITE_URL . '/admin/components_manager/activated/success=c_edit/edited=' . $component_info['id']);
		}
		
		$this->data['text_submit'] = 'Сохранить изменения';
		$this->data['page_name'] = 'Редактирование компонента ' . $component_info['name'];
		$this->page['title'] = 'Редактирование компонента';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('form');
		
		return $this->page;
	}
	
	public function action_deactivate() {
		if (!isset($this->url['actions'][1])) {
			$this->redirect(SITE_URL . '/admin/components_manager');
		}
		
		$component_info = $this->model->get_component($this->url['actions'][1]);
		
		if (!$component_info) {
			$this->redirect(SITE_URL . '/admin/components_manager');
		}
		
		$class_name = 'controller_component_' . $component_info['component'];
		if (!class_exists($class_name, true)) {
			$class_name = 'controller_component_core_' . $component_info['component'];			
		}
		$obj = new $class_name($this->config, $this->url, array('name' => $component_info['component'], 'view' => $component_info['view']), $this->dbh);
		
		if (method_exists($obj,'action_deactivate')) {
			$obj->action_deactivate();
		}
		
		$this->model->deactivate($this->url['actions'][1]);
		
		$_SESSION['success'] = 'Компонент успешно деактивирован';
		
		$this->redirect(SITE_URL . '/admin/components_manager');
	}
	
	public function action_settings() {
		if (!isset($this->url['actions'][1])) {
			$this->redirect(SITE_URL . '/admin/components_manager');
		}
		
		if (isset($_SESSION['success'])) {
			$this->data['success'] = $_SESSION['success'];
			unset($_SESSION['success']);
		} else {
			$this->data['success'] = null;
		}
		
		$component_name = $this->url['actions'][1];
		
		$this->data['config'] = array();
		
		$component_config = $this->model->get_component_full_config($component_name);
		
		if ($component_config) {	
			if (isset($_POST['edit_settings'])) {
				foreach ($component_config as $key => $config) {
					if (is_array($config) && isset($config['name']) && isset($config['value']) && isset($_POST[$key])) {
						$component_config[$key]['value'] = $_POST[$key];
					}
				}
				
				$this->model->set_component_full_config($component_name, $component_config);
				
				$_SESSION['success'] = 'Настройки обновлены. <br><a href="' . SITE_URL . '/admin/components_manager">К списку компонентов</a>';
				
				$this->redirect(SITE_URL . '/admin/components_manager/settings/' . $component_name);
			}
			
			foreach ($component_config as $key => $config) {
				if (is_array($config) && isset($config['name']) && isset($config['value'])) {
					$this->data['config'][$key] = $config;
				}
			}
		}
		
		$component_info = $this->model->get_component($component_name, false);
		
		if (isset($component_info['name'])) { // активированный компонент. берем имя из бд
			$this->data['component_name'] = $component_info['name'];
		} elseif (isset($component_config['name'])) { // компонент не активирован, но есть имя в component.ini
			$this->data['component_name'] = $component_config['name'];
		} else {
			$this->data['component_name'] = $component_name;
		}
		
		$this->data['page_name'] = 'Настройки компонента &laquo;<a href="' . SITE_URL . '/admin/' . $component_name . '">' . $this->data['component_name'] . '</a>&raquo;';
		$this->page['title'] = 'Настройки компонента ' . $this->data['component_name'];
		$this->page['keywords'] = 'Настройки компонента ' . $this->data['component_name'];
		$this->page['description'] = 'Настройки компонента ' . $this->data['component_name'];
		$this->page['html'] = $this->load_view('settings');
		
		return $this->page;
	}
	
	public function compare($a, $b) {
		$a_name = strtolower($a['name']);
		$b_name = strtolower($b['name']);
		
		return ($a_name > $b_name) ? +1 : -1;
	}
}