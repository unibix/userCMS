<?php

class controller_component_core_gallery extends component {
	
	public function action_index() {
		if (isset($_SESSION['success'])) {
			$this->data['success'] = $_SESSION['success'];
			unset($_SESSION['success']);
		} else {
			$this->data['success'] = false;
		}
		
		if(isset($_FILES['image'])) {
			$this->load_helper('image');
			
			$img_path = ROOT_DIR . '/uploads/gallery/';
			$filename = $this->helper_image->img_upload('image', 800, $img_path, 200, 200);
		}
		
		$this->data['categories'] = $this->model->get_categories();
		
		$this->data['page_name'] = 'Галерея';
		$this->page['title'] = 'Галерея';
		$this->page['keywords'] = 'Галерея';
		$this->page['description'] = 'Галерея';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view();
		return $this->page;
	}
	
	public function action_add() {
		
		$this->data['errors'] = array();
		$this->data['notices'] = array();
		$this->data['success'] = array();
		
		$this->load_helper('image');
		
		$this->data['image'] = '';
		
		if(isset($_POST['name'])){
			$this->data['name'] = $_POST['name'];
			if(empty($this->data['name'])){
				$this->data['errors'][] = 'Не указано название категории';
			}
		} else {
			$this->data['name'] = '';
		}
		
		if(isset($_POST['text'])){
			$this->data['text'] = $_POST['text'];
		} else {
			$this->data['text'] = '';
		}
		
		if(isset($_POST['preview'])){
			if(!empty($_POST['preview'])) {
				$this->data['preview'] = $_POST['preview'];
			} else {
				$this->data['preview'] = substr(strip_tags($_POST['text']), 0, 300);
			}
		} else {
			$this->data['preview'] = '';
		}
				
		if(isset($_POST['title']) && !empty($_POST['title'])){
			$this->data['title'] = $_POST['title'];
		} else {
			$this->data['title'] = $this->data['name'];
		}
						
		if(isset($_POST['keywords']) && !empty($_POST['keywords'])){
			$this->data['keywords'] = $_POST['keywords'];
		} else {
			$this->data['keywords'] = $this->data['name'];
		}
								
		if(isset($_POST['description']) && !empty($_POST['description'])){
			$this->data['description'] = $_POST['description'];
		} else {
			$this->data['description'] = $this->data['name'];
		}
										
		if(isset($_POST['url']) && !empty($_POST['url'])){
			$this->data['url'] = $this->str2url($_POST['url']);
		} elseif(isset($_POST['url']) && empty($_POST['url'])) {
			$this->data['url'] = $this->str2url($this->data['name']);
		} else {
			$this->data['url'] = '';
		}
		
		if(isset($_POST['dir'])) {
			if(!empty($_POST['dir'])) {
				$this->data['dir'] = $this->str2url($_POST['dir']);
			} else {
				$this->data['dir'] = $this->str2url($this->data['name']);
			}
			if(is_dir(ROOT_DIR . '/uploads/images/gallery/' . $this->data['dir'])){
				$this->data['errors'][] = 'Папка с таким названием уже существует';
			}
		} else {
			$this->data['dir'] = '';
		}
		
		
		
		if(isset($_POST['submit_gallery']) && !$this->data['errors']){
		
			$upload_dir = ROOT_DIR . '/uploads/images/gallery/' . $this->data['dir'];
			
			mkdir($upload_dir);
			mkdir($upload_dir . '/mini');
			
			if(is_uploaded_file($_FILES['image']['tmp_name'])) {
				if ($this->component_config['category_thumb_width'] > $this->component_config['category_image_width']) {
					$mini_width = $this->component_config['category_thumb_width'];
					$mini_height = $this->component_config['category_thumb_height'];
				} else {
					$mini_width = $this->component_config['category_image_width'];
					$mini_height = round($mini_width / ($this->component_config['category_thumb_width'] / $this->component_config['category_thumb_height']));
				}
				
				$this->data['image'] = $this->helper_image->img_upload('image', $this->component_config['category_full_width'], $upload_dir . '/', $mini_width, $mini_height, $this->component_config['category_full_height']);
			} else {
				$this->data['image'] = '';
			}
			
			$cat_id = $this->model->add_category($this->data);

			$redirect = SITE_URL . '/admin/gallery/success=added/cat_id=' . $cat_id;
			$this->redirect($redirect);
		}
		
		$this->data['page_name'] = 'Добавить категорию';
		$this->data['text_submit'] = 'Добавить категорию';
		$this->page['title'] = 'Добавить категорию';
		$this->page['keywords'] = 'Добавить категорию';
		$this->page['description'] = 'Добавить категорию';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('form');
		return $this->page;
	}
	
