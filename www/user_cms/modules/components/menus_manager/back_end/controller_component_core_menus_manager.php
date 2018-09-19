<?php 
class controller_component_core_menus_manager extends component {
	public function action_index() {
		$this->data['errors'] = array();
		$this->data['success'] = array();
		$this->data['notices'] = array();
		
		if(isset($this->url['params']['success'])) {
			if($this->url['params']['success']=='add' && isset($this->url['params']['added'])) {
				$this->data['success'][] = 'Меню успешно добавлено<br>';
				$this->data['success'][] = '<a href="' . SITE_URL . '/admin/menus_manager/edit/' . $this->url['params']['added'] . '">Редактировать</a>';
				$this->data['success'][] = '<a href="' . SITE_URL . '/admin/menus_manager/add_item/menu_id=' . $this->url['params']['added'] . '">Перейти к добавлению элементов меню</a>';
			} elseif($this->url['params']['success']=='edit' && isset($this->url['params']['edited'])) {
				$menu = $this->model->get_menu($this->url['params']['edited']);
				$this->data['success'][] = 'Меню "' . $menu['name'] . '" обновлено<br>';
				$this->data['success'][] = '<a href="' . SITE_URL . '/admin/menus_manager/edit/' . $this->url['params']['edited'] . '">Продолжить редактирование</a>';
				$this->data['success'][] = '<a href="' . SITE_URL . '/admin/menus_manager/add_item/menu_id=' . $this->url['params']['edited'] . '">Перейти к добавлению элементов меню</a>';
			} elseif($this->url['params']['success']=='deleted') {
				$this->data['success'][] = 'Меню удалено';
			}
		}
		
		$this->data['menus'] = $this->model->get_menus_list();
		
		$this->data['page_name'] = 'Менеджер меню';
		$page['title'] = 'Меню сайта';
		$page['keywords'] = 'Меню сайта';
		$page['description'] = 'Меню сайта';
		$page['html'] = $this->load_view();
		
		return $page;
	}
	
	public function action_add() {
	
		$this->data['errors'] = array();
		$this->data['success'] = array();
		$this->data['notices'] = array();
		
		$menu = array();
		
		if(isset($_POST['menu_name'])) {
			if(!empty($_POST['menu_name'])) {
				$menu['name'] = $_POST['menu_name'];
			} else {
				$menu['name'] = '';
				$this->data['errors'][] = 'Не указано название меню';
			}
		} else {
			$menu['name'] = '';
		}
		
		if(isset($_POST['menu_class'])) {
			$menu['class'] = $_POST['menu_class'];
		} else {
			$menu['class'] = '';
		}
		
		if(isset($_POST['menu_pos'])) {
			$menu['position'] = $_POST['menu_pos'];
		} else {
			$menu['position'] = '';
		}
		
		if(!$this->data['errors'] && isset($_POST['submit'])) {
			if($menu_id = $this->model->add_menu($menu)) {
				// добавляем блок меню
				if(isset($_POST['menu_act']) && $_POST['menu_act']==1 && !empty($menu['position'])) {
					$this->load_model('component', 'modules_manager');
					
					$module_block_menu = array();
					
					$installed_modules = $this->model_component_modules_manager->get_installed_modules();
					
					foreach($installed_modules as $module) {
						if($module['dir'] == 'menu' && $module['type'] == 'block') {
							$module_block_menu = $module;
							break;
						}
					}
					
					if($module_block_menu) {
						$block_menu = array(
							'name'       => $menu['name'],
							'type'       => 'block',
							'module_id'  => $module_block_menu['id'],
							'module_dir' => $module_block_menu['dir'],
							'params'     => serialize($menu_id),
							'sections'   => null,
							'position'   => $menu['position'],
							'back_end'   => 0,
							'sort'       => 1
						);
						
						$this->model_component_modules_manager->activate_module($block_menu);
					}
				}
				
				$this->redirect(SITE_URL . '/admin/menus_manager/success=add/added=' . $menu_id);
				
			} else {
				$this->data['notices'][] = 'Не удалось добавить меню.';
			}
		}
		
		$this->data['menu'] = $menu;
		
		$this->data['page_name'] = 'Добавление нового меню';
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs($this->data['page_name'], '');
		$this->data['text_submit'] = 'Добавить';
		$page['title'] = 'Добавление нового меню';
		$page['keywords'] = 'Добавление нового меню';
		$page['description'] = 'Добавление нового меню';
		$page['html'] = $this->load_view('form');
		
		return $page;
	}
	
