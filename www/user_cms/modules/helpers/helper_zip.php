<?php 

class helper_zip {
	public function zip_directory($src_dir, $zip, $dir_in_archive='', $add_files = true) {
		$dirHandle = opendir($src_dir);
		while (false !== ($file = readdir($dirHandle))) {
			if (($file != '.') && ($file != '..') && !empty($file)) {
				if (!is_dir($src_dir . '/' . $file)) {
					if ($add_files) {
						$zip->addFile($src_dir . '/' . $file, $dir_in_archive . '/' . $file);
					}
				} else {
					$zip->addEmptyDir($dir_in_archive . '/' . $file);
					$zip = $this->zip_directory($src_dir . '/' . $file, $zip, $dir_in_archive . '/' . $file, $add_files);
				}
			}
		}
		return $zip;
	}
	
	public function extract_zip_archive($zip_name_full, $zip_folder_full) { //полный путь файла zip, полный путь папки для распаковки
		if (!is_dir($zip_folder_full)) mkdir($zip_folder_full);
		$zip = new ZipArchive(); //Создаём объект для работы с ZIP-архивами
		//Открываем архив archive.zip и делаем проверку успешности открытия
		if ($zip->open($zip_name_full) === true) {
			$zip->extractTo($zip_folder_full); //Извлекаем файлы в указанную директорию
			$zip->close(); //Завершаем работу с архивом
		}
		//else echo "Архива не существует!"; //Выводим уведомление об ошибке	
	}
	
	function deleteDirectory($dir) {
		if (!file_exists($dir)) {
			return true;
		}

		if (!is_dir($dir)) {
			return unlink($dir);
		}

		foreach (scandir($dir) as $item) {
			if ($item == '.' || $item == '..') {
				continue;
			}

			if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
				return false;
			}

		}

		return rmdir($dir);
	}	
}
