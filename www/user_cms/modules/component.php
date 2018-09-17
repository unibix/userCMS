<?php 

/**
* main component
*/
class component extends module {

	public $view;
	public $view_dir;
	public $component_dir;
	public $component_dir_core;
	public $page;
	public $model;
	public $component_name;
	public $component_config;
	public $component_info;
	public $data = array();
	
	function __construct($config, $url, $component, $dbh) {
		parent::__construct($config, $url, $component, $dbh);
		
		$this->view   = $component['view'];
  		$this->view_dir_core    = ROOT_DIR . '/user_cms/modules/components/'.$component['name'].'/'.END_NAME.'/views';
  		$this->view_dir         = ROOT_DIR .          '/modules/components/'.$component['name'].'/'.END_NAME.'/views';
		//$this->view_dir = is_dir($this->view_dir) ? $this->view_dir : $this->view_dir_core;
  		$this->page['title']            = '';
  		$this->page['keywords']         = '';
  		$this->page['description']      = '';
  		$this->page['html']             = '';
		$this->page['head']             = '';
		$this->component_dir_core       = ROOT_DIR . '/user_cms/modules/components/'.$component['name'].'/'.END_NAME;
		$this->component_dir            = ROOT_DIR . '/modules/components/'.$component['name'].'/'.END_NAME;
		//$this->component_dir = is_dir($this->component_dir) ? $this->component_dir : $this->component_dir_core;
		$this->component_name           = $component['name'];
		$this->model                    = $this->load_model();
		$this->component_config         = $this->get_component_config($component['name']);
		$this->component_info           = isset($component['info']) ? $component['info'] : $this->get_component_info($component['name']);
		//первые две ссылки хлебных крошек
		$this->load_helper('breadcrumbs');
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs(
			array('Главная', (isset($this->component_info['name'])?$this->component_info['name']:(isset($this->component_config['name'])?$this->component_config['name']:'')) ),
			array(SITE_URL . (END_NAME == 'back_end'?'/admin':''), SITE_URL . (END_NAME == 'back_end'?'/admin':'') . '/' . $this->url['component']) 
			
		);

		//ссылки для постраничной навигации (pagination)
		$this->load_helper('pagination');
		if (count($this->url['actions']) == 1 && $this->url['actions'][0] == 'index') {;
            $this->helper_pagination->url = SITE_URL . (END_NAME == 'back_end'?'/admin':'') . '/' . $this->url['component'] . '/{page}' . (!empty($_SERVER['QUERY_STRING'])?'?'.$_SERVER['QUERY_STRING']:'');
        } else {
            $this->helper_pagination->url = SITE_URL . (END_NAME == 'back_end'?'/admin':'') . '/' . $this->url['component'] . '/' . implode('/', $this->url['actions']) . '/{page}' . (!empty($_SERVER['QUERY_STRING'])?'?' . $_SERVER['QUERY_STRING']:'');
        }
	}

	public function action_index() {
		$this->data['page_name'] = 'Название страницы не задано';
		$this->data['content'] = '<p style="margin: 20px 0;">Контент страницы не задан</p>';
		$this->data['bread_crumbs'] = '';
		$this->page['title'] = 'Тайтл страницы не задан';
		$this->page['keywords'] = 'Ключевики страницы не заданы';
		$this->page['description'] = 'Описание страницы не задано';
		$this->page['html'] = $this->load_view();
		$this->page['head'] = '';
		return $this->page;
	}

	public function action_else() {
		return $this->action_404();
	}

	public function action_404($view_name = '404_not_found') {
		$sapi_name = php_sapi_name();
		if ($sapi_name == 'cgi' || $sapi_name == 'cgi-fcgi') {
		    header('Status: 404 Not Found');
		} else {
		    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
		}
		$this->data['page_name'] = 'Страница не найдена';
		$this->data['content'] = '<p style="margin: 20px 0;">Ошибка 404 бывает в следующих случаях:	<ol><li>Страницу удалили</li><li>Страницу переместили</li><li>Страница еще не создана</li></ol>Воспользуйтесь меню сайта для поиска нужной информации или перейдите на <a href="' . SITE_URL . (END_NAME == 'back_end'?'/admin/':'') . '">главную страницу</a>.</p>';
		$this->data['breadcrumbs'] = 
		'<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="' . SITE_URL . (END_NAME == 'back_end'?'/admin':'') . '">Главная</a></li>
				<li class="breadcrumb-item active" aria-current="page">Ошибка 404</li>
			</ol>
		</nav>';
		$page['title'] = 'Страница не найдена. Ошибка 404';
		$page['keywords'] = '';
		$page['description'] = '';
		if(is_file($this->view_dir . '/' . $view_name . '.tpl') || is_file($this->view_dir_core . '/' . $view_name . '.tpl')){
			$page['html'] = $this->load_view($view_name);
		}else{
			$page['html'] = '<div id="content">' . "\r\n" . '<h1>' . $this->data['page_name'] . '</h1>' . "\r\n" . $this->data['breadcrumbs'] . "\r\n" . $this->data['content'] . "\r\n</div>";
		}
		return $page;
	}
	
	public function load_view($name = 'index') {
		$full_name = $this->view_dir . '/' . $name . '.tpl';
		$full_name_core = $this->view_dir_core . '/' . $name . '.tpl';
		
		if (file_exists($full_name)) {
	        $view = $full_name;
	    } elseif (file_exists($full_name_core)) {
	        $view = $full_name_core;
	    } elseif (file_exists($this->view_dir . '/' . $this->view . '.tpl')) {
	        $view = $this->view_dir . '/' . $this->view . '.tpl';
	    } elseif (file_exists($this->view_dir_core . '/' . $this->view . '.tpl')) {
	        $view = $this->view_dir_core . '/' . $this->view . '.tpl';
	    } else {
	    	exit('Error3: file not found: ' . $full_name);
	    }
		
		extract($this->data);
		
		ob_start();
		include $view;
		return ob_get_clean();
	}

	public function load_model($type = '', $name = '') {
		if(!$name || !$type) { // подгружаем родной компонент
			$model_full_name = class_exists('model_component_' . $this->component_name, true) ? 'model_component_' . $this->component_name : 'model_component_core_' . $this->component_name;
			return new $model_full_name($this->dbh);
		} else {
			$model_full_name = 'model_' . $type . '_' . $name;
			$really_model_full_name = class_exists('model_' . $type . '_' . $name, true) ? 'model_' . $type . '_' . $name : 'model_' . $type . '_core_' . $name;
			$this->$model_full_name = new $really_model_full_name($this->dbh);
		}
	}
	
	protected function mb_strtr($str, $from, $to = '') {
		if(is_array($from)) {
			$new_from = array_keys($from);
			return str_replace($new_from, $from, $str);
			
		} else {
			$from = preg_split('~~u', $from, null, PREG_SPLIT_NO_EMPTY);
			$to = preg_split('~~u', $to, null, PREG_SPLIT_NO_EMPTY);
			return str_replace($from, $to, $str);
		}
	}
}