	public function action_edit() {
	
		$this->data['errors'] = array();
		$this->data['success'] = array();
		$this->data['notices'] = array();
		
		$menu = array();
		
		if(isset($this->url['actions'][1])) {
			$menu['id'] = $this->url['actions'][1];
		} else {
			$this->redirect(SITE_URL . '/admin/menus_manager');
		}
		
		if(isset($_POST['menu_name'])) {
			if(!empty($_POST['menu_name'])) {
				$menu['name'] = $_POST['menu_name'];
			} else {
				$menu['name'] = '';
				$this->data['errors'][] = 'Не указано название меню';
			}
		} else {
			$menu['name'] = '';
		}
		
		if(isset($_POST['menu_class'])) {
			$menu['class'] = $_POST['menu_class'];
		} else {
			$menu['class'] = '';
		}
		
		if(isset($_POST['menu_pos'])) {
			$menu['position'] = $_POST['menu_pos'];
		} else {
			$menu['position'] = '';
		}
		
		if(!$this->data['errors'] && isset($_POST['submit'])) {
			if($this->model->edit_menu($menu)) {
				$this->redirect(SITE_URL . '/admin/menus_manager/success=edit/edited=' . $menu['id']);
			} else {
				$this->data['notices'][] = 'Не удалось сохранить изменения меню.';
			}
		} else {
			$menu = $this->model->get_menu($menu['id']);
		}
		
		$this->data['menu'] = $menu;
		
		$this->data['page_name'] = 'Редактирования меню "' . $menu['name'] . '"';
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs($menu['name'], '');
		$this->data['text_submit'] = 'Сохранить изменения';
		$page['title'] = 'Добавление нового меню';
		$page['keywords'] = 'Добавление нового меню';
		$page['description'] = 'Добавление нового меню';
		$page['html'] = $this->load_view('form');
		
		return $page;
	}
		
	public function action_delete() {
		if(!isset($this->url['actions'][1])) {
			$this->redirect(SITE_URL . '/admin/menus_manager');
		}
		
		$items = $this->model->get_menu_items($this->url['actions'][1]);
		foreach($items as $item) {
			$this->model->delete_menu_item($item['id']);
		}
		
		$this->model->delete_menu($this->url['actions'][1]);
		
		$this->redirect(SITE_URL . '/admin/menus_manager/success=deleted');
	}
	
	public function action_menu() {		
		if(!isset($this->url['actions'][1])) {
			$this->redirect(SITE_URL . '/admin/menus_manager');
		}
		
		$this->data['errors'] = array();
		$this->data['success'] = array();
		$this->data['notices'] = array();
		if(isset($this->url['params']['success'])) {
			if($this->url['params']['success']=='del') {
				$this->data['success'][] = 'Элемент меню удален';
			} elseif($this->url['params']['success']=='add') {
				$this->data['success'][] = 'Элемент добавлен';
			}elseif($this->url['params']['success']=='edit') {
				$this->data['success'][] = 'Изменения сохранены';
			}
		}
		
		$menu_id = $this->url['actions'][1];
		
		$this->data['menu'] = $this->model->get_menu($menu_id);
		$this->data['items'] = $this->model->get_menu_items($menu_id, array('tree'=>true, 'parent_id'=>0, 'sort'=>'sort ASC'));
		
		$this->data['menu_table_body'] = $this->build_menu_table($this->data['items']);
		$this->data['page_name'] = 'Элементы меню "' . $this->data['menu']['name'] . '"';
		//$this->data['text_submit'] = 'Сохранить изменения';
		$page['title'] = 'Элементы меню "' . $this->data['menu']['name'] . '"';
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs( $this->data['menu']['name'], '');
		$page['keywords'] = 'Элементы меню "' . $this->data['menu']['name'] . '"';
		$page['description'] = 'Элементы меню "' . $this->data['menu']['name'] . '"';
		$page['html'] = $this->load_view('items');
		return $page;
	}
	
