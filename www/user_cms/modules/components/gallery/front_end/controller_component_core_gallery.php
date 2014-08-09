<?php 

class controller_component_core_gallery extends component {
	
	public function action_index() {
		if (file_exists($this->view_dir . '/gallery.css')) {
			$css = SITE_URL . '/modules/components/' . $this->component_name . '/front_end/views/gallery.css';
		} else {
			$css = SITE_URL . '/user_cms/modules/components/' . $this->component_name . '/front_end/views/gallery.css';
		}
		$this->page['head'] = $this->add_css_file($css);

		$gallery_info = $this->model->get_component_info('gallery');
		$view = 'categories';
		$not_found = false;
		$categories = $this->model->get_categories();
		
		foreach($categories as $key => $category) {
			if($category['image']){
				$categories[$key]['image'] = SITE_URL . '/uploads/images/gallery/' . $category['dir'] . '/mini/' . $category['image'];
				$categories[$key]['full'] = SITE_URL . '/uploads/images/gallery/' . $category['dir'] . '/' . $category['image'];
			}
			$categories[$key]['href'] = SITE_URL . '/' . $gallery_info['url'] . '/' . $category['url'];
		}
		$this->data['categories'] = $categories;
		
		if($not_found) {
			$this->page['title'] = '404!!1';
			$this->page['keywords'] = 'Страница не найдена';
			$this->page['description'] = 'Страница не найдена';
			$this->action_404();
			$view = 'index';
		} else {
			$this->page['title'] = $gallery_info['title'];
			$this->page['keywords'] = $gallery_info['keywords'];
			$this->page['description'] = $gallery_info['description'];
			$this->data['page_name'] = $gallery_info['name'];
			$this->data['bread_crumbs'] = '';
		}
		
		$this->data['category_thumb_width'] = $this->component_config['category_thumb_width'];
		$this->data['category_thumb_height'] = $this->component_config['category_thumb_height'];

		$this->page['html'] = $this->load_view($view);
		return $this->page;
	}
	
	public function action_else() {
		if (file_exists($this->view_dir . '/gallery.css')) {
			$css = SITE_URL . '/modules/components/' . $this->component_name . '/front_end/views/gallery.css';
		} else {
			$css = SITE_URL . '/user_cms/modules/components/' . $this->component_name . '/front_end/views/gallery.css';
		}
		$this->page['head'] = $this->add_css_file($css);
		
		$view = 'category';
		$not_found = false;
		
		$category = $this->model->get_category_by_url($this->url['actions'][0]);
		if($category) {
		
			$this->data['category'] = $category;
			
			$items = $this->model->get_items($category['id']);
			foreach($items as $key => $item) {
				$items[$key]['image'] = SITE_URL . '/uploads/images/gallery/' . $category['dir'] . '/mini/' . $item['image'];
				$items[$key]['full'] = SITE_URL . '/uploads/images/gallery/' . $category['dir'] . '/' . $item['image'];
			}
			
			$this->data['items'] = $items;
			
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
			$this->page['title'] = $category['title'];
			$this->page['keywords'] = $category['keywords'];
			$this->page['description'] = $category['description'];
			$this->data['page_name'] = $category['name'];
			$this->data['bread_crumbs'] = '';
		}
		
		$this->data['item_thumb_width'] = $this->component_config['item_thumb_width'];
		$this->data['item_thumb_height'] = $this->component_config['item_thumb_height'];

		$this->page['html'] = $this->load_view($view);
		return $this->page;
	}
}