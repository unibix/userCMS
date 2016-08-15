<?php 

class controller_block_core_news_announce extends block {
	
	public function action_index($block) {
		$params = unserialize($block['params']);
		$sql = "SELECT * FROM news_items ";
		if($params['category_id']) {
			$sql .= " WHERE category_id = '" . (int)$params['category_id'] . "'";
		}

		$sql .= " ORDER BY date DESC, id DESC LIMIT 0, '" . (int)$params['count_news'] . "'";
		
		$this->data['news'] = $this->dbh->query($sql);
		
		$component_news = $this->dbh->row("SELECT * FROM main WHERE component='news' LIMIT 1");
		$this->data['news_url'] = $component_news ? $component_news['url'] : 'novosti';
		
		if (!empty($this->data['news'])){
			foreach($this->data['news'] as $k=>$new){
				$this->data['news'][$k]['url'] = '/' . $this->data['news_url'] . '/' . $this->get_full_news_url($this->data['news'][$k]);
			}
		}
		
		$this->data['params'] = $params;
		
		$page['head'] = '';
		$page['html'] = $this->load_view('news');
		return $page;
	}
	public function action_activate() {
		$page = array();
		
		if(isset($_POST['activate'])) {
			$data = array(
				'count_news' => $_POST['count_news'],
				'category_id' => $_POST['category_id'],
				'show_preview'         => $_POST['show_preview'],
				'show_link_all_news'         => $_POST['show_link_all_news']
			);
			$page['params'] = serialize($data);
		}
		$this->data['categories'] = $this->dbh->query("SELECT * FROM news_categories ORDER BY id ASC");
		
		$page['html'] = $this->load_view('activate');
		return $page;
	}
	
	public function action_settings($block){
		$params = unserialize($block['params']);
		$this->data['block_id'] = $block['id'];
		if (isset($_POST['edit_settings'])) {
			$this->page['block_id'] = $block['id'];
			$this->page['params'] = serialize(array(
				'count_news'           => $_POST['count_news'],
				'category_id'      => $_POST['category_id'],
				'show_preview'         => $_POST['show_preview'],
				'show_link_all_news'         => $_POST['show_link_all_news']
			));
			
			return $this->page;
		}	
		$this->data['count_news'] = $params['count_news'];
		$this->data['category_id'] = $params['category_id'];
		$this->data['show_preview'] = isset($params['show_preview']) ? $params['show_preview'] : 1;
		$this->data['show_link_all_news'] = isset($params['show_link_all_news']) ? $params['show_link_all_news'] : 0;
		$this->data['categories'] = $this->dbh->query("SELECT * FROM news_categories ORDER BY id ASC");
		
		$this->page['html'] = $this->load_view('settings');		
		return $this->page;		
	}
	
	protected function get_full_news_url($news){
		$url = $news['url'];
		$category_id = $news['category_id'];
		$maxcount=30;
		do {
			$cat = $this->dbh->row("SELECT * FROM news_categories WHERE id=" . $category_id);
			if (!$cat) break;
			$url = $cat['url'] . '/' . $url;
			$category_id = $cat['sub'];
			$maxcount--;
		} while (($category_id > 0)&&($maxcount>0));
		return($url);
	} 
}