	public function action_add_item() {
		/*
		if(!isset($this->url['actions']['params'])) {
			$this->redirect(SITE_URL . '/admin/menus');
		}
		*/
		$item = array();
		
		if(isset($this->url['params']['menu_id'])) {
			$item['menu_id'] = $this->url['params']['menu_id'];
		} else {
			$this->redirect(SITE_URL . '/admin/menus_manager');
		}
		$this->data['errors'] = array();
		$this->data['success'] = array();
		$this->data['notices'] = array();
		
		if(isset($_POST['item_name'])) {
			if(!empty($_POST['item_name'])) {
				$item['name'] = $_POST['item_name'];
			} else {
				$item['name'] = '';
				$this->data['errors'][] = 'Не указано название элемента меню';
			}
		} else {
			$item['name'] = '';
		}
		
		if(isset($_POST['item_url'])) {
			if(!empty($_POST['item_url'])) {
				$item['url'] = $_POST['item_url'];
			} else {
				$item['url'] = '';
				$this->data['errors'][] = 'Не указан урл';
			}
		} else {
			$item['url'] = '';
		}
		
		if(isset($_POST['item_sort'])) {
			$item['sort'] = $_POST['item_sort'];
		} else {
			$item['sort'] = 0;
		}
		
		if(isset($_POST['parent_id'])) {
			$item['parent_id'] = $_POST['parent_id'];
		} else {
			$item['parent_id'] = 0;
		}
		
		if(!$this->data['errors'] && isset($_POST['submit'])) {
			if($item_id = $this->model->add_menu_item($item)) {
				$this->redirect(SITE_URL . '/admin/menus_manager/menu/'.$item['menu_id'].'/success=add/added=' . $item_id);
				
			} else {
				$this->data['notices'][] = 'Не удалось добавить элемент меню.';
			}
		}
		
		$this->data['items'] = $this->model->get_items_list($item['menu_id']);
		$this->data['item'] = $item;
		
		$this->data['menu'] = $this->model->get_menu($item['menu_id']);
		$this->data['page_name'] = 'Добавление элемента в меню "' . $this->data['menu']['name'] . '"';
		$this->data['text_submit'] = 'Добавить';
		
		$page['title'] = 'Добавление элемента в меню "' . $this->data['menu']['name'] . '"';
		$page['keywords'] = 'Добавление элемента в меню "' . $this->data['menu']['name'] . '"';
		$page['description'] = 'Добавление элемента в меню "' . $this->data['menu']['name'] . '"';
		$page['html'] = $this->load_view('item_form');
		return $page;
	}
	
