<?php

define('USER_CMS_VERSION', 2.3);


/**
* main core class
* основной класс ядра 
*/
class user_cms_core {
	
	public $html; // общий html код сайта
	public $config; // общие настройки
	public $url; // массив с частями урла
	public $component; // массив с настройками компонента
	public $theme; // массив с настройками темы
	public $page; // массив с настройками темы (заголовок, тайтл, мета теги и пр)
	public $head; // html код для тега head
	public $dbh; // db handle
	
	function __construct() {
       	
		session_start();
		date_default_timezone_set('Europe/Kaliningrad');

       	$this -> html = '';
		$this -> config = parse_ini_file(ROOT_DIR . '/config.ini');
		if (!isset($this->config['site_url'])) {
			$this->config['site_url'] = 'http://' . $_SERVER['HTTP_HOST'];
		}

		define('SITE_URL', $this->config['site_url']);
		define('SITE_NAME', $this->config['site_name']);
        define('SITE_SLOGAN', $this->config['site_slogan']);
        define('SITE_EMAIL', $this->config['site_email']);
        define('SITE_EMAIL2', $this->config['site_email2']);
        define('SITE_PHONE', $this->config['site_phone']);
        define('SITE_PHONE_F', $this->config['site_phone_f']);

		if (is_dir(ROOT_DIR . '/user_cms/themes/' . $this->config['site_theme'])) {
			define('THEME_URL', SITE_URL . '/user_cms/themes/' . $this->config['site_theme']);
            $logo = '/user_cms/themes/'.$this->config['site_theme'].'/images/logo.png';
		} else {
			define('THEME_URL', SITE_URL . '/themes/' . $this->config['site_theme']);
            $logo = '/themes/'.$this->config['site_theme'].'/images/logo.png';
		}

        if (file_exists(ROOT_DIR.$logo)) define('SITE_LOGO', '<img src="'.$logo.'" alt="Логотип '.SITE_NAME.'">');
        else define('SITE_LOGO', SITE_NAME);


		$this -> set_error_reporting();
		$this -> url = $this -> parse_url();

        if ($this->config['maintenance'] == 1) {
            if (END_NAME == 'front_end' && (!isset($_SESSION['auth']) || $_SESSION['auth'] == 0 || $_SESSION['access'] < 2)) exit(
                '<div style="margin:20% auto;font-size:200%;padding:30px;max-width:900px;text-align:center;">Внимание! В данный момент сайт обновляется.</div>'
            );
        }

		// задаем по умолчанию 
		$this -> component['name']     = 'pages'; 
		$this -> component['action']   = 'index'; 
		$this -> component['view']     = 'index';
		$this -> component['html']     = '';
		$this -> component['dir_core'] = ROOT_DIR . '/user_cms/modules/components/' . END_NAME . '/pages';
		$this -> component['dir']      = ROOT_DIR .          '/modules/components/' . END_NAME . '/pages';
		$this -> component['info']     = array();

		$this -> theme['name']         = $this -> config['site_theme'];
		$this -> theme['file']         = 'index';
		$this -> theme['url_core']     = SITE_URL . '/user_cms/themes/' . $this -> theme['name']  ;
		$this -> theme['url']          = SITE_URL .          '/themes/' . $this -> theme['name']  ;
		$this -> theme['dir_core']     = ROOT_DIR . '/user_cms/themes/' . $this -> theme['name']  ;
		$this -> theme['dir']          = ROOT_DIR .          '/themes/' . $this -> theme['name']  ;


		$this -> page['title']         = '';
		$this -> page['keywords']      = '';
		$this -> page['description']   = '';
		$this -> page['html']          = '';

		$this -> head    		       = '';
		
		$this -> dbh = $this -> db_connect();
		
		$this->set_global_data();
		$this->get_component_data();
    }

	function load_addons($position) {
        // загружаем аддоны в позиции
        $end_name = (END_NAME == 'back_end') ? "AND back_end = '1'" : "AND back_end='0'";
        $sql = "SELECT * FROM activated_modules WHERE type='addon' AND position = '" . $this->dbh->escape($position) . "' ".$end_name." ORDER BY sort ASC";
   		$list_addons = $this->dbh->query($sql);
   		$html = '';
		
   		foreach($list_addons as $addon) {
			if ($this->validate_sections($addon['sections'])) {
				$a = $this->load_addon($addon);
				$this->head .= isset($a['head']) ? $a['head'] : '';
				$html .= $a['html'];
			}
   		}
   		return $html;
   	}
	
