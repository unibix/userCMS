<?php
class controller_component_core_update extends component {
	
	function action_index() {
		$archive_types = array(
			'application/force-download',
			'application/x-zip-compressed',
			'application/zip',
			'application/x-zip',
			'multipart/x-zip',
			'application/octet-stream'
		);
		
		if (isset($_SESSION['success'])) {
			$this->data['message'] = $_SESSION['success'];
			unset($_SESSION['success']);
		}
		
		if(isset($_POST['update_core'])) {
			$errors = array();
			// загружаем архив
			if( ! is_uploaded_file($_FILES['archive']['tmp_name'])) {
				$errors[] = 'Архив не загружен';
			}
			else {
				if(!in_array($_FILES['archive']['type'], $archive_types)) {
					$errors[] = 'Выбранный файл не является архивом ZIP';
				}
				else {
					move_uploaded_file($_FILES['archive']['tmp_name'], ROOT_DIR . '/temp/' .$_FILES['archive']['name']);
					$zip = new ZipArchive;
					$zip->open(ROOT_DIR . '/temp/' .$_FILES['archive']['name']);
					if(@$zip->getFromName('update_config.ini') === false) {
						$errors[] = 'Файла update_config.ini нет в архиве';
					}
					else {
						if(@$zip->getFromName('update.php') === false) {
							$errors[] = 'Файла update.php нет в архиве';
						}
						else {
							// читаем файл update_config.ini
							$update_config = parse_ini_string($zip->getFromName('update_config.ini'));
							
							// проверяем версию
						    if($update_config['version'] != USER_CMS_VERSION) {
						    	$errors[] = 'Обновление для другой версии';
						    }
						    else {
						    	// проверяем сборку
						    	if($update_config['edition'] != USER_CMS_EDITION) {
							    	$errors[] = 'Обновление для другой сборки';
							    }
							    else {
							    	// проверяем папки на запись
							    	$dirs = array(	'user_cms',
							    					'user_cms/themes',
							    					'user_cms/modules',
							    					'user_cms/modules/addons',
							    					'user_cms/modules/plugins',
							    					'user_cms/modules/components',
							    					'user_cms/modules/blocks',
							    					'modules',
							    					'temp',
							    					'themes');
							    	for ($i = 0; $i < count($dirs); $i++) {
							    		 if( ! is_writable($dirs[$i])) {
							    		 	$errors[] = 'Папка <b>' . $dirs[$i] . '</b> не доступна для записи.';
							    		 }
							    	}
							    	// проверяем файлы на запись
							    	for ($i = 0; $i < $zip->numFiles; $i++) {
									     $filename = iconv('CP866', 'UTF-8', $zip->getNameIndex($i));
									   // echo = iconv('CP866', 'UTF-8',  $filename)  . '<br>';
									    if( file_exists($filename) && ! is_writable($filename) ) {
									    	$errors[] = 'Файл <b>' . $filename . '</b> не доступен для записи.';
									    }
									}

									if(count($errors) == 0) {
										// распаковываем в корень архив
										$zip->extractTo(ROOT_DIR);
										$zip->close();
										// инклюдим файл update.php
										require(ROOT_DIR . '/update.php');
										// удаляем update.php и update_config.ini и сам архив
										unlink(ROOT_DIR . '/update.php');
										unlink(ROOT_DIR . '/update_config.ini');
										unlink(ROOT_DIR . '/temp/' . $_FILES['archive']['name']);

										$_SESSION['success'] = 'Обновление успешно установлено';
										$this->redirect(SITE_URL . '/admin/' . $this->component_name);
									}
							    }
						    }
						}
					}
				}
			}
			
			if(count($errors) != 0) {
				$this->data['error'] = implode("<br>", $errors);
			}

		}
		


		// выводим форму для загрузки обновления
		$this->page['html'] = $this->load_view();
		$this->page['title'] = 'Обновление ядра';
		return $this->page;

	}

}