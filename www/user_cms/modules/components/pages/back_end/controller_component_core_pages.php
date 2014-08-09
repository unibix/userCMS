<?php 

/**
* класс текстовых страниц
*/
class controller_component_core_pages extends component {
	
	// вывод страниц и списка активированных компонентов
	public function action_index() {		
		$this->data['success'] = '';
		$this->data['errors'] = array();
		if (isset($this->url['params']['success'])) {
			if ($this->url['params']['success']=='deleted') {
				$this->data['success'] = 'Страница удалена';
			}
		}
		if (isset($this->url['params']['error'])) {
			if ($this->url['params']['error'] == 'del_main') {
				$this->data['errors'][] = 'Удаление главной страницы запрещено';
			}
		}
	
		$params = array('sort' => 'm.date_edit DESC, m.date_add DESC', 'children_count' => true);
		
		$this->data['main_page'] = $this->model->get_page(1);
		$this->data['main_page']['name'] = 'Главная';
		$this->data['pages_list'] = $this->model->get_pages_by_parent_id(0, $params);
		
		foreach($this->data['pages_list'] as $key => $page) {
			$this->data['pages_list'][$key]['full_url'] = $this->model->get_page_url($page['id']);
		}
		
		$this->load_model('component', 'components_manager');
		
		$this->data['components'] = $this->model_component_components_manager->get_activated_components();
		
		$this->data['page_name'] = 'Страницы сайта';

		$this->page['title'] = 'Страницы сайта';
		$this->page['keywords'] = 'Страницы сайта';
		$this->page['description'] = 'Страницы сайта';
		$this->page['html'] = $this->load_view();

		return $this->page;
	}
	

	public function action_edit() {
		$this->data['errors'] = array();
		$this->data['success'] = array();
		$this->data['notices'] = array();
		
		$this->load_helper('usercms');
		
		if (!isset($this->url['actions'][1])) {
			$this->redirect(SITE_URL . '/admin');
		}
		
		$this->data['id'] = (int)$this->url['actions'][1];
		
		if (isset($this->url['params']['success']) && $this->url['params']['success'] == 'edited') {
			$this->data['success'][] = 'Изменения сохранены';
			$url = $this->model->get_page_url($this->data['id']);
			$this->data['success'][] = '<a href="' . SITE_URL . $url . '" target="_blank">Просмотреть страницу</a>';
		}
		if (isset($this->url['params']['changed_url'])) {
			$this->data['notices'][] = 'Такой адрес страницы уже есть, URL был изменен: ' . $this->url['params']['changed_url'];
		}
		
		$result = $this->model->get_page($this->data['id']);

		if (isset($_POST['page_name'])) {
			$this->data['name'] = $_POST['page_name'];
			if (empty($this->data['name'])) {
				$this->data['errors'][] = 'Не указан заголовок страницы';
			}
		} else {
			$this->data['name'] = $result['name'];
		}
		
		if (isset($_POST['page_text'])) {
			$this->data['text'] = $this->helper_usercms->textarea_replace_back($_POST['page_text']);
		} else {
			$this->data['text'] = $this->helper_usercms->textarea_replace($result['text']);
		}
				
		if (isset($_POST['page_title'])) {
			$this->data['title'] = $_POST['page_title'];
		} else {
			$this->data['title'] = $result['title'];
		}
						
		if (isset($_POST['page_keywords'])) {
			$this->data['keywords'] = $_POST['page_keywords'];
		} else {
			$this->data['keywords'] = $result['keywords'];
		}
								
		if (isset($_POST['page_description'])) {
			$this->data['description'] = $_POST['page_description'];
		} else {
			$this->data['description'] = $result['description'];
		}
										
		if (isset($_POST['page_url']) && $this->data['id'] !== 1) {
			$_POST['page_url'] = str_replace('/', '', $_POST['page_url']);
			if (!empty($_POST['page_url'])) {
				$this->data['url'] = $this->str2url($_POST['page_url']);
				if ($this->model->url_exists($this->data['url'], $this->data['id'])) {
					$this->data['url'] = $this->model->url_modify($this->data['url'], $this->data['id']);
					$this->data['notices']['changed_url'] = 'Такой адрес страницы уже есть, URL был изменен: ' . $this->data['url'];
				}
			} else {
				$this->data['url'] = $this->str2url($this->data['name']);
				if ($this->model->url_exists($this->data['url'], $this->data['id'])) {
					$this->data['url'] = $this->model->url_modify($this->data['url'], $this->data['id']);
					$this->data['notices']['changed_url'] = 'Такой адрес страницы уже есть, URL был изменен: ' . $this->data['url'];
				}
			}

		} else {
			$this->data['url'] = $result['url'];
		}
		
		if (isset($_POST['page_view'])) {
			$this->data['page_view'] = $_POST['page_view'];
		} else {
			$this->data['page_view'] = !empty($result['view']) ? $result['view'] : 'index';
		}
				
		if (isset($_POST['theme_view'])) {
			$this->data['theme_view'] = $_POST['theme_view'];
		} else {
			$this->data['theme_view'] = !empty($result['theme_view']) ? $result['theme_view'] : 'index';
		}
		
		if (isset($_POST['page_parent_id'])) {
			$this->data['parent_id'] = $_POST['page_parent_id'];
		} else {
			$this->data['parent_id'] = $result['parent_id'];
		}
		
		if (isset($_POST['edit']) && !$this->data['errors']) {
			$this->model->edit_page($this->data);
			$redirect = SITE_URL . '/admin/pages/edit/' . $this->data['id'] . '/success=edited';
			if (isset($this->data['notices']['changed_url'])) {
				$redirect .= '/changed_url=' . $this->data['url'];
			}
			$this->redirect($redirect);
			
		} elseif (isset($_POST['edit_exit']) && !$this->data['errors']) {
			$this->model->edit_page($this->data);
			$this->redirect(SITE_URL . '/admin/pages');
		}
		
		if ($this->data['id'] !== 1) {
			$this->data['url'] = '/' . $this->data['url'];
		}
		
		$page_views = array_merge($this->model->get_views(ROOT_DIR . '/modules/components/' . $this->component_name . '/front_end/views'), $this->model->get_views(ROOT_DIR . '/user_cms/modules/components/' . $this->component_name . '/front_end/views'));
		$theme_views = array_merge($this->model->get_views(ROOT_DIR . '/themes/' . $this->config['site_theme']), $this->model->get_views(ROOT_DIR . '/user_cms/themes/' . $this->config['site_theme']));
	
		$this->data['page_views'] = array_unique($page_views);		
		$this->data['theme_views'] = array_unique($theme_views);
		
		$categories = $this->model->get_pages(0, array( 'type' => 'tree', 'sort' => 'm.name ASC' ));
		$this->data['categories_options'] = $this->build_categories_options($categories, array(1, $this->data['id']), '', $this->data['parent_id']);
		
		$this->data['page_name'] = 'Редактирование страницы';
		
		$this->page['title'] = 'Редактирование страницы';
		$this->page['keywords'] = 'Редактирование страницы';
		$this->page['description'] = 'Редактирование страницы';
		$this->page['html'] = $this->load_view('edit');

		return $this->page;
	}

