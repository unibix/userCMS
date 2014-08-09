<?php 

class controller_component_core_news extends component {
	
	public function action_index() {
		if (file_exists($this->view_dir . '/news.css')) {
			$css = SITE_URL . '/modules/components/' . $this->component_name . '/front_end/views/news.css';
		} else {
			$css = SITE_URL . '/user_cms/modules/components/' . $this->component_name . '/front_end/views/news.css';
		}
		$this->page['head'] = $this->add_css_file($css);
		
		// выводим 5 последних новостей 
		
		$component_info = $this->model->get_component_info($this->component_name);
		
		$params = array(
			'sort' => 'i.date_edit DESC',
			'join' => 'category_url',
			'limit' => $this->component_config['main_page_count']
		);
		$this->data['news_items'] = array();
		$results = $this->model->get_news(0, $params);
		
		foreach($results as $result) {
			$this->data['news_items'][$result['id']] = array(
				'name' => $result['name'],
				'href' => SITE_URL . '/' . $component_info['url'] . '/' . $result['cat_url'] . '/' . $result['url'],
				'preview' => $result['preview'],
				'date_add' => date('d.m.Y H:i', $result['date_add'])
			);
		}
		
		$this->data['page_name'] = $component_info['name'];
		$this->data['bread_crumbs'] = '<a href="' . SITE_URL . '">Главная</a> &#8594 ';
		$this->data['bread_crumbs'] .= '<a href="' . SITE_URL . '/' . $this->url['component'] . '">' . $component_info['name'] . '</a>';
		$this->page['title'] = $component_info['title'];
		$this->page['keywords'] = $component_info['keywords'];
		$this->page['description'] = $component_info['description'];
		$this->page['html'] = $this->load_view('news_list');
		return $this->page;
	}
	
	public function action_else() {
		if (file_exists($this->view_dir . '/news.css')) {
			$css = SITE_URL . '/modules/components/' . $this->component_name . '/front_end/views/news.css';
		} else {
			$css = SITE_URL . '/user_cms/modules/components/' . $this->component_name . '/front_end/views/news.css';
		}
		$this->page['head'] = $this->add_css_file($css);
		
		$component_info = $this->model->get_component_info($this->component_name);
		$this->data['bread_crumbs'] = '<a href="' . SITE_URL . '">Главная</a>';
		$view = 'index';
		$not_found = false;
		
		$params = array(
			'type' => 'by_url'
		);
		$category = $this->model->get_category($this->url['actions'][0], $params);
		
		if($category) {
			
			$href = SITE_URL . '/' . $component_info['url'];
			$this->data['bread_crumbs'] .= ' &#8594 <a href="' . $href . '">' . $component_info['name'] . '</a>';
			$href .= '/' . $category['url'];
			$this->data['bread_crumbs'] .= ' &#8594 <a href="' . $href . '">' . $category['name'] . '</a>';
			
			if(!isset($this->url['actions'][1])) {
			
				// страница категории
				$this->page['title'] = $category['title'];
				$this->page['keywords'] = $category['keywords'];
				$this->page['description'] = $category['description'];
				$this->data['page_name'] = $category['name'];
				
				$params = array(
					'type' => 'by_category' 
				);
				
				$this->data['news_items'] = array();
				$results = $this->model->get_news($category['id'], $params);
				
				foreach($results as $result) {
					$this->data['news_items'][$result['id']] = array(
						'name' => $result['name'],
						'href' => SITE_URL . '/' . $component_info['url'] . '/' . $category['url'] . '/' . $result['url'],
						'preview' => $result['preview'],
						'date_add' => date('d.m.Y H:i', $result['date_add'])
					);
				}

				$view = 'news_list';
				
			} else {
			
				// страница новости
				$params = array(
					'type' => 'by_url'
				);
				$item = $this->model->get_news_item($this->url['actions'][1], $params);
				if($item) {

					$href .= '/' . $item['url'];
					$this->data['bread_crumbs'] .= ' -> <a href="' . $href . '">' . $item['name'] . '</a>';
					$this->data['page_name'] = $item['name'];
					$this->page['title'] = $item['title'];
					$this->page['keywords'] = $item['keywords'];
					$this->page['description'] = $item['description'];
					$this->data['page_name'] = $item['name'];
					$this->data['content'] = $item['text'];
					
				} else {
					$not_found = true;
				}
			}
			
		} else {
			$not_found = true;
		}
		
		if($not_found) {
			$this->page['title'] = '404!!1';
			$this->page['keywords'] = 'Страница не найдена';
			$this->page['description'] = 'Страница не найдена';
			$this->action_404();
			$view = 'index';
		} else {
			
		}
		$this->page['html'] = $this->load_view($view);
		return $this->page;
	}
	
	protected function news_category() {
	
	}
	
	protected function news_items() {
	
	}
}