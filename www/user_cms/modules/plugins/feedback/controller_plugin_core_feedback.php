<?php

/**
*	Feedback 2.0
*	Если атрибут name не задан через админку, то для большинства элементов формы этот атрибут формируется по шаблону:
*	  name="plugin_[id]_[field_index]", где 
*		[id] - id активированного плагина,
*		[field_index] - индекс элемента формы в массиве fields
*/
class controller_plugin_core_feedback extends plugin
{	
	private $errors = array();
	
	private $field_types = array(
		'text'     => 'Текстовое поле (input[type="text"])',
		'textarea' => 'Текстовое поле (textarea)',
		'select'   => 'Список',
		// 'file'     => 'Файл',
		'checkbox' => 'Флажок',
		//'radio'    => 'Переключатель',
		'submit'   => 'Кнопка отправки формы'
	);
	
	private $validation_methods = array(
		'not_empty' => 'Не пустое',
		'email' => 'Корректный email',
		'phone' => 'Корректный номер телефона'
	);

	public function action_index($plugin) {
		if ($plugin['id'] != $this->run_params) {
			return $this->page;
		}
		
		$params = unserialize($plugin['params']);
		
		$this->plugin_id = $plugin['id'];
		
		if (isset($_SESSION['feedback_success_' . $this->plugin_id])) {
			$this->data['success'] = $_SESSION['feedback_success_' . $this->plugin_id];
			unset($_SESSION['feedback_success_' . $this->plugin_id]);
		} else {
			$this->data['success'] = false;
		}
		
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
					} elseif (isset($_POST[$key])) {
						$message .= $this->helper_validate->safestr($_POST[$key], true);
					}
				
					$message .= '<br>';
				}
				
				$this->load_helper('mail');
				
				$this->helper_mail->from_name = $params['mail_text_from'];
				$this->helper_mail->from_email = $params['mail_from'];
				$this->helper_mail->mail_target = $params['mail_to'];
				$this->helper_mail->subject = $params['mail_subject'];
				
				if ($this->helper_mail->send($message)) {
					$_SESSION['feedback_success_' . $this->plugin_id] = $params['mail_text_success'];
					$this->redirect(SITE_URL . '/' . $this->url['request_uri']);
				}
			}
		
			$this->data['fields'] = array();
			
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
				
				if (isset($field['validation'])) {
					
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
			
			$this->data['plugin_id'] = $plugin['id'];
			$this->page['head'] = $this->add_css_file(SITE_URL . '/user_cms/modules/plugins/' . $this->plugin_name . '/views/style.css');
			$this->page['html'] = $this->load_view();
		}
		
		return $this->page;
	}
	
	public function action_activate() {
		if (isset($_POST['activate'])) {
			$this->page['params'] = serialize(array(
				'fields'            => isset($_POST['fields']) ? $_POST['fields'] : array(),
				'mail_to'           => $_POST['mail_to'],
				'mail_subject'      => $_POST['mail_subject'],
				'mail_from'         => $_POST['mail_from'],
				'mail_text_from'    => $_POST['mail_text_from'],
				'mail_text_success' => $_POST['mail_text_success']
			));
			
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
		$params = unserialize($plugin['params']);
		
		if (isset($_POST['edit_settings'])) {
			$this->page['params'] = serialize(array(
				'fields'            => isset($_POST['fields']) ? $_POST['fields'] : array(),
				'mail_to'           => $_POST['mail_to'],
				'mail_subject'      => $_POST['mail_subject'],
				'mail_from'         => $_POST['mail_from'],
				'mail_text_from'    => $_POST['mail_text_from'],
				'mail_text_success' => $_POST['mail_text_success'],
			));
			
			return $this->page;
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
			
				if (!isset($_POST[$key])) {
					$this->errors[$i] = $field['error_message'];
					continue;
				}
				
				if ($field['validation'] == 'not_empty') {
					$error = empty($_POST[$key]);
				} elseif ($field['validation'] == 'email') {
					$error = !$this->helper_validate->email($_POST[$key]);
				} elseif ($field['validation'] == 'phone') {
					$error = !$this->helper_validate->phone($_POST[$key]);
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
}