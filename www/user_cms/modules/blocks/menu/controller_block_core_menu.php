<?php 

class controller_block_core_menu extends block {
	
	public function action_index($block) {
		$menu_id = unserialize($block['params']);
		
		$this->load_model('component', 'pages');
		
		$menu = $this->dbh->row("SELECT * FROM menus WHERE id = '" . (int)$menu_id . "'");
		
		$items = $this->get_menu_tree($menu['id'], 0);

		$this->menu = '';
		$this->generate_menu($items, $menu['class']);
		
		$page['head'] = '';
		$page['html'] = $this->menu;
		return $page;
	}
	
	public function action_activate() {
		$page = array();
		
		if(isset($_POST['activate'])) {
			$page['params'] = serialize($_POST['menu']);
		}
		
		$this->data['menus'] = $this->dbh->query("SELECT * FROM menus ORDER BY id ASC");
		$page['html'] = $this->load_view('activate');
		return $page;
	}
	
	protected function is_active($url) {
		$request_uri = str_replace(SITE_URL, '','http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); // формируем request_uri с учетом того, что сайт может находиться не в корневой директории
		if ($request_uri == $url || SITE_URL . $request_uri == $url 
		  || ($url !== SITE_URL . '/' && (strpos(SITE_URL . $request_uri, $url) === 0 || strpos($request_uri, $url) === 0))) {
			return true;
		}
		return false;
	}
	
	protected function get_menu_tree($menu_id, $parent_id) {
		$items = array();
		
		$results = $this->dbh->query("SELECT * FROM menus_items WHERE menu_id = '" . (int)$menu_id . "' AND parent_id = '" . (int)$parent_id . "' ORDER BY sort ASC, id ASC");

		foreach($results as $result) {
			$items[$result['id']] = $result;
			$items[$result['id']]['children'] = $this->get_menu_tree($menu_id, $result['id']);
		}
		
		return $items;
	}
	
	protected function generate_menu($items, $class = '') {
		if ($class) {
			$this->menu .= '<ul class="' . $class . '">';
		} else {
			$this->menu .= '<ul>';
		}

		foreach($items as $item) {
			if (strpos($item['url'], '/') === 0) {
				$item['url'] = SITE_URL . $item['url'];
			} elseif (strpos($item['url'], '%') === 0) {
				// ссылка на страницу page_id
				$page_id = (int)str_replace('%', '', $item['url']);
				
				$item['url'] = SITE_URL . $this->model_component_pages->get_page_url($page_id);
				
				if ($item['url'] === null) {
					$item['url'] = SITE_URL;
				}
			}
			if ($this->is_active($item['url'])) {
				$this->menu .= '<li class="current"><a href="' . $item['url'] . '">' . $item['name'] . '</a>';
			} else {
				$this->menu .= '<li><a href="' . $item['url'] . '">' . $item['name'] . '</a>';
			}
			
			if ($item['children']) {
				$this->generate_menu($item['children']);
			}
			
			$this->menu .= '</li>';
		}
		
		$this->menu .= '</ul>';
	}

}
