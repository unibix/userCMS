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
			'sort' => 'i.date_edit DESC, i.date_add DESC, i.id DESC',
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
		$this->page['html'] = $this->load_view('main');
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
		
		$new_flag = false;
		$category_url = $this->url['actions'][count($this->url['actions'])-1];
		$category = $this->model->get_category($this->url['actions'][count($this->url['actions'])-1], $params); //это - категория
		
		if ((!$category) AND (count($this->url['actions'])>1)) {
			$category = $this->model->get_category($this->url['actions'][count($this->url['actions'])-2], $params); // это - новость
			$category_url = $this->url['actions'][count($this->url['actions'])-2];
			$new_flag = true;
		}


		//echo (count($this->url['actions']));
		//echo ($this->url['actions'][count($this->url['actions'])-2]);
		//print_r($category);
		
		if (($category) AND ($category_full_url = $this->model->get_category_full_url($category['id'])) ){ //Последнее неверно в случае, если категории зациклены
			

			//echo '<pre>';
			//print_r($category_full_url);
			//echo '</pre>';
			
			$href = SITE_URL . '/' . $component_info['url'];
			$this->data['bread_crumbs'] .= ' &#8594 <a href="' . $href . '">' . $component_info['name'] . '</a>';
			for ($key = count($category_full_url['urls'])-1; $key>=0; $key--){
				$href .= '/' . $category_full_url['urls'][$key];
				$this->data['bread_crumbs'] .= ' &#8594 <a href="' . $href . '">' . $category_full_url['names'][$key] . '</a>';
			}
			//$href .= '/' . $category['url'];
			//$this->data['bread_crumbs'] .= ' &#8594 <a href="' . $href . '">' . $category['name'] . '</a>';
			
			
			//if(!isset($this->url['actions'][1])) {
			if(!$new_flag) {
				// страница категории
				$this->page['title'] = $category['title'];
				$this->page['keywords'] = $category['keywords'];
				$this->page['description'] = $category['description'];
				$this->data['page_name'] = $category['name'];
				
				//print_r($this->component_config['index_page_count']);
				$count_news_on_page = $this->component_config['index_page_count'];
				$start_news_number = isset($this->url['params']['page']) ? ($this->url['params']['page']-1) * $count_news_on_page : 0;
				
				$params = array(
					'type' => 'by_category',
					'limit' => $start_news_number . ', ' . $count_news_on_page
				);
				
				$count_news = $this->model->get_count_news($category['id']);
				$count_news = $count_news ? $count_news[0]['count_news'] : 0;
				$count_pages = ceil($count_news/$count_news_on_page);
				if ($count_pages<2) $count_pages=0;
				
				$this->data['count_pages'] = $count_pages;
				$this->data['this_page'] = isset($this->url['params']['page']) ? ($this->url['params']['page']) : 1;
								
				$this->data['news_items'] = array();
				$results = $this->model->get_news($category['id'], $params);
				
				$this->data['full_category_url'] = strpos($this->url['request_uri'], '/page=') ? substr($this->url['request_uri'], 0, strpos($this->url['request_uri'], '/page=')) : $this->url['request_uri'];
				//print_r($this->data['full_category_url']);
				
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
				//$item = $this->model->get_news_item($this->url['actions'][1], $params);
				$item = $this->model->get_news_item($this->url['actions'][count($this->url['actions'])-1], $params);
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