	public function action_edit() {
		
		if(!isset($this->url['actions'][1])) {
			$this->redirect(SITE_URL . '/admin/gallery');
		}
	
		$this->data = $this->model->get_category($this->url['actions'][1]);
		
		if(!$this->data) {
			$this->redirect(SITE_URL . '/admin/gallery');
		}
		
		$this->data['errors'] = array();
		$this->data['notices'] = array();
		$this->data['success'] = array();
		
		$this->load_helper('image');
		
		if(isset($_POST['name'])){
			$this->data['name'] = $_POST['name'];
			if(empty($this->data['name'])){
				$this->data['errors'][] = 'Не указано название категории';
			}
		}
		
		if(isset($_POST['text'])){
			$this->data['text'] = $_POST['text'];
		}
		
		if(isset($_POST['preview'])){
			if(!empty($_POST['preview'])) {
				$this->data['preview'] = $_POST['preview'];
			} else {
				$this->data['preview'] = substr(strip_tags($_POST['text']), 0, 300);
			}
		}
				
		if(isset($_POST['title']) && !empty($_POST['title'])){
			$this->data['title'] = $_POST['title'];
		}
						
		if(isset($_POST['keywords']) && !empty($_POST['keywords'])){
			$this->data['keywords'] = $_POST['keywords'];
		}
								
		if(isset($_POST['description']) && !empty($_POST['description'])){
			$this->data['description'] = $_POST['description'];
		}
										
		if(isset($_POST['url']) && !empty($_POST['url'])){
			$this->data['url'] = $this->str2url($_POST['url']);
		} elseif(isset($_POST['url']) && empty($_POST['url'])) {
			$this->data['url'] = $this->str2url($this->data['name']);
		}
		
		//$this->data['dir'] = false;
		
		if(isset($_POST['submit_gallery']) && !$this->data['errors']){

			$upload_dir = ROOT_DIR . '/uploads/images/gallery/' . $this->data['dir'];
			
			if (isset($_POST['image'])) {
				$this->model->delete_image($this->data['image'], $this->data['dir']);
				$this->data['image'] = $_POST['image'];
			} 
			
			if(is_uploaded_file($_FILES['image']['tmp_name'])) {
				if ($this->component_config['category_thumb_width'] > $this->component_config['category_image_width']) {
					$mini_width = $this->component_config['category_thumb_width'];
					$mini_height = $this->component_config['category_thumb_height'];
				} else {
					$mini_width = $this->component_config['category_image_width'];
					$mini_height = round($mini_width / ($this->component_config['category_thumb_width'] / $this->component_config['category_thumb_height']));
				}
				
				$this->data['new_image'] = $this->helper_image->img_upload('image', $this->component_config['category_full_width'], $upload_dir . '/', $mini_width, $mini_height, $this->component_config['category_full_height']);
			} else {
				$this->data['new_image'] = '';
			}
			
			$this->model->edit_category($this->data);

			$redirect = SITE_URL . '/admin/gallery/success=edited/cat_id=' . $this->data['id'];
			$this->redirect($redirect);
		}
		
		
		$this->data['page_name'] = 'Редактирование категории';
		$this->data['text_submit'] = 'Сохранить изменения';
		$this->page['title'] = 'Редактирование категории';
		$this->page['keywords'] = 'Редактирование категории';
		$this->page['description'] = 'Редактирование категории';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('form');
		return $this->page;
	}
	
	public function action_category() {
	
		$this->load_helper('image');
		$category = $this->model->get_category($this->url['actions'][1]);
		$category['path'] = SITE_URL . '/uploads/images/gallery/' . $category['dir'];
		$upload_dir = ROOT_DIR . '/uploads/images/gallery/' . $category['dir'];
		
		if(isset($_POST['submit']) || isset($_POST['submit_exit'])) {
			$data = array();
			$data['text'] = $_POST['text'];
			$data['category_id'] = $category['id'];
			
			if(is_uploaded_file($_FILES['image']['tmp_name'])) {
	
				if ($this->component_config['item_thumb_width'] > $this->component_config['item_image_width']) {
					$mini_width = $this->component_config['item_thumb_width'];
					$mini_height = $this->component_config['item_thumb_height'];
				} else {
					$mini_width = $this->component_config['item_image_width'];
					$mini_height = round($mini_width / ($this->component_config['item_thumb_width'] / $this->component_config['item_thumb_height']));
				}
				
				$data['image'] = $this->helper_image->img_upload('image', $this->component_config['item_full_width'], $upload_dir . '/', $mini_width, $mini_height, $this->component_config['item_full_height']);
			
				$this->model->add_item($data);
				$this->redirect(SITE_URL . '/admin/gallery/category/' . $category['id'] . '/success=added');
			}
		}
		
		$this->data['category'] = $category;
		$this->data['items'] = $this->model->get_items($category['id']);
		
		$this->data['page_name'] = 'Категория "' . $category['name'] . '"';
		$this->data['text_submit'] = 'Добавить фото';
		$this->page['title'] = 'Категория "' . $category['name'] . '"';
		$this->page['keywords'] = 'Категория "' . $category['name'] . '"';
		$this->page['description'] = 'Категория "' . $category['name'] . '"';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('category');
		return $this->page;
	}
	
	public function action_delete_img() {
		$category = $this->model->get_category_by_item_id($this->url['actions'][1]);
		$this->model->delete_item($this->url['actions'][1]);
		$this->redirect(SITE_URL . '/admin/' . $this->component_name . '/category/' . $category['id'] . '/success=deleted');
	}
	
	public function action_delete() {
		if (!isset($this->url['actions'][1])) {
			$this->redirect(SITE_URL . '/admin/' . $this->component_name);
		}
		
		$this->model->delete_category($this->url['actions'][1]);
		
		$_SESSION['success'] = 'Категория удалена';
		
		$this->redirect(SITE_URL . '/admin/' . $this->component_name);
	}
}