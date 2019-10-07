<?php 
/**
* класс менеджера модулей
*/
class controller_component_core_modules_manager extends component {
	// вывод  активированных модулей
	public function action_index() {
		$this->data['success'] = '';
		if(isset($this->url['params']['success'])) {
			if($this->url['params']['success'] == 'deact') {
				$this->data['success'] = 'Модуль успешно деактивирован';
			} elseif($this->url['params']['success'] == 'act') {
				$this->data['success'] = 'Модуль успешно активирован';
			}
		} elseif (isset($_SESSION['success'])) {
			$this->data['success'] = $_SESSION['success'];
			unset($_SESSION['success']);
		}
		
		$this->data['back_end_modules_list'] = $this->model->get_activated_modules(array('back_end'=>1));
		$this->data['front_end_modules_list'] = $this->model->get_activated_modules(array('back_end'=>0));
		$this->data['page_name'] = 'Активированные модули';
		$this->page['title'] = 'Активированные модули';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view();
		return $this->page;
	}
	
	// вывод установленных модулей
	public function action_installed() {
		if (isset($_SESSION['success'])) {
			$this->data['success'] = $_SESSION['success'];
			unset($_SESSION['success']);
		} else {
			$this->data['success'] = false;
		}
		
		$this->data['modules_list'] = $this->model->get_installed_modules();
		
		$this->data['page_name'] = 'Установленные Модули';
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs($this->data['page_name'], '');
		$this->page['title'] = 'Установленные Модули';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('installed');
		return $this->page;
	}
	// установка модулей
	public function action_install() {
		$this->data['errors'] = array();
		
		if(isset($_FILES['file'])) {
		/*
			$archive_types = array(
				'application/force-download',
				'application/x-zip-compressed',
				'application/zip',
				'application/x-zip',
				'multipart/x-zip',
				'application/octet-stream'
			);
			
			if(!in_array($_FILES['file']['type'], $archive_types)) {
				$this->data['errors'][] = 'Для установки модуля необходим архив ZIP';
			}
		*/
		 		
			if (strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION))!='zip') {
				$this->data['errors'][] = 'Для установки модуля необходим архив ZIP';
			} else {
				$zip = new ZipArchive;
				$zip->open($_FILES['file']['tmp_name']);
				if($zip->getFromName('install.php') === false) {
					$this->data['errors'][] = 'Файла install.php нет в архиве';
				}
				
				$zip->extractTo(ROOT_DIR . '/modules/');
				$zip->close();
				if(count($this->data['errors']) == 0) {
					//запускаем install.php
					require_once(ROOT_DIR . '/modules/install.php');
					//удаляем install.php
					unlink(ROOT_DIR . '/modules/install.php');
				}
			}
			if(empty($this->data['message']) AND (count($this->data['errors']) == 0) ) {
				$this->data['message'] = 'Сообщение об успешности установки не задано';
			}
		}
		$this->data['page_name'] = 'Установка модулей';
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs($this->data['page_name'], '');
		$this->page['title'] = 'Установка модулей';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('install');
		return $this->page;
	}
	
	public function action_manual_install() {
		$this->data['module_types'] = array(
			'addon',
			'block',
			'plugin'
		);
		
		if (isset($_POST['install'])) {
			$this->model->install_module($_POST);
			$_SESSION['success'] = 'Модуль ' . $_POST['name'] . ' установлен';
			$this->redirect(SITE_URL . '/admin/modules_manager/installed');
		}
		
		$this->page['title'] = $this->data['page_name'] = 'Ручная установка модуля';
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs($this->data['page_name'], '');
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('manual_install');
		return $this->page;
	}
	
	// обновление модуля
	public function action_update() {
		if(isset($_FILES['file'])) {
			$archive_types = array(
				'application/force-download',
				'application/x-zip-compressed',
				'application/zip',
				'application/x-zip',
				'multipart/x-zip',
				'application/octet-stream'
			);
			
			if(!in_array($_FILES['file']['type'], $archive_types)) {
				$this->data['errors'][] = 'Для установки модуля необходим архив ZIP';
			}
			else {
				$zip = new ZipArchive;
				$zip->open($_FILES['file']['tmp_name']);
				if($zip->getFromName('update.php') === false) {
					$this->data['errors'][] = 'Файла update.php нет в архиве';
				}
				$zip->extractTo(ROOT_DIR . '/modules/');
				$zip->close();
				if(count($this->data['errors']) == 0) {
					//запускаем update.php
					require_once(ROOT_DIR . '/modules/update.php');
					//удаляем update.php
					unlink(ROOT_DIR . '/modules/update.php');
				}
			}
			if(empty($this->data['message']) AND (count($this->data['errors']) == 0) ) {
				$this->data['message'] = 'Сообщение об успешности обновления не задано';
			} 
		}
		$this->data['page_name'] = 'Обновление модуля';
		$this->page['title'] = 'Обновление модуля';
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs($this->data['page_name'], '');
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('update');
		return $this->page;
	}
	
	// активация модулей
	public function action_activate() {
		$module_info = $this->model->get_module_info($this->url['actions'][1]);
		$class_name = 'controller_' . $module_info['type'] . '_' . $module_info['dir'];	
		if (!class_exists($class_name, true)) {
			$class_name = 'controller_' . $module_info['type'] . '_core_' . $module_info['dir'];				
		}
		$obj = new $class_name($this->config, $this->url, $module_info['dir'], $this->dbh);
		if (method_exists($obj, 'action_activate')) {
			$page = $obj->action_activate();
			$this->data['params'] = $page['html'];
		} else {
			$this->data['params'] = 'Дополнительные настройки не требуются';
		}
		
		if(isset($_POST['activate'])) {
			$modules = $this->model->get_activated_modules();
			if ($modules) {
				$last_module = array_pop($modules);
				$sort = $last_module['sort']+1;
			} else {
				$sort = 1;
			}
			
			if ($_POST['section_type'] == 'choosed') { // на выбранных страницах
				$sections = serialize(array(
					'type' => 'choosed',
					'values' => isset($_POST['sections']) ? $_POST['sections'] : array()
				));
				
			} elseif ($_POST['section_type'] == 'except') { // на всех, кроме выбранных
				$sections = serialize(array(
					'type' => 'except',
					'values' => isset($_POST['sections']) ? $_POST['sections'] : array()
				));
			} else { // all - на всех
				$sections = null;
			}
			
			$module = array(
				'name' => $_POST['name'],
				'type' => $_POST['type'],
				'module_id' => $this->url['actions'][1],
				'module_dir' => $module_info['dir'],
				'position' => $_POST['position'],
				'back_end' => $_POST['back_end'],
				'sort' => $sort,
				'params' => isset($page['params']) ? $page['params'] : '',
				'sections' => $sections
			);
		
			$num = $this->model->activate_module($module);
			
			$this->model->count_activated_modules_sort(0);
			$this->model->count_activated_modules_sort(1);
			$this->data['message'] = 'Модуль активирован </br> <a href="' . SITE_URL . '/admin/' . $this->component_name . '">К списку активированных модулей</a> | <a href="' . SITE_URL . '/admin/' . $this->component_name . '/installed">Активировать другой модуль</a>';
		}
		
		$this->data['sections'] = $this->model->get_modules_sections();
		
		$this->data['module_type'] = $module_info['type'];
		$this->data['module_dir'] = $module_info['dir'];
		
		$this->data['page_name'] = 'Активация модуля &laquo;' . $module_info['name'] . '&raquo;';
		$this->page['title'] = 'Активация модуля &laquo;' . $module_info['name'] . '&raquo;';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('activate');
		return $this->page;
	}
	
	// деактивация модулей
	public function action_deactivate() {
		if(isset($this->url['actions'][1])) {
			$module_info = $this->model->get_active_module_info($this->url['actions'][1]);
			$class_name = 'controller_' . $module_info['type'] . '_' . $module_info['module_dir'];	
			if (!class_exists($class_name, true)){
				$class_name = 'controller_' . $module_info['type'] . '_core_' . $module_info['module_dir'];		
			}
			$obj = new $class_name($this->config, $this->url, $module_info['module_dir'], $this->dbh);
			
			if(method_exists($obj,'action_deactivate')) {
				$obj->action_deactivate($module_info);
			}
			
			$this->model->deactivate_module($this->url['actions'][1]);
			$this->model->count_activated_modules_sort(0);
			$this->model->count_activated_modules_sort(1);
			
			$this->redirect(SITE_URL . '/admin/' . $this->url['component'] . '/success=deact');
			
		} else {
			$this->redirect(SITE_URL . '/admin/' . $this->url['component'] . '');
		}
	}
	
	// найтройки модуля
	public function action_settings() {
		$this->data['errors'] = array();
		
		if(isset($_SESSION['success'])) {
			$this->data['message'] = $_SESSION['success'];
			unset($_SESSION['success']);
		}
		
		$module_info = $this->model->get_active_module_info($this->url['actions'][1]);
		$class_name = 'controller_' . $module_info['type'] . '_' . $module_info['module_dir'];	
		if (!class_exists($class_name, true)) {
			$class_name = 'controller_' . $module_info['type'] . '_core_' . $module_info['module_dir'];				
		}
		$obj = new $class_name($this->config, $this->url, $module_info['module_dir'], $this->dbh);
		$page = array();
		if(method_exists($obj,'action_settings')) {
			$page = $obj->action_settings($module_info);
		}
			
		if(isset($_POST['edit_settings'])) {
			$data['id'] = $this->url['actions'][1];
			$data['name'] = $_POST['name'];
			$data['position'] = $_POST['position'];
			$data['back_end'] = $_POST['back_end'];
			
			if ($_POST['section_type'] == 'choosed') { // на выбранных страницах
				$data['sections'] = serialize(array(
					'type' => 'choosed',
					'values' => isset($_POST['sections']) ? $_POST['sections'] : array()
				));
				
			} elseif ($_POST['section_type'] == 'except') { // на всех, кроме выбранных
				$data['sections'] = serialize(array(
					'type' => 'except',
					'values' => isset($_POST['sections']) ? $_POST['sections'] : array()
				));
			} else { // all - на всех
				$data['sections'] = null;
			}
			
			// если $obj->action_settings() вернул какие-то параметры, изменяем их в таблице. если нет, оставляем как есть, т.к. не во всех модулях есть необходимость изменять изначальные параметры при настройке
			$data['params'] = isset($page['params']) ? $page['params'] : false;
			
			if(!isset($page['errors']) || count($page['errors']) == 0 ) {
				$this->model->update_activated_module($data);
				
				$_SESSION['success'] = 'Настройки модуля "' . $data['name'] . '" обновлены';
				
				$this->redirect(SITE_URL . '/admin/' . $this->url['component'] . '/settings/' . $data['id']);
				
			} else {
				$this->data['errors'] = $page['errors'];
			}
		}
		// $module_info['sections'] ? unserialize($module_info['sections']) : null
		if ($module_info['sections']) {
			$sections = unserialize($module_info['sections']);
			$this->data['section_type'] = isset($sections['type']) ? $sections['type'] : 'all';
		} else {
			$sections = null;
			$this->data['section_type'] = 'all';
		}
		
		$this->data['module_info'] = array(
			'name'       => $module_info['name'],
			'position'   => $module_info['position'],
			'type'       => $module_info['type'],
			'module_dir' => $module_info['module_dir'],
			'back_end'   => (int)$module_info['back_end'],
			'sort'       => (int)$module_info['sort'],
			'sections'   => $sections
		);
		
		$this->data['sections'] = $this->model->get_modules_sections();
		$this->data['params'] = isset($page['html']) ? $page['html'] : '';
		
		$this->data['page_name'] = 'Редактирование модуля';
		$this->page['title'] = 'Редактирование модуля';
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs($this->data['page_name'] . ' «' . $module_info['name'] . '»', '');
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('settings');
		return $this->page;
	}
	
	public function action_delete() {
		if(isset($this->url['actions'][1])){
			$module_id = $this->url['actions'][1];
			$module = $this->model->get_module_info($module_id);
			$class_name = 'controller_' . $module['type'] . '_' . $module['dir'];
			if (!class_exists($class_name, true)) {
				$class_name = 'controller_' . $module['type'] . '_core_' . $module['dir'];
			}
			$module_controller = new $class_name($this->config, $this->url, $module['name'], $this->dbh);
			
			if(method_exists($module_controller,'action_delete')) {
				$module_controller->action_delete();
			}
			
			$this->model->delete_module($module);
            		$this->redirect(SITE_URL.'/admin/'.$this->component_name.'/installed');
		} else {
			$this->redirect(SITE_URL . '/admin/' . $this->component_name);
		}
	}
	
	public function action_change_activated_module_sort() {
		$this->page = array();
		$this->page['theme']['file'] = 'ajax';
		$this->page['html'] = 0;
		
		if (isset($this->url['params']['module_id']) && isset($this->url['params']['direction']) && isset($this->url['params']['back_end'])) {
			$result = $this->model->change_activated_module_sort($this->url['params']['module_id'], $this->url['params']['direction'], $this->url['params']['back_end']);
			
			if ($result) {
				$this->page['html'] .= 1;
			}
		}
		
		return $this->page;
	}
}
