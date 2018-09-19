<?php 
/**
* класс текстовых страниц
*/
class controller_component_core_pages extends component {
	
	public function action_index() {
		
		$page_info = $this->model->get_page('/');
		$this->set_global_data('page_id', 1);
		$this->data['page_name'] = $page_info['name'];
		$this->data['content'] = $page_info['text'];
		$this->page['title'] = $page_info['title'];
		$this->page['keywords'] = $page_info['keywords'];
		$this->page['description'] = $page_info['description'];
		
		$view = !empty($page_info['view']) ? $page_info['view'] : $this->view;
		if (!empty($page_info['theme_view'])) {
			$this->page['theme']['file'] = $page_info['theme_view'];
		}
		
		$this->page['head'] = $this->add_css_file(SITE_URL . '/user_cms/modules/components/pages/front_end/views/content.css');
		$this->page['html'] = $this->load_view($view);
		return $this->page;
	}
	// вывод страниц за исключением главной
	public function action_else() {
		$this->load_helper('breadcrumbs');
		$not_found = false;
		
		$this->helper_breadcrumbs->add('Главная', SITE_URL);
		$url = SITE_URL;
		if($this->url['actions'][0] == 'index') {
			$page_info = $this->model->get_page($this->url['component']);
			$url .= '/' . $page_info['url'];
			
			$this->helper_breadcrumbs->add($page_info['name'], $url);
			
		} else {
			$first = $this->model->get_main_info($this->url['component']);
			$parent_id = $first['id'];
			$url .= '/' . $first['url'];
			$this->helper_breadcrumbs->add($first['name'], $url);
			
			foreach($this->url['actions'] as $i => $action) {
				$main_info = $this->model->get_main_info($action, $parent_id);
				if($main_info) {
					$url .= '/' . $main_info['url'];
					
					$this->helper_breadcrumbs->add($main_info['name'], $url);
				
					$parent_id = $main_info['id'];
					if(isset($this->url['actions'][$i++])) { // это нужная нам страница
						$page_info = $this->model->get_page($main_info['url'], $main_info['parent_id']);
					}
				} else {
					$not_found = true;
					break;
				}
			}
		}
		
		if($not_found) {
			$this->page = $this->action_404('404_not_found');
			return $this->page;
		} else {
			$this->set_global_data('page_id', $page_info['id']);
			
			$this->data['page_name'] = $page_info['name'];
			$this->data['content'] = $page_info['text'];
			$this->page['title'] = $page_info['title'];
			$this->page['keywords'] = $page_info['keywords'];
			$this->page['description'] = $page_info['description'];
			$view = !empty($page_info['view']) ? $page_info['view'] : $this->view;
			if (!empty($page_info['theme_view'])) {
				$this->page['theme']['file'] = $page_info['theme_view'];
			}
			if ($this->view == 'children_menu' or $this->view == 'children_menu_in_bottom') {
				$this->data['children'] = array();
				
				$results = $this->model->get_pages_by_parent_id($page_info['main_id']);
				
				foreach ($results as $result) {
					$this->data['children'][] = array(
						'name' => $result['name'],
						'href' => SITE_URL . $this->url['request_uri'] . '/' . $result['url']
					);
				}
			}
		}
		
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->render();
		$this->page['html'] = $this->load_view($view);
		return $this->page;
	}
	
}