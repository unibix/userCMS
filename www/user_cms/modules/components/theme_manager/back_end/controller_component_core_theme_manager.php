<?php
class controller_component_core_theme_manager extends component
{
	public function action_index() {
		$this->data['themes'] = $this->model->get_themes();
		
		$this->data['page_name'] = 'Редактирование тем';
		
		$this->data['button_install'] = SITE_URL . '/admin/' . $this->url['our_component_name'] . '/install';
		$this->data['button_change_theme'] = SITE_URL . '/admin/config';
		
		$page = array();
		$page['title'] = 'Менеджер тем';
		$page['keywords'] = 'Редактирование тем';
		$page['description'] = 'Редактирование тем';
		$page['html'] = $this->load_view('index');
		
		return $page;
	}
	
	public function action_theme() {
	
		$theme = $this->model->get_theme($this->url['actions'][1]);
		
		$path = ROOT_DIR;
		
		if($theme['is_core_theme']) {
			$path .= '/user_cms';
		}
		
		$path .= '/themes/' . $theme['name'];
		
		if(isset($this->url['params']['folder'])) {
			$path .= '/' . $this->url['params']['folder'];
		}
		
		$path .= '/' . $this->url['params']['file'];
		
		if(isset($_POST['submit_theme'])) {
			// TODO добавить проверку на наличие необходимых прав
			unlink($path);
			$handle = fopen($path, 'w');
			if(fwrite($handle, $_POST['theme_content']) !== false) {
				$this->redirect(SITE_URL . '/admin/' . $this->url['our_component_name'] . '/success=edited/theme=' . $this->url['actions'][1] . '/file=' . $this->url['params']['file']);
			}
			
		}
		
		$this->data['theme_content'] = file_get_contents($path);
		
		$this->data['page_name'] = 'Редактирование файла ' . $this->url['params']['file'] . '. Тема ' . $theme['name'];
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs($this->data['page_name'], '');
		$page['title'] = 'Менеджер тем';
		$page['keywords'] = 'Менеджер тем';
		$page['description'] = 'Менеджер тем';
		$page['html'] = $this->load_view('theme');
		
		return $page;
		//echo '<pre>'; print_r($theme); echo '</pre>';
		//echo '<pre>'; print_r($this->url['actions']); echo '</pre>';
	}
	
	public function action_install() {
		$this->data['errors'] = array();
		$this->data['success'] = array(); 
	
		if(isset($this->url['params']['success']) && $this->url['params']['success']=='installed') {
			$this->data['success'][] = 'Тема установлена.';
		}
		if(isset($_POST['upload_theme'])) {
			$archive_types = array(
				'application/force-download',
				'application/x-zip-compressed'
			);
			
			if(is_uploaded_file($_FILES['theme']['tmp_name'])) {
				if(in_array($_FILES['theme']['type'], $archive_types)) {
					move_uploaded_file($_FILES['theme']['tmp_name'], ROOT_DIR . '/temp/' .$_FILES['theme']['name']);
					
					$zip = new ZipArchive;
					
					if($zip->open(ROOT_DIR . '/temp/' . $_FILES['theme']['name']) === true) {
						$zip->extractTo(ROOT_DIR . '/themes/');
						$zip->close();
						
						unlink(ROOT_DIR . '/temp/' . $_FILES['theme']['name']);
						
						$this->redirect(SITE_URL . '/admin/' . $this->url['our_component_name'] . '/install/success=installed');
					} else {
						$this->data['errors'][] = 'Не удалось открыть архив';
					}
				} else {
					
				}
			} else {
				$this->data['errors'][] = '';
			}
		}
		$this->data['page_name'] = 'Установка темы';
		$this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs($this->data['page_name'], '');
		$page['title'] = 'Менеджер тем';
		$page['keywords'] = 'Менеджер тем';
		$page['description'] = 'Менеджер тем';
		$page['html'] = $this->load_view('install');
		
		return $page;
	}
	
	public function action_edit() {
		$this->redirect(SITE_URL . '/admin/theme_manager/theme/' . $this->config['site_theme'] . '/file=index.tpl');
	}
	
}