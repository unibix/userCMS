<?php 

class controller_block_core_news_announce extends block {
	
	public function action_index($block) {
		$params = unserialize($block['params']);
		$sql = "SELECT * FROM news_items ";
		if($params['category_id']) {
			$sql .= " WHERE category_id = '" . (int)$params['category_id'] . "'";
		}

		$sql .= " ORDER BY date_add DESC, id DESC LIMIT 0, '" . (int)$params['count_news'] . "'";
		
		$this->data['news'] = $this->dbh->query($sql);
		$page['head'] = '';
		$page['html'] = $this->load_view('news');
		return $page;
	}
	public function action_activate() {
		$page = array();
		
		if(isset($_POST['activate'])) {
			$data = array(
				'count_news' => $_POST['count_news'],
				'category_id' => $_POST['category_id']
			);
			$page['params'] = serialize($data);
		}
		$this->data['categories'] = $this->dbh->query("SELECT * FROM news_categories ORDER BY id ASC");
		
		$page['html'] = $this->load_view('activate');
		return $page;
	}
}
