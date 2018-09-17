<?php 
class controller_component_core_robots_editor extends component {
	public function action_index() {
		if (isset($_SESSION['success'])) {
			$this->data['success'] = $_SESSION['success'];
			unset($_SESSION['success']);
		} else {
			$this->data['success'] = '';
		}
		
		if (isset($_POST['edit_robots'])) {
			file_put_contents(ROOT_DIR . '/robots.txt', $_POST['robots_content']);
			
			$_SESSION['success'] = 'Изменения сохранены';
			
			$this->redirect(SITE_URL . '/admin/robots_editor');
			
		} elseif (!file_exists(ROOT_DIR . '/robots.txt')) {
			file_put_contents(ROOT_DIR . '/robots.txt', '');
		}
		
		@chmod(ROOT_DIR . '/robots.txt', 0644);
		
		if (is_readable(ROOT_DIR . '/robots.txt')) {
			$this->data['robots'] = file_get_contents(ROOT_DIR . '/robots.txt');
		} else {
			$this->data['robots'] = false;
		}
		
		$this->data['page_name'] = 'Редактор robots.txt';
		
		$this->page['title'] = 'Редактор robots.txt';
		$this->page['keywords'] = 'Редактор robots.txt';
		$this->page['description'] = 'Редактор robots.txt';
		$this->page['html'] = $this->load_view();
		return $this->page;
	}

}