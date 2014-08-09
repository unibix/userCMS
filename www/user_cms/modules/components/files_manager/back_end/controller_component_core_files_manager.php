<?php 

class controller_component_core_files_manager extends component {
	
	// вывод страниц и списка активированных компонентов
	public function action_index() {
		$dir = (isset($this->url['params']['dir'])) ? '/' . $this->url['params']['dir'] : '';
		$this->data['files'] = $this->model->get_files($dir);
		$this->data['upload_max_filesize'] = (int)ini_get("upload_max_filesize");
		
		$this->data['bread_crumbs'] = '';
		$this->data['page_name'] = 'Менеджер файлов';

		$this->page['title'] =  'Менеджер файлов';
		$this->page['html'] = $this->load_view();

		return $this->page;
	}
}