	public function action_edit_item() {
		
		if(isset($this->url['actions'][1])) {
			$item_id = $this->url['actions'][1];
		} else {
			$this->redirect(SITE_URL . '/admin/menus_manager');
		}
		
		$this->data['errors'] = array();
		$this->data['success'] = array();
		$this->data['notices'] = array();
		
		$item = $this->model->get_menu_item($item_id);
		
		if(isset($_POST['item_name'])) {
			if(!empty($_POST['item_name'])) {
				$item['name'] = $_POST['item_name'];
			} else {
				$this->data['errors'][] = 'Не указано название элемента меню';
			}
		} 
		
		if(isset($_POST['item_url'])) {
			if(!empty($_POST['item_url'])) {
				$item['url'] = $_POST['item_url'];
			} else {
				$this->data['errors'][] = 'Не указан урл';
			}
		}
		
		if (isset($_POST['parent_id']) && $_POST['parent_id'] != $item['parent_id']) {
			$count_items_sort = true;
			$item['parent_id'] = $_POST['parent_id'];
		} else {
			$count_items_sort = false;
		}
		
		if(!$this->data['errors'] && isset($_POST['submit'])) {
			if($item_id = $this->model->edit_menu_item($item)) {
				if ($count_items_sort) {
					$this->model->count_items_sort($item['menu_id'], 0); // пересчитываем порядок сортировки, родитель изменился
				}
				$this->redirect(SITE_URL . '/admin/menus_manager/menu/'.$item['menu_id'].'/success=edit');
			} else {
				$this->data['notices'][] = 'Не удалось сохранить изменения.';
			}
		}
		
		$this->data['items'] = $this->model->get_items_list($item['menu_id'], 0, true, array(), $item['id']); // исключаем из списка выводимый элемент и его дочерние элементы
		$this->data['item'] = $item;
	
		$this->data['menu'] = $this->model->get_menu($item['menu_id']);
		$this->data['page_name'] = 'Изменение элемента меню "' . $this->data['menu']['name'] . '"';
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs(
			array($this->data['menu']['name'], $item['name']),
			array(SITE_URL . '/admin/' . $this->url['component'] . '/edit/' . $item['menu_id'], '')
		);
		$this->data['text_submit'] = 'Сохранить изменения';
		$page['title'] = 'Изменение элемента меню "' . $this->data['menu']['name'] . '"';
		$page['keywords'] = 'Изменение элемента меню "' . $this->data['menu']['name'] . '"';
		$page['description'] = 'Изменение элемента меню "' . $this->data['menu']['name'] . '"';
		$page['html'] = $this->load_view('item_form');
		return $page;
	}
	
	public function action_delete_item() {
		if(isset($this->url['actions'][1])) {
			$item_id = $this->url['actions'][1];
		} else {
			$this->redirect(SITE_URL . '/admin/menus_manager');
		}
		
		$this->model->delete_menu_item($item_id);
		
		if(isset($this->url['params']['menu_id'])) {
			$this->redirect(SITE_URL . '/admin/menus_manager/menu/' . (int)$this->url['params']['menu_id'] . '/success=del');
		} else {
			$this->redirect(SITE_URL . '/admin/menus_manager');
		}
		
	}
	
	public function action_change_item_sort() {
		$this->page = array();
		$this->page['theme']['file'] = 'ajax';
		$this->page['html'] = 0;
		
		if (isset($this->url['params']['item_id']) && isset($this->url['params']['direction'])) {
			$result = $this->model->change_item_sort($this->url['params']['item_id'], $this->url['params']['direction']);
			
			if ($result) {
				$this->page['html'] = 1;
			}
		}
		
		return $this->page;
	}
	
	protected function build_menu_table($items, $level = 1) {
		if (!isset($menu)) {
			static $menu = '';
		}
		
		foreach ($items as $item) {
			if ($item['children']) {
				$menu .= '<tr class="parent-row" data-item-id="' . $item['id'] . '">';
			} else {
				$menu .= '<tr data-item-id="' . $item['id'] . '">';
				
			}
				$menu .= '<td class="page_name" style="padding-left: ' . $level * 10 . 'px;">' . $item['name'] . '</td>';
				$menu .= '<td class="td_170">' . $item['url'] . '</td>';
				$menu .= '<td class="sort td_115"><span class="before">↑</span> <span class="after">↓</span></td>';
				$menu .= '<td class="td_190 actions">';
					$menu .= '[<a href="' . SITE_URL . '/admin/menus_manager/edit_item/' . $item['id'] . '">изменить</a> | ';
					$menu .= '<a class="confirmButton" href="' . SITE_URL . '/admin/menus_manager/delete_item/' . $item['id'] . '/menu_id=' . $item['menu_id'] . '">удалить</a>]';
				$menu .= '</td>';
			$menu .= '</tr>';
			
			if ($item['children']) {
				$menu .= '<tr class="child"><td colspan="4" style="padding: 0;"><div><table style="border: 0;">';
				$this->build_menu_table($item['children'], $level + 1);
				$menu .= '</table></div></td></tr>';
			}
		}
		
		return $menu;
	}
	
	protected function tree_to_list($items, $parent_name = '') {
		foreach ($items as $item) {
			if (isset($item['full_name'])) {
				$item['full_name'] .= ' > ' . $item['name'];
			}
		}
		
		return $items;
	}
}