	protected function set_global_data() {
		// добавляем инфу о пользователе если вошел
		if (isset($_SESSION['auth']) && $_SESSION['auth'] > 0 && isset($_SESSION['login'])) {
			$user = $this->dbh->row("SELECT * FROM users WHERE login = '" . $this->dbh->escape($_SESSION['login']) . "' AND active > 0");
			if ($user) {
				module::set_global_data('user', $user);
			} else {
				unset($_SESSION['auth']);
				unset($_SESSION['login']);
				$this->redirect(SITE_URL . $this->url['request_uri']);
			}
		}
	}
	
	function get_component_data() {
   		if (!empty($this->url['component'])) {
    		if (END_NAME == 'front_end') {
	    		$sql = "SELECT * FROM `main` WHERE `url` = '" . $this->url['component'] . "'";
		    	$count = $this->dbh->query_count($sql);
				
		    	if ($count == 0) {
		    		$this -> component['name']   = 'pages';
		    		$this -> component['action'] = '404';
		    	} else {
		    		$row = $this->dbh->row($sql);
					
					$this->component['info'] = $row;
					$this->component['view'] = $row['view'] ? $row['view'] : 'index';
					$this->theme['file']     = $row['theme_view'] ? $row['theme_view'] : 'index';
					
		    		if ($row['component'] == 'pages') {
		    			$this->component['name']   = 'pages';
		    			$this->component['action'] = 'else';
						
						if ($this->url['actions'][0] != 'index') { // TODO : сделать нормальный сбор инфы о компоненте
							$last_action = (count($this->url['actions'])-1);
							$page = $this->dbh->row("SELECT * FROM main WHERE url = '" . $this->url['actions'][$last_action] . "'");
							if ($page) {
								$this->component['info'] = $page;
								$this->component['view'] = $page['view'] ? $page['view'] : 'index';
								$this->theme['file']     = $page['theme_view'] ? $page['theme_view'] : 'index';
							}
						}
		    		} else {
		    			$this->component['name']   = $row['component'];
						
						if (method_exists('controller_component_' . $this -> component['name'], 'action_' . $this->url['actions'][0])) {
							$this->component['action'] = $this->url['actions'][0];
						} else if (method_exists('controller_component_core_' . $this -> component['name'], 'action_' . $this->url['actions'][0])) {
							$this->component['action'] = $this->url['actions'][0];
						} else {
							$this->component['action'] = 'else';
						}
						
						$this->page['title'] = $row['title'];
						$this->page['keywords'] = $row['keywords'];
						$this->page['description'] = $row['description'];
		    		}
		    	}
    		} else {
    			// загружаем компоненты из админки (активация им не требуется)
    			$this->component['name']   = $this->url['component'];

                if (method_exists('controller_component_' . $this -> component['name'], 'action_' . $this->url['actions'][0])) {
                    $this->component['action'] = $this->url['actions'][0];
                } else if (method_exists('controller_component_core_' . $this -> component['name'], 'action_' . $this->url['actions'][0])) {
                    $this->component['action'] = $this->url['actions'][0];
                } else {
                    $this->component['action'] = 'else';
                }
				
				$component_info = $this->dbh->row("SELECT * FROM main WHERE component = '" . $this->component['name'] . "' ORDER BY id ASC LIMIT 1");
				if ($component_info) {
					$this->component['info'] = $component_info;
				}
    		}
    	}
	}
	
