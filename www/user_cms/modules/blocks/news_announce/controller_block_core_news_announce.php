<?php 

class controller_block_core_news_announce extends block {
	
	public function action_index($block)
    {
		$params = unserialize($block['params']);
        $r = $this->dbh->row("SELECT url FROM main WHERE component='news'");
        if ($r) {
            $component_url = $r['url'];

            if ($params['category_id'] != -1) $category = " AND parent_id=".$params['category_id']." ";
            else $category = ""; 
            $today = time();
            $items = $this->dbh->query("SELECT * FROM news WHERE is_category=0 AND date_publish<$today $category ORDER BY date_publish LIMIT 0,".$params['count_news']);

            foreach ($items as $n => $item) $items[$n]['url'] = SITE_URL.'/'.$component_url.$this->get_full_url($item['id']);

            $this->data['items'] = $items;
            $this->data['params'] = $params;
            $this->data['img_folder'] = 'news';
            $this->data['component_url'] = $component_url;
            $this->page['head'] = $this->add_css_file('/user_cms/modules/blocks/news_announce/views/style.css');
    		$this->page['html'] = $this->load_view('news');
        } else {
            $this->page['html'] = 'Компонент новостей не активирован';
        }
        return $this->page;
	}

    protected function save_settings($params, $submit_name)
    {
        if (isset($_POST[$submit_name])) {
            if ($params['count_news'] > 30) $params['count_news'] = 30;
            if ($params['count_news'] < 1) $params['count_news'] = 1;
            $this->page['params'] = serialize($params);
        }
        $this->data['params'] = $params;
        $today = time();
        $this->data['categories'] = $this->dbh->query("SELECT id, header FROM news WHERE is_category=1 AND date_publish<$today");
        $this->data['categories'][] = array('id' => 0, 'header' => 'Родительская категория');
        $this->data['categories'][] = array('id' => -1, 'header' => 'Из всех категорий');
        $this->page['html'] = $this->load_view('settings');
        return $this->page;
    }

	public function action_activate() {
		$params = array(
            'count_news' => 5,
            'category_id' => -1, //-1 - выбирать из всех категорий
            'show_overview' => true,
            'show_photo' => true,
            'show_all_news_link' => true,
        );
		return $this->save_settings($params, 'activate');
	}
	
	public function action_settings($block){
		$params = unserialize($block['params']);
        if (isset($_POST['edit_settings'])) {
            $params['count_news'] = intval($_POST['count_news']);
            $params['category_id'] = intval($_POST['category_id']);
            $params['show_overview'] = isset($_POST['show_overview']);
            $params['show_photo'] = isset($_POST['show_photo']);
            $params['show_all_news_link'] = isset($_POST['show_all_news_link']);
        }
		return $this->save_settings($params, 'edit_settings');		
	}
	
	public function get_full_url($id)
    {
        $url = array();
        while ($id > 0) {
            $item = $this->dbh->row("SELECT * FROM news WHERE id=$id");
            if (!empty($item)) {
                $url[] = $item['url'];
                $id = $item['parent_id'];
            } else {
                return '';
            }
        }
        return '/'.implode('/', array_reverse($url));
    }
}