	// добавление страницы или активация компонента
	public function action_add() {
		$this->data['errors'] = array();
		$this->data['success'] = array();
		$this->data['notices'] = array();
		
		if (isset($this->url['params']['success']) && $this->url['params']['success'] == 'added') {
			if (isset($this->url['params']['page'])) {
				$page = $this->model->get_page($this->url['params']['page']);
			} else {
				$page = array('name'=>'');
			}
			
			$page = $this->model->get_page($this->url['params']['page']);
			$this->data['success'][] = 'Страница ' . $page['name'] . ' добавлена.';
			
			if ($page['name']) {
				$url = $this->model->get_page_url($this->url['params']['page']);
				$this->data['success'][] = '<a href="' . SITE_URL . $url . '" target="_blank">Просмотр</a> | <a href="' . SITE_URL . '/admin/pages/edit/' . $page['id'] . '">Редактировать</a>';
			}
		}
		
		if (isset($this->url['params']['changed_url'])) {
			$this->data['notices'][] = 'Такой адрес страницы уже есть, URL был изменен: ' . $this->url['params']['changed_url'];
		}
		
		if (isset($_POST['page_name'])) {
			$this->data['name'] = $_POST['page_name'];
			if (empty($this->data['name'])) {
				$this->data['errors'][] = 'Не указан заголовок страницы';
			}
		} else {
			$this->data['name'] = '';
		}
		
		if (isset($_POST['page_text'])) {
			$this->data['text'] = $_POST['page_text'];
		} else {
			$this->data['text'] = '';
		}
				
		if (isset($_POST['page_title']) && !empty($_POST['page_title'])) {
			$this->data['title'] = $_POST['page_title'];
		} else {
			$this->data['title'] = $this->data['name'];
		}
						
		if (isset($_POST['page_keywords']) && !empty($_POST['page_keywords'])) {
			$this->data['keywords'] = $_POST['page_keywords'];
		} else {
			$this->data['keywords'] = $this->data['name'];
		}
								
		if (isset($_POST['page_description']) && !empty($_POST['page_description'])) {
			$this->data['description'] = $_POST['page_description'];
		} else {
			$this->data['description'] = $this->data['name'];
		}
										
		if (isset($_POST['page_url'])) {
			$_POST['page_url'] = str_replace('/', '', $_POST['page_url']);
			if (!empty($_POST['page_url'])) {
				$this->data['url'] = $this->str2url($_POST['page_url']);
				if ($this->model->url_exists($this->data['url'])) {
					$this->data['url'] = $this->model->url_modify($this->data['url']);
					$this->data['notices']['changed_url'] = 'Такой адрес страницы уже есть, URL был изменен: ' . $this->data['url'];
				}
			} else {
				$this->data['url'] = $this->str2url($this->data['name']);
				if ($this->model->url_exists($this->data['url'])) {
					$this->data['url'] = $this->model->url_modify($this->data['url']);
					$this->data['notices']['changed_url'] = 'Такой адрес страницы уже есть, URL был изменен: ' . $this->data['url'];
				}
			}
		} else {
			$this->data['url'] = '';
		}
		
		if (isset($_POST['page_view'])) {
			$this->data['page_view'] = $_POST['page_view'];
		} else {
			$this->data['page_view'] = 'index';
		}
				
		if (isset($_POST['theme_view'])) {
			$this->data['theme_view'] = $_POST['theme_view'];
		} else {
			$this->data['theme_view'] = 'index';
		}
		
		if (isset($_POST['page_parent_id'])) {
			$this->data['parent_id'] = $_POST['page_parent_id'];
		} elseif (isset($this->url['params']['parent_id'])) {
			$this->data['parent_id'] = $this->url['params']['parent_id'];
		} else {
			$this->data['parent_id'] = 0;
		}
		
		if (isset($_POST['add']) && !$this->data['errors']) {

			$page_id = $this->model->add_page($this->data);

			$redirect = SITE_URL . '/admin/pages/add/success=added/page=' . $page_id;
			if (isset($this->data['notices']['changed_url'])) {
				$redirect .= '/changed_url=' . $this->data['url'];
			}
			$this->redirect($redirect);
			
		} elseif (isset($_POST['add_exit']) && !$this->data['errors']) {
			$this->model->add_page($this->data);
			$this->redirect(SITE_URL . '/admin/pages');
		}
		
		$page_views = array_merge($this->model->get_views(ROOT_DIR . '/modules/components/' . $this->component_name . '/front_end/views'), $this->model->get_views(ROOT_DIR . '/user_cms/modules/components/' . $this->component_name . '/front_end/views'));
		$theme_views = array_merge($this->model->get_views(ROOT_DIR . '/themes/' . $this->config['site_theme']), $this->model->get_views(ROOT_DIR . '/user_cms/themes/' . $this->config['site_theme']));
		
		$this->data['page_views'] = array_unique($page_views);		
		$this->data['theme_views'] = array_unique($theme_views);
		
		$categories = $this->model->get_pages(0, array( 'type' => 'tree', 'sort' => 'm.name ASC' ));
		$this->data['categories_options'] = $this->build_categories_options($categories, array(1));

		$this->data['page_name'] = 'Добавление новой страницы';
		
		$this->page['title'] = 'Добавление страницы';
		$this->page['keywords'] = 'Добавление страницы';
		$this->page['description'] = 'Добавление страницы';
		$this->page['html'] = $this->load_view('add');

		return $this->page;
	}
	