   	function load_component() {
		if(END_NAME == 'back_end' && ((!isset($_SESSION['auth']) || $_SESSION['auth']===0) || (isset($_SESSION['access']) && $_SESSION['access'] < 1))){
			if($this->url['component'] != 'users' ||  ($this->url['component']=='users' && $this->url['actions'][0] != 'login')) {
				$subject = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
				$_SESSION['backend_route'] = str_replace(SITE_URL, '', $subject); // будет использоваться в компоненте users для редиректа пользователя после авторизации.
				
				header('HTTP/1.1 301 Moved Permanently');
				header('Location: ' . $this->config['site_url'] . '/admin/users/login'); 
				exit();
			}
		}

   		$component_full_name = 'controller_component_' . $this -> component['name'];
   		//$model_component_full_name = 'model_component_' . $this -> component['name'];
   		$component_full_name_core = 'controller_component_core_' . $this -> component['name'];
   		//$model_component_full_name_core = 'model_component_core_' . $this -> component['name'];
   		//core::print_r ($component_full_name,'component_full_name');
		//if ((class_exists($component_full_name, true)) && (class_exists($model_component_full_name, true))) {
		if (class_exists($component_full_name, true)) {
			$c = new $component_full_name($this -> config, $this -> url,$this -> component, $this -> dbh);
		} else {
			$c = new $component_full_name_core($this -> config, $this -> url,$this -> component, $this -> dbh);			
		}
		$component_action_name = 'action_' . $this -> component['action'];
		//echo 'zzz' . 'action_' . $this -> component['action'] . '_zzz<br>';
		//core::print_r ($component_action_name,'component_action_name');
		$page = $c -> $component_action_name();
		
		$this->head               .= isset($page['head']) ? $page['head'] : '';
		$this->page['title']       = (isset($page['title']) && !empty($page['title'])) ? $page['title'] : $this->page['title'];
		$this->page['keywords']    = (isset($page['keywords']) && !empty($page['keywords'])) ? $page['keywords'] : $this->page['keywords'];
		$this->page['description'] = (isset($page['description']) && !empty($page['description'])) ? $page['description'] : $this->page['description'];
		$this->page['html']        = (isset($page['html']) && !empty($page['html'])) ? $page['html'] : $this->page['html'];
		
		if (is_array($page)) {		
			foreach($this->theme as $key => $value) {
				if (isset($page['theme'][$key])) {
					$this->theme[$key] = $page['theme'][$key];
				}
			}
		}
   	}
	
	function load_theme() {
		if(END_NAME == 'back_end') {
			$this->theme['name'] = 'default_admin';
		}
		$theme['url']            = SITE_URL .          '/themes/' . $this->theme['name'] ;	
		$theme['url_core']       = SITE_URL . '/user_cms/themes/' . $this->theme['name'] ;	
		$theme['full_name']      = ROOT_DIR .          '/themes/' . $this->theme['name'] . '/' . $this->theme['file'] . '.tpl';	
		$theme['full_name_core'] = ROOT_DIR . '/user_cms/themes/' . $this->theme['name'] . '/' . $this->theme['file'] . '.tpl';	
		$theme['config']         = ROOT_DIR .          '/themes/' . $this->theme['name'] . '/config.ini';	
		$theme['config_core']    = ROOT_DIR . '/user_cms/themes/' . $this->theme['name'] . '/config.ini';	


		if (file_exists($theme['full_name'])) {
			ob_start();
	        include $theme['full_name'];
	        $this->html = ob_get_clean();

		} else {
			ob_start();
	        include $theme['full_name_core'];
	        $this->html = ob_get_clean();
		}
		// загружаем css и js файлы из конфига темы
		
		if (file_exists($theme['config'])) {
			$config_file = $theme['config'];
			$theme_url = $theme['url'];
		} elseif (file_exists($theme['config_core'])) {
			$config_file = $theme['config_core'];
			$theme_url = $theme['url_core'];
		}

		if (isset($config_file)) {
			$conf = parse_ini_file($config_file);
			foreach ($conf as $key => $value) {
				if ($key == 'js') {
					$js = '';
					$js_files = explode(',', $value);
					foreach ($js_files as $filename) {
						if(!empty($filename)) {
							$js .= "\t\t" . '<script src="' . $theme_url . '/' . trim($filename) . '" type="text/javascript"></script>' . "\n";
						}
					}
					
					$this->head .= $js;
				}
				
				if ($key == 'css') {
					$css = '';
					$css_files = explode(',', $value);

					foreach ($css_files as $filename) {
						if (!empty($filename)) {
							$css .= "\t\t" . '<link href="' . $theme_url . '/' . trim($filename) . '" rel="stylesheet"  type="text/css" >' . "\n";
						}
					}
					
					$this->head .= $css; 
				}
			}
		}
	}

