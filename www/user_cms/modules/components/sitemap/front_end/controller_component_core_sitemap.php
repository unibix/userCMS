<?php 

class controller_component_core_sitemap extends component {
	public function action_index() {
		$this->data['page_name'] = 'Карта сайта';
		$this->data['pages'] = $this->model->get_pages();

		$this->page['title'] = 'Карта сайта ' . SITE_NAME;
		$this->page['keywords'] = 'Карта сайта';
		$this->page['description'] = 'Карта сайта';
		$this->page['html']  = $this->load_view();

		return $this->page;
	}

}