	public function action_delete() {
		if (isset($this->url['actions'][1]) && (int)$this->url['actions'][1] !== 0) {
			if ($this->url['actions'][1] == 1) {
				$this->redirect(SITE_URL . '/admin/pages/error=del_main');
			} elseif ($this->model->delete_page($this->url['actions'][1], true)) {
				$this->redirect(SITE_URL . '/admin/pages/success=deleted');
			}
		} else {
			$this->redirect(SITE_URL . '/admin/pages');
		}
	}
	
	public function action_ajax_get_children() {
	
		if (!isset($_POST['parent_id'])) {
			exit();
		}
		$this->data['parent_id'] = (int)$_POST['parent_id'];
		
		$params = array('sort' => 'm.date_add DESC', 'children_count' => true);
		$this->data['pages_list'] = $this->model->get_pages_by_parent_id($this->data['parent_id'], $params);
		
		foreach($this->data['pages_list'] as $key => $page) {
			$this->data['pages_list'][$key]['full_url'] = $this->model->get_page_url($page['id']);
		}
		
		$this->page['theme']['file'] = 'ajax';
		$this->page['html'] = $this->load_view('ajax_pages_rows');
		return $this->page;
	}
	
	public function build_categories_options($pages, $exceptions = array(), $name_prefix = '', $selected = 0) {
		static $html = '';
		
		foreach ($pages as $page) {
			if (!in_array($page['id'], $exceptions)) {
				if ($page['id'] == $selected) {
					$html .= '<option selected="selected" value="' . $page['id'] . '">' . $name_prefix . $page['name'] . '</option>' . "\n\t\t";
				} else {
					$html .= '<option value="' . $page['id'] . '">' . $name_prefix . $page['name'] . '</option>' . "\n\t\t";
				}
				
				if ($page['children']) {
					$this->build_categories_options($page['children'], $exceptions, $name_prefix . $page['name'] . ' &rsaquo; ', $selected);
				}
			}
		}
		
		return $html;
	}
}