	function load_blocks() {
	    // загружаем блоки
		$list_positions = $this->parse_html_for_positions();
		$end_name = (END_NAME == 'back_end') ? "AND back_end = '1'" : "AND back_end='0'";
	    foreach ($list_positions as $position) {
		    $html = '';
		    $sql = "SELECT * FROM activated_modules WHERE type='block' AND position = '" . $this->dbh->escape($position) . "' " . $end_name . " ORDER BY sort ASC";
		    $list_blocks = $this->dbh->query($sql);
		    foreach($list_blocks as $block) {
				if ($this->validate_sections($block['sections'])) {
					$b = $this->load_block($block);
					$this -> head .= isset($b['head']) ? $b['head'] : '';
					$html .= $b['html'];
				}
		    }
			
			if ($position == 'before_component') {
				$this->page['html'] = $html . $this->page['html'];
			} elseif ($position == 'after_component') {
				$this->page['html'] .= $html;
			} else {
				$this->html = str_replace('[position='.$position.']', $html, $this->html);
			}
	   }
	}
	
   	function load_plugins() {
       	// загружаем плагины
		$list_plugins_positions = $this->parse_html_for_plugins();

   		$i=0;
   		foreach ($list_plugins_positions[1] as $plugin_position) {
   			$html = '';
   			$sql = "SELECT * FROM activated_modules WHERE type='plugin' AND position = '" . $this->dbh->escape($plugin_position) . "' ORDER BY sort ASC";
   			$list_plugins = $this->dbh->query($sql);
   			
   			foreach($list_plugins as $plugin) {
	   			if ($this->validate_sections($plugin['sections'])) {
					$p = $this->load_plugin($plugin, $list_plugins_positions[2][$i]);
					$this -> head .= isset($p['head']) ? $p['head'] : '';
					$html .= $p['html'];
				}
   			}
   			
   			$this->html = str_replace('{plugin:'.$plugin_position.'=' . $list_plugins_positions[2][$i] . '}', $html, $this->html);
   			$this->page['html'] = str_replace('{plugin:'.$plugin_position.'=' . $list_plugins_positions[2][$i] . '}', $html, $this->page['html']);
   			$i++;
   		}
   	}
	
	function load_pre_echo() {
		$head = '
		<title>' . $this -> page['title']  . '</title>
		<meta charset="utf-8">
		<meta name="keywords" content="' . $this -> page['keywords'] . '">
		<meta name="description" content="' . $this -> page['description'] . '">
		<link rel="icon" href="' . $this -> config['site_url'] . '/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="' . $this -> config['site_url'] . '/favicon.ico" type="image/x-icon">';
		$head .= "\n" . $this -> head;
		$this->html = str_replace('[head]', $head, $this->html);
		$this->html = str_replace('[component]', $this -> page['html'], $this->html);
		if (strpos($this->theme['file'], 'ajax') !== 0) {
			$this->html .= "\n<!-- UserCms " . USER_CMS_VERSION . " - " . date('d.m.Y H:i') . " -->";
		}

	}

     function __destruct() {
       	// закрываем соединение с базой
   		$this -> db_close();
    }

   	//////////////// вспомогательные функции

