<?php 

class controller_component_core_news extends component {
	
	public function action_index() {
		$this->load_helper('image');
		$this->data['errors'] = array();
		$this->data['success'] = array();
		$this->data['notice'] = array();
		$this->data['page_name'] = 'Новости';

		if(isset($this->url['params']['success'])) {
			if($this->url['params']['success'] == 'added') {
				$this->data['success'][] = 'Новость добавлена.';
				if(isset($this->url['params']['news_id'])) {
					$this->data['success'][] = '<a href="' . SITE_URL . '/admin/news/edit/' . $this->url['params']['news_id'] . '">Редактировать</a>';
				}
			} elseif($this->url['params']['success'] == 'edited') {
				$this->data['success'][] = 'Новость изменена.';
				if(isset($this->url['params']['news_id'])) {
					$this->data['success'][] = '<a href="' . SITE_URL . '/admin/news/edit/' . $this->url['params']['news_id'] . '">Вернуться к редактированию</a>';
				}
			} elseif($this->url['params']['success'] == 'deleted') {
				$this->data['success'][] = 'Новость удалена';
			}
		}
		
		$params = array(
			'sort'=>'c.date_add DESC',
			'limit'=>'0,10',
			'join'=>'category_name'
		);
		
		if(isset($this->url['params']['category_id'])) {
			$params['type'] = 'by_category';
			$this->data['category_id'] = $this->url['params']['category_id'];
			$category = $this->model->get_category($this->url['params']['category_id']);
			$this->data['page_name'] .= ' категории "' . $category['name'] . '"';
		} else {
			$this->data['category_id'] = 0;
		}
			
		$this->data['news'] = $this->model->get_news($this->data['category_id'], $params);
		
		$this->data['categories'] = $this->model->get_categories();
		$this->data['option_value'] = SITE_URL . '/admin/' . $this->url['component'];
		
		$this->page['title'] = 'Новости';
		$this->page['keywords'] = 'Новости';
		$this->page['description'] = 'Новости';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('index');
		
		return $this->page;
	}
	
