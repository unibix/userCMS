<?php
class controller_block_core_cube_slider extends block {
	
	public function action_index($module_info) {
		$this->data['settings'] = unserialize($module_info['params']);

		if (!defined('CUBE_SLIDER')) {
			$this->page['head'] .= $this->add_css_file('/user_cms/modules/blocks/cube_slider/source/cube-slider.css');
			$this->page['head'] .= $this->add_js_file('/user_cms/modules/blocks/cube_slider/source/cube-slider.js');
			define('CUBE_SLIDER', true);
		}
		$this->page['html'] = $this->load_view();
		return $this->page;
	}

	protected function settings($submit_name, $settings) {
		$errors = Array();

		if (isset($_POST[$submit_name])) {

			$settings['aspect_ratio'] = floatval(str_replace(',', '.', $_POST['aspect_ratio']));
			$settings['speed'] = intval($_POST['speed']);
			$settings['frequency'] = intval($_POST['frequency']);
            $settings['has_shadow'] = isset($_POST['has_shadow']);

			if ($settings['aspect_ratio'] <= 0) $errors[] = 'Отношение сторон должно быть больше нуля';
			if ($settings['speed'] <= 0) $errors[] = 'Длительность анимации должна быть больше нуля';
			if ($settings['frequency'] <= 0) $errors[] = 'Период смены слайдов должен быть больше нуля';
			if ($settings['frequency'] <= $settings['speed']) $errors[] = 'Период смены слайдов должен быть больше длительности анимации';

			$max_key = 0;
			if(!is_dir(ROOT_DIR . '/uploads/modules/cube_slider'))mkdir(ROOT_DIR . '/uploads/modules/cube_slider', 0777, true);
			foreach ($_POST['images'] as $key => $image) {
				if (is_uploaded_file($_FILES['files']['tmp_name'][$key])) {
					$new_image = '/uploads/modules/cube_slider/'.time().'-'.rand().'.'.pathinfo($_FILES['files']['name'][$key], PATHINFO_EXTENSION);
					if (move_uploaded_file($_FILES['files']['tmp_name'][$key], ROOT_DIR.$new_image)) {
						if ($image != '' && file_exists(ROOT_DIR.$image)) unlink(ROOT_DIR.$image);
						$settings['slides'][$key]['image'] = $new_image;
					} else {
						$errors[] = 'Ошибка загрузки: '.$_FILES['files'][$key]['name'];
					}
				} else {
					$settings['slides'][$key]['image'] = $image;
				}

				$settings['slides'][$key]['text'] = $_POST['texts'][$key];
				$settings['slides'][$key]['btn_text'] = $_POST['btn_texts'][$key];
				$settings['slides'][$key]['href'] = $_POST['hrefs'][$key];
				$max_key = $key;
			}

			$l = count($settings['slides']);
			for ($i = $max_key+1; $i < $l; $i++) {
				$image = $settings['slides'][$i]['image'];
				if ($image != '' && file_exists(ROOT_DIR.$image)) unlink(ROOT_DIR.$image);
				unset($settings['slides'][$i]);
			}

			if (empty($errors)) {
				$this->page['params'] = serialize($settings);
			} else {
				unset($_POST[$submit_name]);
			}

		}

		$this->data['errors'] = $errors;
		$this->data['settings'] = $settings;
		$this->page['html'] = $this->load_view('settings');
		return $this->page;
	}

	public function action_activate() {
		return $this->settings('activate', Array(
			'aspect_ratio' => 2.9,
			'speed' => 1000,
			'frequency' => 3000,
            'has_shadow' => false,
			'slides' => Array()
		));
	}

	public function action_settings($module_info) {
		return $this->settings('edit_settings', unserialize($module_info['params']));
	}

}
?>