	protected function parse_url() {
		$url = array();
		$url['component'] = '';
		$url['actions'] = array();
		$url['params'] = array();
		
        $protocol = (!isset($_SERVER['HTTPS']) || empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off') ? 'http://' : 'https://';
            $pre =  $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ;
            $pre = str_replace($this->config['site_url'],'',$pre);
            if(strpos($pre, $protocol) === 0) {
            exit('Error #1: Site URL in config.ini is wrong. Current value: '.$this->config['site_url']);
        }
		
		// обрезаем слэши в конце урла
		$default_pre_len = $current_pre_len = mb_strlen(str_replace('//', '/', $pre), 'UTF-8');
		while($current_pre_len > 1 && mb_substr($pre, -1) == '/') {
			$pre = mb_substr($pre, 0, $current_pre_len-1, 'UTF-8');
			$current_pre_len = mb_strlen($pre, 'UTF-8');
		}
		if($default_pre_len !== $current_pre_len || strpos($pre, '//') !== false) { // убрали минимум 1 слэш - редиректим на новый урл
			while (strpos($pre, '//') !== false) {
				$pre = str_replace('//', '/', $pre);
			}
			$target = $this->config['site_url'] . $pre;
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: ' . str_replace('&amp;', '&', $target));
			exit();
		}
		
        $pos = strpos($pre, '?');
        if ($pos !== false) $pre = substr($pre, 0, $pos);

		$url['request_uri'] = $pre;
        define('IS_MAIN_PAGE', $pre == '/');
		
		$pre = explode('/', $pre);


		// разная разбивка URL в зависимости от того находимся ли мы в админ панели или нет
		if($pre[1] == 'admin') {
			define('END_NAME', 'back_end');
			if( ! isset($pre[2])) {
				$url['component']='pages';
			} else {
				$url['component'] = $pre[2];
			}
			$i=3;
		} else {
			define('END_NAME', 'front_end');
			if (strpos($pre[1], '=') === false) {
				$url['component'] = $pre[1];
				$i=2;
			} else {
				$i=1;
			}
		}
		
		while($i <= count($pre)) {
			if(!empty($pre[$i])) {
				if(strpos($pre[$i], '=') !== false) {
					$pre2 = explode('=', $pre[$i]);
					$url['params'][$pre2[0]] = $pre2[1];
				} 
				else {
					$url['actions'][] = $pre[$i];
				}
			}
			$i++; 
		}
		if(count($url['actions'])==0) {
			$url['actions'][0]='index';
		}
		// склеиваем index.php, index.html, index.htm, index c /
		if($url['component'] == 'index.php' or $url['component'] == 'index.html' or $url['component'] == 'index.htm' or $url['component'] == 'index' ) {
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: ' . $this->config['site_url']); 
			exit();
		}

		return $url;
	}

	function db_connect() {
		require_once(ROOT_DIR . '/user_cms/helpers/sqlite_pdo.php');
		$dbh = new DB("sqlite:". ROOT_DIR ."/db.sqlite");
		if($this->config['db_error_reporting']){
			$dbh->error = true;
		}

    	return $dbh;
	}
	function db_close() {
		$this -> dbh = NULL;
	}

	function set_error_reporting() {
        $constants = array(
            'E_ERROR' => E_ERROR,
            'E_WARNING' => E_WARNING,
            'E_PARSE' => E_PARSE,
            'E_NOTICE' => E_NOTICE,
            'E_CORE_ERROR' => E_CORE_ERROR,
            'E_CORE_WARNING' => E_CORE_WARNING,
            'E_COMPILE_ERROR' => E_COMPILE_ERROR,
            'E_COMPILE_WARNING' => E_COMPILE_WARNING,
            'E_USER_ERROR' => E_USER_ERROR,
            'E_USER_WARNING' => E_USER_WARNING,
            'E_USER_NOTICE' => E_USER_NOTICE,
            'E_STRICT' => E_STRICT,
            'E_RECOVERABLE_ERROR' => E_RECOVERABLE_ERROR,
            'E_USER_DEPRECATED' => E_USER_DEPRECATED,
            'E_ALL' => E_ALL
        );
        $total_value = 0;
        foreach ($constants as $name => $value) {
            if (strpos($this->config['error_reporting'], $name) !== false) $total_value = $total_value | $value;
        }
		error_reporting($total_value);
	}
	
	function load_addon($addon) {
		$full_name = 'controller_addon_' . $addon['module_dir'];
		$full_name_core = 'controller_addon_core_' . $addon['module_dir'];
		if (class_exists($full_name, true)) {
			$a = new $full_name($this->config, $this->url, $addon['module_dir'], $this->dbh);
		} else {
			$a = new $full_name_core($this->config, $this->url, $addon['module_dir'], $this->dbh);
		}
		return $a->action_index($addon);
	}
	
	function load_block($block, $action='index') {
        $full_name = 'controller_block_' . $block['module_dir'];
        $full_name_core = 'controller_block_core_' . $block['module_dir'];
		if (class_exists($full_name, true)) {
			$b = new $full_name($this->config, $this->url, $block['module_dir'], $this->dbh);
		} else {
			$b = new $full_name_core($this->config, $this->url, $block['module_dir'], $this->dbh);			
		}
        $full_action_name = 'action_' . $action;
        return $b->$full_action_name($block);
    }
	
	function load_plugin($plugin, $run_params='') {
		$full_name = 'controller_plugin_' . $plugin['module_dir'];
		$full_name_core = 'controller_plugin_core_' . $plugin['module_dir'];
		if (class_exists($full_name, true)) {
			$p = new $full_name($this->config, $this->url, $plugin['module_dir'], $this->dbh);
		} else {
			$p = new $full_name_core($this->config, $this->url, $plugin['module_dir'], $this->dbh);			
		}
		$p->run_params = $run_params; // добавляем объекту свойство, содержащее строку с параметрами, передаваемыми в шаблоне
		return $p->action_index($plugin);
	}

	function parse_html_for_positions() {
		preg_match_all("/\[position\=(.*)\]/U", $this->html ,  $out); 
		$positions = $out[1];
		$positions[] = 'before_component';
		$positions[] = 'after_component';
		return $positions;
	}

	function parse_html_for_plugins() {
		if(strpos($this->page['html'],'<textarea') !== false) {
            $html = $this->html.preg_replace('/<textarea(?!<\/textarea>)[\s\S]+?<\/textarea>/', '', $this->page['html']);
		} else {
			$html = $this->html . $this->page['html'];
		}
		preg_match_all("/\{plugin:(.*)\=(.*)\}/U", $html ,  $out); 
		return $out;
	}
	
	
	public function validate_sections($sections) {
		if (!$sections) {
			return true;
		}
		
		$sections = unserialize($sections);
		
		if (empty($this->url['component'])) { // главная
			$main_id = 1;			
		} elseif (($this->component['name'] == 'pages' && $this->component['action'] == 404) || !$this->component['info']) {
			$main_id = 0;
		} else {
			$main_id = $this->component['info']['id'];
		}

		if ($sections['type'] == 'choosed') { // на выбранных
			return in_array($main_id, $sections['values']);
		} else { // на всех, кроме выбранных
			return !in_array($main_id, $sections['values']);
		}
	}

	function print_r($var, $var_name = '') {
		echo '<pre style="outline: 1px dotted grey;padding:5px;">';
		if( ! empty($var_name)) {
			echo '<h3>' . $var_name . '</h3>';
		}
		if(is_string($var)){
			$var = htmlspecialchars($var);
		}
		print_r($var);
		echo '</pre>';
	}

	function var_dump($var, $var_name = '') {
		echo '<pre style="outline: 1px dotted grey;padding:5px;">';
		if( ! empty($var_name)) {
			echo '<h3>' . $var_name . '</h3>';
		}
		var_dump($var);
		echo '</pre>';
	}
	
}



function __autoload($class_name) {
	$core_dir        = '/user_cms';
	$module_type_dir = '/components';
	$module_name_dir = '/pages';
	$end_name        = '';
    if (in_array($class_name, array('component', 'model', 'addon', 'block', 'plugin', 'module'))) {
        require_once(ROOT_DIR . '/user_cms/modules/' . $class_name . '.php');
    }
    elseif(strpos($class_name, 'controller_') === 0 OR strpos($class_name, 'model_') === 0) {
    	$file_name =  str_replace( array('controller_','model_'), '', $class_name);
        
  		if(strpos($file_name, 'component_') === 0) {
  			$module_type_dir = '/components';
  			$end_name        = '/' . END_NAME;
  		}
  		elseif(strpos($file_name, 'addon_') === 0) {
  			$module_type_dir = '/addons';
  		}
  		elseif(strpos($file_name, 'plugin_') === 0) {
  			$module_type_dir = '/plugins';
  		}
  		elseif(strpos($file_name, 'block_') === 0) {
  			$module_type_dir = '/blocks';
  		}
  		$module_name_dir =  str_replace(array('component_', 'addon_', 'plugin_', 'block_'), '', $file_name);
  		$core_dir = (strpos($module_name_dir, 'core_') === 0) ? '/user_cms' : '';
  		$module_name_dir =  str_replace('core_', '', $module_name_dir);

  		$f = ROOT_DIR . $core_dir .  '/modules' . $module_type_dir . '/' . $module_name_dir . $end_name . '/' . $class_name . '.php';
		//echo $f. '<br>';
    	if(  file_exists($f)) {
           	require_once($f);
        }
    }
} 