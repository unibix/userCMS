<?php

/**
*   Feedback 2.2
*   Все настройки через админку
*   Добавлены: Google reCAPTCHA, графическая капча движка UserCMS, автоматическое добавление e-mail адресов сайта в поле направление
*/
class controller_plugin_core_feedback extends plugin
{   
    private $errors = array();
    public $test = 'sasasasasa';
    
    private $field_types = array(
        'text'     	=> 'Текстовое поле (input[type="text"])',
        'textarea' 	=> 'Текстовое поле (textarea)',
        'select'   	=> 'Список',
        'file'     	=> 'Файл',
        'checkbox' 	=> 'Флажок',
        //'radio'    => 'Переключатель',
        'submit'    => 'Кнопка отправки формы',
        'captcha'   => 'Графическая капча',
        'recaptcha' => 'Google reCAPTCHA',
    );
    
    private $validation_methods = array(
        'not_empty' => 'Не пустое',
        'email' => 'Корректный email',
        'phone' => 'Корректный номер телефона'
    );

    public function action_index($plugin) {
    	if(isset($_POST['feedback_' . $plugin['id'] . '_submit']) AND ($_POST['phone_label'] != '' or $_POST['email_label'] != 'check@gmail.com') ) {
    		// защита от ботов (скрытая капча)
    		die('Error #3092: validating error feedback plugin');
    	}
        if ($plugin['id'] != $this->run_params) {
            return $this->page;
        }
        
        $params = unserialize(base64_decode($plugin['params']));
        $this->plugin_id = $this->data['plugin_id'] = $plugin['id'];
        
        if (isset($_SESSION['feedback_success_' . $this->plugin_id])) {
            $this->data['success'] = $_SESSION['feedback_success_' . $this->plugin_id];
            unset($_SESSION['feedback_success_' . $this->plugin_id]);
        } else {
            $this->data['success'] = false;
        }
 // out($params);       
        if ($params['fields']) {
            if (isset($_POST['feedback_' . $plugin['id'] . '_submit']) && $this->validate($params['fields'])) {
                $message = '';
                
                foreach ($params['fields'] as $i => $field) {
                    if ($field['type'] == 'submit') {
                        continue;
                    } else {
                        $key = 'feedback_' . $plugin['id'] . '_' . $i;
                    }
                    
                    $message .= '<b>' . $field['label'] . ':</b>';
                    
                    if ($field['type'] == 'checkbox') {
                        if (isset($_POST[$key])) {
                            $message .= $field['text_selected'];
                        } else {
                            $message .= $field['text_not_selected'];
                        }
                    } elseif ($field['type'] == 'file') {
                        if (!empty($_FILES[$key]['tmp_name'])) {
                            $attach = ROOT_DIR.'/temp/'.$_FILES[$key]['name'];
                            move_uploaded_file($_FILES[$key]['tmp_name'], $attach);
                            $message .= 'файл '.$_FILES[$key]['name'].' во вложении.';
                        }
                    } elseif (isset($_POST[$key])) {
                        $message .= $this->helper_validate->safestr($_POST[$key], true);
                    } 
                
                    $message .= '<br>';
                    
                }
                $message .= 'Форма заполнена на странице: '. SITE_URL  . $this->url['request_uri'] .'<br>';
                

                $this->load_helper('mail');
                
                $this->helper_mail->from_name = $params['mail_text_from'];
                $this->helper_mail->from_email = $params['mail_from'];
                $this->helper_mail->mail_target = $params['mail_to'];
                $this->helper_mail->subject = $params['mail_subject'];
                if (isset($attach)) $this->helper_mail->add_attach($attach);

                $this->before_send();
                $is_sent = $this->helper_mail->send($message);
                $this->after_send();
                if (isset($attach)) unlink($attach);
                if ($is_sent) {
                    $_SESSION['feedback_success_' . $this->plugin_id] = $params['mail_text_success'];
                    $this->redirect(SITE_URL  . $this->url['request_uri']);
                }
            }
        
            $this->data['fields'] = array();

            if(file_exists(ROOT_DIR . '/modules/helpers/captcha.php')) {
                $this->data['helper_path'] = '/modules/helpers/';
            } else {
                $this->data['helper_path'] = '/user_cms/modules/helpers/';
            }
            
            foreach ($params['fields'] as $i => $field) {
                if ($field['type'] == 'submit') {
                    $key = 'feedback_' . $plugin['id'] . '_submit';
                } else {
                    $key = 'feedback_' . $plugin['id'] . '_' . $i;
                }
                
                if (isset($_POST[$key])) {
                    $value = strip_tags($_POST[$key]);
                } elseif ($_SERVER['REQUEST_METHOD'] != 'POST' && $field['type'] == 'checkbox' && $field['default_checked']) {
                    $value = 1;
                } else {
                    $value = '';
                }
                
                if ($field['type'] == 'select' && !empty($field['option_list'])) {
                    $option_list = array_map('trim', explode("\n", $field['option_list']));
                } else {
                    $option_list = array();
                }
                
                if (isset($this->errors[$i])) {
                    $error = $this->errors[$i];
                } else {
                    $error = false;
                }
                
                if (isset($field['required']) && $field['required']) {
                    $required = true;
                } else {
                    $required = false;
                }
                if ($field['type'] == 'recaptcha'){
                    $option_list = array('key'=> $field['key']);	
                }
                if ($field['type'] == 'captcha'){
                    $option_list = array(
                        'captcha_width'     => $field['captcha_width'],
                        'captcha_height'    => $field['captcha_height']

                    );    
                }
                
                $this->data['fields'][$i] = array(
                    'type'        => $field['type'],
                    'label'       => $field['label'],
                    'name'        => $key,
                    'value'       => $value,
                    'required'    => (isset($field['required']) && $field['required']),
                    'error'       => $error,
                    'option_list' => $option_list
                );
            }
            
            if ( ! defined ('IS_FEEDBACK_CSS_FILE'))  {
                $this->page['head'] = $this->add_css_file(
                    SITE_URL . '/user_cms/modules/plugins/' . $this->plugin_name . '/views/style.css');
                define("IS_FEEDBACK_CSS_FILE", 1);
            }       
            $this->page['html'] = $this->load_view();
        }
        
        return $this->page;
    }
    
