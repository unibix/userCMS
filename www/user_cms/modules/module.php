<?php 

class module {
	public $config;
	public $url;
	public $dbh;
	public $data = array();
	
	private static $_components_config = array();
	
	private static $_components_info = array();
	
	private static $_global_data = array();
	
	public function __construct($config, $url, $module, $dbh) {
		$this->config = $config;
		$this->url    = $url;
		$this->dbh    = $dbh;
	}
	
	public function add_js($html) {
		return "\t\t<script>" . $html . "</script>\n";
	}
	public function add_js_file($name) {
		return "\t\t<script src=\"" . $name . "\"></script>\n";
	}
	public function add_css($html) {
		return "\t\t<style>" . $html . "</style>\n";
	}
	public function add_css_file($name) {
		return "\t\t<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $name . "\">\n";
	}
	
	protected function load_helper($name) {
		$helper = 'helper_' . $name;
		if(file_exists(ROOT_DIR . '/user_cms/helpers/' . $helper . '.php')){
			require_once(ROOT_DIR . '/user_cms/helpers/' . $helper . '.php');
			$this->$helper = new $helper;
		}
	}
	
	protected function redirect($url, $status = 302) {
		header('Status: ' . $status);
		header('Location: ' . str_replace('&amp;', '&', $url));
		exit();
	}

	protected function translit($str){
		$str = $this->mb_strtr($str, array(
			"а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"e",
			"ж"=>"zh","з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l","м"=>"m",
			"н"=>"n","о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t","у"=>"u",
			"ф"=>"f","х"=>"h","ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"shch","ъ"=>"",
			"ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya","ї"=>"i", "є"=>"ie",
			"А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D","Е"=>"E","Ё"=>"E",
			"Ж"=>"ZH","З"=>"Z","И"=>"I","Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M",
			"Н"=>"N","О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T","У"=>"U",
			"Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH","Ш"=>"SH","Щ"=>"SHCH","Ъ"=>"",
			"Ы"=>"Y","Ь"=>"","Э"=>"E","Ю"=>"YU","Я"=>"YA","Ї"=>"I", "Є"=>"IE",
								)
					);			
		 return $str;
	}
	
	protected function str2url($text) {
		// переводим в транслит
		$text = $this->translit($text);
		// в нижний регистр
		$text = strtolower($text);
		// пробел на тире
		$converter = array( '   ' => '-',   '  ' => '-',  ' ' => '-',);
		$text = strtr($text, $converter);
		// удаляем все лишнее
		$text = preg_replace('/[^a-z0-9._-]/u', '', $text);
		// удаляем начальные и конечные '-' и пробел
		$text = trim(trim($text), "-");
		
		return $text;
	}
	
	public function get_component_config($component_name) {
		if (isset(self::$_components_config[$component_name])) {
			return self::$_components_config[$component_name];
		} else {
			return self::_get_component_config($component_name);
		}
	}
	
	public function get_component_info($component_name) {
		if (isset(self::$_components_info[$component_name])) {
			return self::$_components_info[$component_name];
		} else {
			return self::_get_component_info($component_name);
		}
	}
	
	private function _get_component_config($component_name) {
		$ini_path = file_exists(ROOT_DIR . '/modules/components/' . $component_name . '/back_end/component.ini') ? ROOT_DIR . '/modules/components/' . $component_name . '/back_end/component.ini' : ROOT_DIR . '/user_cms/modules/components/' . $component_name . '/back_end/component.ini';
		$config = array();
		
		if (file_exists($ini_path) && is_readable($ini_path)) {
			$results = parse_ini_file($ini_path, true);
			
			foreach ($results as $key => $result) {
				if (is_array($result) && isset($result['value'])) {
					$config[$key] = $result['value'];
				}
			}
		}
		
		self::$_components_config[$component_name] = $config;
		
		return $config;
	}
	
	private function _get_component_info($component_name) {
		$result = $this->dbh->row("SELECT * FROM main WHERE component = '" . $this->dbh->escape($component_name) . "' ORDER BY id ASC LIMIT 1");
		if ($result) {
			self::$_components_info[$component_name] = $result;
			return $result;
		} else {
			self::$_components_info[$component_name] = null;
			return null;
		}
	}
	
	public function get_global_data($key) {
		if (isset(self::$_global_data[$key])) {
			return self::$_global_data[$key];
		} else {
			return null;
		}
	}
	
	public static function set_global_data($key, $value) {
		self::$_global_data[$key] = $value;
	}
}
