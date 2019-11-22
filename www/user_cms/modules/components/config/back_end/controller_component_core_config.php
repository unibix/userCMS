<?php 

class controller_component_core_config extends component {
	
	public function action_index() {
    
        if(isset($this->url['params']['success']) && $this->url['params']['success'] == 'edited') {
            $this->data['success'] = 'Настройки сайта обновлены';
        } else {
            $this->data['success'] = '';
        }
        $this->data['themes'] = $this->model->get_themes();
        //$config = $this->model->get_config();
        $this->data['errors'] = array();
        
        if(!$data = $this->model->get_config()) {
            $this->data['errors'][] = 'Не удалось загрузить файл с настройками';
        }
        
        if(isset($_POST['edit_config'])){
        
            if(isset($_POST['site_name']) && !empty($_POST['site_name'])) {
                $data['site_name'] = $_POST['site_name'];
            } else {
                $data['site_name'] = $_POST['site_name'];
            }
            
            if(isset($_POST['site_url']) && !empty($_POST['site_url'])) {
                $data['site_url'] = $_POST['site_url'];
            }
            
            if(isset($_POST['site_slogan']) && !empty($_POST['site_slogan'])) {
                $data['site_slogan'] = $_POST['site_slogan'];
            } else {
                $data['site_slogan'] = '';
            }

            if(isset($_POST['site_address']) && !empty($_POST['site_address'])) {
                $data['site_address'] = $_POST['site_address'];
            } else {
                $data['site_address'] = '';
            }

            if(isset($_POST['site_email']) && !empty($_POST['site_email'])) {
                $data['site_email'] = $_POST['site_email'];
            }

            if(isset($_POST['site_email2']) && !empty($_POST['site_email2'])) {
                $data['site_email2'] = $_POST['site_email2'];
            }

            if(isset($_POST['site_phone']) && !empty($_POST['site_phone'])) {
                $data['site_phone'] = $_POST['site_phone'];
                $data['site_phone_f'] = preg_replace('/[^0-9\+]/', '', $_POST['site_phone']);
            }
           
            if(isset($_POST['site_theme']) && !empty($_POST['site_theme'])) {
                $data['site_theme'] = $_POST['site_theme'];
            } else {
                $data['site_theme'] = 'default';
            }
            
            if(isset($_POST['error_reporting']) && !empty($_POST['error_reporting'])) {
                $data['error_reporting'] = $_POST['error_reporting'];
            } else {
                $data['error_reporting'] = '0';
            }
            
            if(isset($_POST['db_error_reporting']) && !empty($_POST['db_error_reporting'])) {
                $data['db_error_reporting'] = $_POST['db_error_reporting'];
            } else {
                $data['db_error_reporting'] = '0';
            }
            if(isset($_POST['maintenance']) && !empty($_POST['maintenance'])) {
                $data['maintenance'] = $_POST['maintenance'];
            } else {
                $data['maintenance'] = '0';
            }
            
            if(!$this->data['errors']) {
                if($this->model->update_config($data)) {
                    $this->redirect(SITE_URL . '/admin/config/success=edited');
                }
            }
        }
        
        if (!isset($data['site_url'])) {
            $data['site_url'] = '';
        }
        
        $this->data['config'] = $data;
        
        $this->data['bread_crumbs'] = 'Вы на главной странице.';
        $this->data['page_name'] = 'Настройки';

        $page['title'] = 'Настройки';
        $page['keywords'] = 'другие ключи';
        $page['description'] = 'другое описание';
        $page['html'] = $this->load_view();

        return $page;
    }
}