	public function action_add() {
		$this->data['errors'] = array();
		$this->data['success'] = array();
		$this->data['notices'] = array();
		
		$config = $this->model->get_config();
		
		if(isset($_POST['name'])){
			$this->data['name'] = $_POST['name'];
			if(empty($this->data['name'])){
				$this->data['errors'][] = 'Не указан заголовок новости';
			}
		} else {
			$this->data['name'] = '';
		}
		
		if(isset($_POST['text'])){
			$this->data['text'] = $_POST['text'];
			if(empty($_POST['text'])) {
				$this->data['errors'][] = 'Не указан текст новости';
			}
		} else {
			$this->data['text'] = '';
		}	
		
		if(isset($_POST['preview'])){
			if(!empty($_POST['preview'])) {
				$this->data['preview'] = $_POST['preview'];
			} elseif($config['substr_preview']) {
				$this->data['preview'] = substr(strip_tags($_POST['text']), 0, (int)$config['preview_count']);
			} else {
				$this->data['preview'] = '';
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
		
		if(isset($_POST['category_id'])) {
			$this->data['category_id'] = $_POST['category_id'];
		} elseif(isset($this->url['params']['category_id'])) {
			$this->data['category_id'] = $this->url['params']['category_id'];
		} else {
			$this->data['category_id'] = 1;
		}
		
		if(isset($_POST['date_add']) && !$this->data['errors']) {
			if(!$this->data['date_add'] = strtotime($_POST['date_add'])) {
				$this->data['date_add'] = time();
			}
		} else {
			$this->data['date_add'] = date('d.m.Y H:i');
		}
		
		$this->data['date_edit'] = '';
		
		if(isset($_POST['submit_news']) && !$this->data['errors']){

			$news_id = $this->model->add_news_item($this->data);

			$redirect = SITE_URL . '/admin/news/success=added/news_id=' . $news_id;
			$this->redirect($redirect);
			
		}
		
		$this->data['categories'] = $this->model->get_categories();
		
		$this->data['text_submit'] = 'Добавить';
		$this->data['page_name'] = 'Добавление новости';
		$this->page['title'] = 'Добавление новости';
		$this->page['keywords'] = 'Добавление новости';
		$this->page['description'] = 'Добавление новости';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('form');
		return $this->page;
	}
	
	public function action_edit() {
		$this->data = $this->model->get_news_item($this->url['actions'][1]);
		$this->data['errors'] = array();
		$this->data['success'] = array();
		$this->data['notices'] = array();
		
		$config = $this->model->get_config();
		
		if(isset($this->url['params']['success']) && $this->url['params']['success'] == 'edited') {
			$this->data['success'][] = 'Новость изменена.';
		}
		
		if(isset($_POST['name'])){
			$this->data['name'] = $_POST['name'];
			if(empty($this->data['name'])){
				$this->data['errors'][] = 'Не указан заголовок новости';
			}
		}
		
		if(isset($_POST['text'])){
			$this->data['text'] = $_POST['text'];
			if(empty($_POST['text'])) {
				$this->data['errors'][] = 'Не указан текст новости';
			}
		}
		
		if(isset($_POST['preview'])){
			if(!empty($_POST['preview'])) {
				$this->data['preview'] = $_POST['preview'];
			} elseif($config['substr_preview']) {
				$this->data['preview'] = substr(strip_tags($_POST['text']), 0, (int)$config['preview_count']);
			} else {
				$this->data['preview'] = '';
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
		
		if(isset($_POST['category_id'])) {
			$this->data['category_id'] = $_POST['category_id'];
		} elseif(isset($this->url['params']['category_id'])) {
			$this->data['category_id'] = $this->url['params']['category_id'];
		}
		
		if(isset($_POST['date_add'])) {
			$date_add = strtotime($_POST['date_add']);
			if($this->data['errors']) {
				$this->data['date_add'] = $_POST['date_add'];
			} elseif($date_add) {
				$this->data['date_add'] = $date_add;
			}
		} else {
			$this->data['date_add'] = date('d.m.Y H:i', (int)$this->data['date_add']);
		}
		
		if(isset($_POST['date_edit'])) {
			$date_edit = strtotime($_POST['date_edit']);
			if($this->data['errors']) {
				$this->data['date_edit'] = $_POST['date_edit'];			
			} elseif($date_edit) {
				$this->data['date_edit'] = $date_edit;
			}
		} elseif(!$this->data['date_edit']) {
			$this->data['date_edit'] = date('d.m.Y H:i');
		} else {
			$this->data['date_edit'] = date('d.m.Y H:i', (int)$this->data['date_edit']);
		}

		if(isset($_POST['submit_news']) && !$this->data['errors']) {
			$this->model->edit_news_item($this->data);

			$redirect = SITE_URL . '/admin/news/success=edited/news_id=' . $this->data['id'];
			$this->redirect($redirect);
		}
		
		$this->data['categories'] = $this->model->get_categories();
		
		$this->data['text_submit'] = 'Сохранить изменения';
		$this->data['page_name'] = 'Редактирование новости';
		$this->page['title'] = 'Редактирование новости';
		$this->page['keywords'] = 'Редактирование новости';
		$this->page['description'] = 'Редактирование новости';
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('form');
		return $this->page;
	}
	
	public function action_delete() {
		if(!isset($this->url['actions'][1])) {
			$this->redirect(SITE_URL . '/admin/news');
		}
		
		$this->model->delete_news_item($this->url['actions'][1]);
		
		$this->redirect(SITE_URL . '/admin/news/success=deleted');
	}
	
	public function action_categories() {
		$this->data['errors'] = array();
		$this->data['notices'] = array();
		$this->data['success'] = array();
		
		$config = $this->model->get_config();
		
		$this->data['categories'] = $this->model->get_categories();
		foreach($this->data['categories'] as &$category) {
			$category['count_news'] = $this->model->get_total_news($category['id']);
			//$category['browse_items_href'] = SITE_URL . '/admin/' . $this->url['component'] . '/category_id=' . $category['id'];
		}
		
		$this->data['page_name'] = $this->page['title'] = 'Категории новостей';
		
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('categories');
		return $this->page;
	}
	
	public function action_add_category() {
		$this->data['errors'] = array();
		$this->data['notices'] = array();
		$this->data['success'] = array();
		
		$config = $this->model->get_config();
		
		if(isset($_POST['name'])) {
			if(empty($_POST['name'])) {
				$this->data['errors'][] = 'Не указано название категории';
			}
			$this->data['name'] = $_POST['name'];
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
			} elseif($config['substr_preview']) {
				$this->data['preview'] = substr(strip_tags($_POST['text']), 0, (int)$config['preview_count']);
			} else {
				$this->data['preview'] = '';
			}
		} else {
			$this->data['preview'] = '';
		}
				
		if(isset($_POST['title']) && !empty($_POST['title'])){
			$this->data['title'] = $_POST['title'];
		} else {
			$this->data['title'] = '';
		}
						
		if(isset($_POST['keywords']) && !empty($_POST['keywords'])){
			$this->data['keywords'] = $_POST['keywords'];
		} else {
			$this->data['keywords'] = '';
		}
								
		if(isset($_POST['description']) && !empty($_POST['description'])){
			$this->data['description'] = $_POST['description'];
		} else {
			$this->data['description'] = '';
		}
										
		if(isset($_POST['url']) && !empty($_POST['url'])){
			$this->data['url'] = $this->str2url($_POST['url']);
		} elseif(isset($_POST['url']) && empty($_POST['url'])) {
			$this->data['url'] = $this->str2url($this->data['name']);
		} else {
			$this->data['url'] = '';
		}
		
		if(isset($_POST['date_add'])) {
			$date_add = strtotime($_POST['date_add']);
			if($this->data['errors']) {
				$this->data['date_add'] = $_POST['date_add'];
			} elseif($date_add) {
				$this->data['date_add'] = $date_add;
			}
		} else {
			$this->data['date_add'] = date('d.m.Y H:i');
		}
		
		if (isset($_POST['parent_category'])){
			$this->data['parent_category'] = (int)$_POST['parent_category'];
			$this->data['sub'] = (int)$_POST['parent_category'];
		} else {
			$this->data['parent_category'] = 0;
			$this->data['sub'] = 0;
		}
		
		$this->data['date_edit'] = '';
		
		if(isset($_POST['submit_category']) && !$this->data['errors']) {
			if($category_id = $this->model->add_category($this->data)) {
				$this->redirect(SITE_URL . '/admin/' . $this->url['component'] . '/categories/success=added');
			}
		}
		
		$this->data['parent_categories'] = $this->model->dbh->query("SELECT * FROM news_categories WHERE 1");
		$this->data['page_name'] = $this->page['title'] = 'Добавление категории';
		$this->data['text_submit'] = 'Добавить';
		
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('category_form');
		return $this->page;
	}
	
	public function action_edit_category() {
		if(!isset($this->url['actions'][1])) {
			$this->redirect(SITE_URL . '/admin/' . $this->url['component']);
		} else {
			$category_id = $this->url['actions'][1];
		}
		
		$this->data = $this->model->get_category($category_id);
		
		$this->data['errors'] = array();
		$this->data['notices'] = array();
		$this->data['success'] = array();
		
		$config = $this->model->get_config();
		
		if(isset($_POST['name'])) {
			if(empty($_POST['name'])) {
				$this->data['errors'][] = 'Не указано название категории';
			}
			$this->data['name'] = $_POST['name'];
		}
		
		if (isset($_POST['parent_category'])){
			$this->data['parent_category'] = (int)$_POST['parent_category'];
		} else {
			$this->data['parent_category'] = 0;
		}		
		
		if(isset($_POST['text'])){
			$this->data['text'] = $_POST['text'];
		}
		
		if(isset($_POST['preview'])){
			if(!empty($_POST['preview'])) {
				$this->data['preview'] = $_POST['preview'];
			} elseif($config['substr_preview']) {
				$this->data['preview'] = substr(strip_tags($_POST['text']), 0, (int)$config['preview_count']);
			} else {
				$this->data['preview'] = '';
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
		
		if(isset($_POST['date_add'])) {
			$date_add = strtotime($_POST['date_add']);
			if($this->data['errors']) {
				$this->data['date_add'] = $_POST['date_add'];
			} elseif($date_add) {
				$this->data['date_add'] = $date_add;
			}
		} else {
			$this->data['date_add'] = date('d.m.Y H:i', $this->data['date_add']);
		}
		
		if(isset($_POST['date_edit'])) {
			$date_edit = strtotime($_POST['date_edit']);
			if($this->data['errors']) {
				$this->data['date_edit'] = $_POST['date_edit'];			
			} elseif($date_edit) {
				$this->data['date_edit'] = $date_edit;
			}
		} else {
			$this->data['date_edit'] = date('d.m.Y H:i');
		}
		
		if(isset($_POST['submit_category']) && !$this->data['errors']) {
			if($this->model->edit_category($this->data)) {
				$this->redirect(SITE_URL . '/admin/' . $this->url['component'] . '/categories/success=edited');
			}
		}
		
		$this->data['parent_categories'] = $this->model->dbh->query("SELECT * FROM news_categories WHERE 1");

		$this->data['page_name'] = $this->page['title'] = 'Редактирование категории "' . $this->data['name'] . '"';
		$this->data['text_submit'] = 'Сохранить изменения';
		
		$this->page['html'] = $this->load_view('left_menu');
		$this->page['html'] .= $this->load_view('category_form');
		return $this->page;
		
		$this->data['errors'] = array();
		$this->data['notices'] = array();
		$this->data['success'] = array();
	}
	
	public function action_delete_category() {
		if(!isset($this->url['actions'][1])) {
			$this->redirect(SITE_URL . '/admin/' . $this->url['component'] . '/categories');
		}

		$this->model->delete_category($this->url['actions'][1]);
		
		$this->redirect(SITE_URL . '/admin/' . $this->url['component'] . '/categories/success=deleted');
	}
	
	public function action_settings() {
		$this->data['errors'] = array();
		$this->data['success'] = array();
		$this->data['notice'] = array();
		$this->data['page_name'] = '';
	}
}