    public function action_activate() {
        if (isset($_POST['activate'])) {
            $this->page['params'] = base64_encode(serialize(array(
                'fields'            => isset($_POST['fields']) ? $_POST['fields'] : array(),
                'mail_to'           => $_POST['mail_to'],
                'mail_subject'      => $_POST['mail_subject'],
                'mail_from'         => $_POST['mail_from'],
                'mail_text_from'    => $_POST['mail_text_from'],
                'mail_text_success' => $_POST['mail_text_success']
            )));
            
            return $this->page;
        }
        
        $this->data['mail_to'] = '';
        $this->data['mail_subject'] = '';
        $this->data['mail_from'] = '';
        $this->data['mail_text_from'] = '';
        $this->data['mail_text_success'] = '';
        
        $this->data['field_types'] = $this->field_types;
        $this->data['validation_methods'] = $this->validation_methods;
        $this->data['fields'] = array();
        
        $this->page['html'] = $this->load_view('settings');
        return $this->page;
    }
    
    public function action_deactivate() {
        
    }
    
    public function action_settings($plugin) {
        $params = unserialize(base64_decode($plugin['params']));
        //out($params);
        $this->data['plugin_id'] = $plugin['id'];
        if (isset($_POST['edit_settings'])) {
            $this->page['plugin_id'] = $plugin['id'];
            $this->page['params'] = base64_encode(serialize(array(
                'fields'            => isset($_POST['fields']) ? $_POST['fields'] : array(),
                'mail_to'           => $_POST['mail_to'],
                'mail_subject'      => $_POST['mail_subject'],
                'mail_from'         => $_POST['mail_from'],
                'mail_text_from'    => $_POST['mail_text_from'],
                'mail_text_success' => $_POST['mail_text_success'],
            )));
            
           
        }
        
        $this->data['mail_to'] = $params['mail_to'];
        $this->data['mail_subject'] = $params['mail_subject'];
        $this->data['mail_from'] = $params['mail_from'];
        $this->data['mail_text_from'] = $params['mail_text_from'];
        $this->data['mail_text_success'] = $params['mail_text_success'];
        
        $this->data['field_types'] = $this->field_types;
        $this->data['validation_methods'] = $this->validation_methods;
        $this->data['fields'] = $params['fields'];
        
        $this->page['html'] = $this->load_view('settings');
        
        return $this->page;
    }
    
    private function validate($fields) {
        $this->load_helper('validate');
        foreach ($fields as $i => $field) {
            if (isset($field['required']) && $field['required']) {
                $error = false;
                
                if ($field['type'] == 'submit') {
                    $key = 'feedback_' . $this->plugin_id . '_submit';
                } else {
                    $key = 'feedback_' . $this->plugin_id . '_' . $i;
                }
                
                if (empty($field['error_message'])) {
                    $field['error_message'] = 'Не заполнено поле "' . $field['label'] . '"';
                }
            
                if ($field['type'] != 'file' && !isset($_POST[$key]) && $field['type'] != 'recaptcha' && $field['type'] != 'captcha') {
                    $this->errors[$i] = $field['error_message'];
                    continue;
                }

                if (!isset($field['validation']) || $field['validation'] == 'not_empty') {
                    if ($field['type'] == 'file'){
                    	$error = empty($_FILES[$key]['tmp_name']);
                    }else{
                    	$error = empty($_POST[$key]);
  					}

                    
                } elseif ($field['validation'] == 'email') {
                    $error = !$this->helper_validate->email($_POST[$key]);
                } elseif ($field['validation'] == 'phone') {
                    $error = !$this->helper_validate->phone($_POST[$key]);
                }

                if($field['type'] == 'recaptcha'){
                	$cpatcha 	= $_POST['g-recaptcha-response'];
                	$secret_key = $field['secret_key'];
                	$response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $cpatcha . '&remoteip=' . $_SERVER['REMOTE_ADDR']);
                	$response = json_decode($response, true);
                	if(empty($response['success']))$error = $field['error_message'];
            	}
                if($field['type'] == 'captcha'){
                    $captcha_result = isset($_SESSION['captcha' . $this->data['plugin_id']])?$_SESSION['captcha' . $this->data['plugin_id']]:false;
                    if(!$captcha_result || $captcha_result != $_POST['captcha'])$error = $field['error_message'];
                }

                if ($error) {
                    $this->errors[$i] = $field['error_message'];
                }
            }
        }   
        if ($this->errors) {
            return false;
        } else {
            return true;
        }

    }

    public function before_send() {

    }
    public function after_send() {
    }

}
