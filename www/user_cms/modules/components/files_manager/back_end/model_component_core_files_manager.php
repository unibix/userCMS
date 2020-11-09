<?php class model_component_core_files_manager extends model {

	//проверка является ли ОС windows
	public function is_windows(){
		return stripos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') ? true : false;
	}

	/**
	* Смена кодировки из windows-1251 в utf-8 или обратно если ОС является windows
	* @param string $var исходная строка
	* @param bool $utf_to_win направление - true - utf-8 -> windows-1251, false - windows-1251 -> true
	* @return возвращает строку с нужной кодировкои если windows 
	*/
	public function win_to_utf($var, $utf_to_win = false){
		if($this->is_windows()){
			$encoding = mb_detect_encoding($var);
			return $utf_to_win ? iconv($encoding, 'utf-8', $var) : iconv($encoding, 'utf-8',  $var);
		}else{
			return $var;
		}
	}

	/**
	* Формирует строку с размером файла 
	* @param number $size_in_b размер в байтах
	* @return возвращает строку с размером в нужном формате с единицой (в б кб мб или гб)
	*/
	public function out_size($size_in_b){
	    if($size_in_b / pow(2,30) >= 1){
	        return round($size_in_b / pow(2,30), 1) . ' гб';
	    }else if($size_in_b / pow(2,20) >= 1){
	        return round($size_in_b / pow(2,20), 2) . ' мб';
	    }else if($size_in_b / pow(2,10) >= 1){
	        return round($size_in_b / pow(2,10), 2) . ' кб';
	    }else{
	        return $size_in_b . ' б';
	    }
	}
	
	/**
	* Рекурсивное удаление дерева
	* @param $dir путь к папке
	* @return true при успехе false при ошибке
	*/
	public function del_tree($dir) { 
		$files = array_diff(scandir($dir), array('.','..')); 
		foreach ($files as $file) { 
		  (is_dir("$dir/$file")) ? $this->del_tree("$dir/$file") : unlink("$dir/$file"); 
		} 
		return rmdir($dir); 
	}


	/**
	* Удаляет файлы или папки
	* @param string $item поный путь к элементу
	* @return true при успешном удалении false при ошибке
	*/
	public function delete_item($item) {
		if(is_file($item)){
			return unlink($item);
		}else if(is_dir($item)){
			return $this->del_tree($item);
		}else{
			return false;
		} 
	}

	/**
	* Возвращает содержание папки или false при ошибке
	* @param string $path путь к папке
	* @return array массив с элементами в папке или false при ошибке	
	*/
	public function get_directory_content($path){
		if(!is_dir($path) || !$dir = scandir($path))return false;
		$dir = array_diff($dir, array('..'));//список файлов и папок текущей директории
		$content = array(
			'dirs' 		=>array(),//папки
			'files' 	=>array(),//файлы
			'others'	=>array()//не определенные
		);
		foreach ($dir as $key => &$value) {
			if($this->is_windows()){$value = $this->win_to_utf($value);}
			if($value != str_replace('/', '', $_SERVER['PHP_SELF'])){//пропускаем файл самого скрипта
				if(is_dir($path . '/' .  $this->win_to_utf($value, true) )){
					$content['dirs'][] = $value;
				}elseif(is_file($path . '/' . $this->win_to_utf($value, true) )){
					$content['files'][] = $value;
				}else{
					$content['others'][] = $value;
				}
			}
		}
		return array_merge($content['dirs'], $content['files'], $content['others']);
	}

	/**
	* Переименование элементов
	* @param string $new_name - новое название
	* @param string $old_name - старое название
	* @param string $path - путь к файлу
	* @return true в случае успеха false в случае ошибки
	*/
	public function rename_item($new_name, $old_name, $path){
		$new_name = $this->win_to_utf($new_name, true);
		$old_name = $this->win_to_utf($old_name, true);
		return rename($path . '/' . $old_name, $path . '/' . $new_name);

	}

	public function addFileRecursion($zip, $dir, $start = '')
	{
		if (empty($start)) {
			$start = $dir;
		}
		
		if ($objs = glob($dir . '/*')) {
			foreach($objs as $obj) { 
				if (is_dir($obj)) {
					$this->addFileRecursion($zip, $obj, $start);
				} else {
					$zip->addFile($obj, str_replace(dirname($start) . '/', '', $obj));
				}
			}
		}
	}

	public function recursiveRemoveDir($dir) {

		$includes = new FilesystemIterator($dir);
	
		foreach ($includes as $include) {
	
			if(is_dir($include) && !is_link($include)) {
	
				$this->recursiveRemoveDir($include);
			}
	
			else {
	
				unlink($include);
			}
		}
	
		rmdir($dir);
	}

	/**
 	* Создает .zip архив с выбранными файлами
 	* @param array $files массив с названиями файлов для архивации
 	* @param string $path путь к каталогу
 	* @return название архива при успехе, false если возникла ошибка
	*/
	public function pack_archive($files, $path, $delete = false){
		if(!is_array($files) || empty($path) || count($files) < 1) {
			return false;
		}

		$zip = new ZipArchive;
		$zipname = time() . '_' . rand();
		if ($zip->open($path . '/' . $zipname . '.zip', ZipArchive::CREATE) === true){
			foreach ($files as $key => $file) {
				if(is_file($path . '/' . $this->win_to_utf($file, true)))$zip->addFile($path . '/' . $file, $file);

				if(is_dir($path . '/' . $this->win_to_utf($file, true))) {
					$this->addFileRecursion($zip, $path . '/' . $file);
				}
			}

			if($delete) {
				if($zip->close()) {
					// заставляем браузер показать окно сохранения файла
					header('Content-Description: File Transfer');
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename=' . basename($path . '/' . $zipname . '.zip'));
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize($path . '/' . $zipname . '.zip'));
					// читаем файл и отправляем его пользователю
					out($path . '/' . $zipname);
					readfile($path . '/' . $zipname . '.zip');
					unlink($path . '/' . $zipname . '.zip');
					exit;
				} else {
					return false;
				}
			} else {
				return $zip->close() ? $zipname : false;
			}
		}else{
			return false;
		}
	}

	public function delete_files($files, $path){
		if(count($files) < 1) {
			return false;
		}

		foreach ($files as $key => $file) {

			if(is_file($path . '/' . $this->win_to_utf($file, true))) {
				unlink($path . '/' . $this->win_to_utf($file, true));
			}

			if(is_dir($path . '/' . $this->win_to_utf($file, true))) {
				$this->recursiveRemoveDir($path . '/' . $this->win_to_utf($file, true));
			}
		}

		return true;
	}

	/**
 	* распаковывает .zip архив 
 	* @param string $file название файла
 	* @param string $path каталог
 	* @return true при успехе, false если возникла ошибка
	*/
	public function unpack_archive($file, $path){
		$zip = new ZipArchive;
	    if(!$zip->open($path. '/' . $file))return false;
	    $zip->extractTo($path);
	    return $zip->close();
	}


	
} 