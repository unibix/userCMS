<?php class controller_component_core_files_manager extends component {
	public $is_windows = '';//проверка на ос windows
	public $errors = array();
	public $text_extensions = array('txt', 'php', 'doc', 'docx', 'tpl', 'odt');//расширения текстовых файлов (те что можно редактировать)
	public $get_query = '';//строка текущего get запроса
	public $prohibited_chars = array('\\', '/', ':', '*', '?', '"', '>', '<', '|', '+', '%', '!', '@', '&');//запрещенные символы в именах файлов
	public $image_extensions = array('jpg', 'jpeg', 'png', 'gif');
	public $success = '';

	function __construct($config, $url, $component, $dbh){
		parent::__construct($config, $url, $component, $dbh);
		define('SELF_SCRIPT', $_SERVER['SCRIPT_NAME']);//сам файл скрипта менеджера
		$this->is_windows = stripos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows')?true:false;
		$this->errors = isset($_GET['errors'])&&!empty($_GET['errors'])?unserialize($_GET['errors']):array();
		$this->get_query = !empty($_SERVER['QUERY_STRING'])?$_SERVER['QUERY_STRING']:false;

	}

	function action_index() {
		$this->page['title'] = 'Менеджер файлов';
		if(isset($_GET['success']) && !empty($_GET['success'])){//сообщения об успехе
			switch ($_GET['success']){
				case 'f_upl':
					$this->success = 'Файл успешно загружен';
					break;
				case 'upk':
					$this->success = 'Файлы успешно извлечены';
					break;
				case 'upd':
					$this->success = 'Сохранено';
					break;
				case 'del':
					$this->success = 'Успешно удалено';
					break;
				default:
					$this->success = 'Успешно!';
					break;
			}
		}

		if(!isset($_SESSION['path'])){$_SESSION['path'] = ROOT_DIR;}//основной путь

		if(isset($_GET['name'])){//выбор элемента
			$n =  $this->model->win_to_utf(trim($_GET['name']), true);
			if($_GET['name'] == '.' && $_SESSION['path'] != ROOT_DIR){
				$_SESSION['path'] = mb_strrchr($this->model->win_to_utf($_SESSION['path']), '/', true);
				$_SESSION['path'] = $this->model->win_to_utf($_SESSION['path'], true);
			}else if(is_dir($_SESSION['path'] . '/' . $n)){//если выбрана папка перезаписываем путь
				$_SESSION['path'] .= '/' . $n; 
			}else{
				//если не папка ничего не делаем
			}
		}else{
			// $_SESSION['path'] = ROOT_DIR;
		}

		if(isset($_GET['name']) && isset($_GET['change'])){ //выбор элемента
			$index_str = mb_strrpos($_SESSION['path'], $_GET['name']) + mb_strlen($_GET['name']);
			$_SESSION['path'] = mb_substr($this->model->win_to_utf($_SESSION['path']), 0, $index_str);
			$_SESSION['path'] = $this->model->win_to_utf($_SESSION['path'], true);
		}

		$path = $_SESSION['path'];//текущий путь к директории
		$url_fm = str_replace(ROOT_DIR, SITE_URL . '/admin/' . $this->component_name, $path);//текущий адрес
		//получаем содержание папки
		if(!$dir = $this->model->get_directory_content($path)){
			$path = $_SESSION['path'] = ROOT_DIR;
			$dir = $this->model->get_directory_content($path);
		}

		//переименование
		if(isset($_POST['rename']) && !isset($_POST['cancel'])){
			$old_name = trim(htmlentities(strip_tags($_POST['old_name'])));
			$new_name = trim(htmlentities(strip_tags($_POST['new_name'])));
			if(mb_strlen($new_name) == 0){$this->errors[] = 'Имя не введено';}

			foreach ($this->prohibited_chars as $key => $char) {
				if(mb_stristr($new_name, $char)){
					$this->errors[] = 'Символы ' . implode(' ', $this->prohibited_chars) . ' запрещены в именах файлов и папок';
					break;
				}
			}
			if(count($this->errors) === 0){
				if($this->model->rename_item($new_name, $old_name, $path)){
					$this->redirect(SITE_URL . '/admin/' . $this->component_name . '?' . str_replace('rename', '', $this->get_query));
				}else{
					$this->errors[] = 'Ошибка при переименовании';
				}					
			}
		}

		//загрузка файла
		if(isset($_POST['upload'])){
			if($_FILES['files']['error'][0] == 4){
				$this->errors[] = 'Ошибка загрузки.';
			}

			if(isset($_FILES['files']['name'][0]) && !empty($_FILES['files']['name'][0])) {
				foreach($_FILES['files']['name'] as $key => $name) {
					if(!move_uploaded_file($_FILES['files']['tmp_name'][$key], $path . '/' . $this->model->win_to_utf($name, true))) {
						$this->errors[] = 'Ошибка при загрузке файла';
					}
				}

				if(!count($this->errors)) {
					$this->redirect( SITE_URL . '/admin/' . $this->component_name . ($this->get_query?'?'.$this->get_query.'&success=f_upl':'?success=f_upl'));
				}
			}

		}

		//удаление
		if(isset($_GET['delete']) && !empty($_GET['delete'])){

			$f = trim(htmlentities(strip_tags($_GET['delete'])));
			$item_to_delete = $path . '/' . $this->model->win_to_utf($f, true);
			if($this->model->delete_item($item_to_delete)){
				$this->redirect(SITE_URL . '/admin/' . $this->component_name . '?' . str_replace(['delete', 'upk', 'upd'], '', $this->get_query) . '&success=del');
			}else{
				$this->errors[] = 'Ошибка при удалении';
			}
		}

		//редактирование текстовых файлов
		if(isset($_GET['edit_item']) && !empty($_GET['edit_item'])){
			$e = trim(htmlentities(strip_tags($_GET['edit_item'])));
			$item_to_edit = $path . '/' . $this->model->win_to_utf($e, true);
			$file_content = is_file($item_to_edit)?file_get_contents($item_to_edit):'';
		}
		if(isset($_POST['save_changes'])){
			$text = $_POST['text'];
			if(file_put_contents($item_to_edit, $text)){
				$this->redirect(SITE_URL . '/admin/' . $this->component_name . '?edit_item=' . $e . '&success=upd');
			}else{
				$this->errors[] = 'Ошибка при сохранении';
			}
		}
		if(isset($_POST['discard_changes'])){//отмена и закрытие текстового редактора
			unset($_GET['edit_item']);
			$this->redirect(SITE_URL . '/admin/' . $this->component_name . '?' . str_replace(['edit_item', '?success=upd', '&success=upd'], '', $this->get_query));
		}


		//архивация/разархивация
		if(isset($_POST['archivate'])){
			if(isset($_POST['files_to_archiving'])  && $zipname = $this->model->pack_archive($_POST['files_to_archiving'], $path)){
				$this->redirect(SITE_URL . '/admin/' . $this->component_name . '?rename_item=' . $zipname . '.zip');
			}else{
				$this->errors[] = 'Ошибка при создании архива';
			}	
		}

		//скачивание
		if(isset($_POST['download'])){
			if(isset($_POST['files_to_archiving']) && !empty($_POST['files_to_archiving'])) {
				if($this->model->pack_archive($_POST['files_to_archiving'], $path, true)){
					// out($zipname);
				}else{
					$this->errors[] = 'Ошибка скачивания';
				}	
			} else {
				$this->errors[] = 'Ошибка скачивания';
			}
		}

		//удаление
		if(isset($_POST['delete'])){
			if(isset($_POST['files_to_archiving'])){
				$this->model->delete_files($_POST['files_to_archiving'], $path);
				$this->redirect(SITE_URL . '/admin/' . $this->component_name . '?success=del');
			}else{
				$this->errors[] = 'Нет файлов для удаления';
			}	
		}

		if(isset($_GET['unpack']) && !empty($_GET['unpack'])){
			if($this->model->unpack_archive($_GET['unpack'], $path)){
				$this->redirect(SITE_URL . '/admin/' . $this->component_name . '?success=upk');
			}else{
				$this->errors[] = 'Ошибка при извлечении файлов из архива';
			}
		}

		//отмена архивации
		if(isset($_GET['cancel_arch'])){
			unset($_GET['cancel_arch']);
			$this->redirect(SITE_URL . '/admin/' . $this->component_name);
		}


		$this->data['root_dir'] = str_replace('\\', '\\\\', $this->model->dbh->escape(ROOT_DIR));
 		if(count($this->errors) > 0)$this->success=false;
		$this->data['errors'] = $this->errors;
		$this->data['success'] = $this->success;
		$this->data['path'] = $path;
		$this->data['url'] = $url_fm;
		$this->data['dir'] = $dir;
		$this->data['image_extensions'] = $this->image_extensions;
		$this->data['text_extensions'] = $this->text_extensions;
		$this->data['get_query'] = $this->get_query;
		$this->data['file_content'] = isset($file_content)?$file_content:'';

		$this->page['html'] = $this->load_view();
		return $this->page;
	}

}
