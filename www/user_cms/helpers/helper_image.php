<?php 

class helper_image {

	public $temp_dir;
	public $background;
	public $quality;
	
	public function __construct() {
		$this->temp_dir = ROOT_DIR . '/temp/';
		
		$this->set_background();
		
		$this->quality = 100;
	}

	// v 3.0
	// переносит изображение в нужную папку, уменьшает, если требуется создает превьюшку
	// $input_name - name поля формы
	// $new_width - новая ширина
	// $new_width_thrumb - новая ширина превьюхи (0 - значит не надо)
	// $img_path - путь к изображению
	// $new_height - новая высота (обрезается если пропорционально должно быть больше)
	// $new_height_thrumb - новая высота превьюхи
	// возвращает имя изображения

	public function img_upload($input_name, $new_width, $img_path = '', $new_width_thrumb=0, $new_height_thrumb='auto', $new_height='auto') {
		$debug=true;
		$error = '';
		if(!$img_path || !is_dir($img_path)) {
			$img_path = $this->temp_dir;
		}
		// генерируем имя
		$img_name = $this->get_rand_name().'.jpg';
		// полный путь
		$img_name_full = $img_path . $img_name;
		// проверка формата изображения
		if (!isset($_FILES[$input_name]) ) {
			if($debug) {$error ='Изображение не загружено'; }
			else return '';
		}
		// проверка формата изображения
		if ($_FILES[$input_name]['type'] != "image/jpeg" AND $_FILES[$input_name]['type'] != "image/png" AND $_FILES[$input_name]['type'] != "image/gif" ) {
			if($debug) {$error .='Неправильный формат фотографий, только JPG, PNG, GIF<br>';  }
			else return false;
		}
		// проверка папки на существование
		if(!is_dir($img_path)) {
			if($debug) {$error .='Папки "'.$img_path.'" не существует.<br>';  }
			else return false;
			//mkdir($img_path);
		}
		if ( !move_uploaded_file($_FILES[$input_name]['tmp_name'], $img_name_full) ) {
			if($debug) { $error .='Не удалось переместить изображение в папку '.$img_path.' (проверьте права на запись)<br>';  }
			else return false;
		} else {
			// делаем превьюху
			if($new_width_thrumb!=0) {
				$thrumb_name_full = $img_path .'mini/'. $img_name;  // полный путь до превьюхи
				// проверка папки на существование, если нет, создаем
				if(!is_dir($img_path .'mini/')) {
					if(!mkdir($img_path .'mini/') ) {
						if($debug) { $error .='Не удалось создать папку для превью: "'.$img_path .'mini/<br>';  }
						else return false;
					}
				}

				// генерация
				if (!$this->resize($img_name_full, $thrumb_name_full, $new_width_thrumb, $new_height_thrumb) ) {
					if($debug) {$error .='Не удалось уменьшить до превью<br>';  }
					else return false;
				}
			}
		
			// уменьшаем
			if (!$this->resize($img_name_full, $img_name_full, $new_width, $new_height)) {
				if($debug) {$error .='Не удалось уменьшить до макси<br>'; }
				else return false;
			};

			return $img_name;
		}
		if(!empty($error)) {
			die ('<div class="notice error" style="font-size:30px;">'.$error.'</div>');
		}
	}
	
	public function get_rand_name($length=10,$rand_name=''){
		for ($k=1;$k<=$length;$k++) {
			if ( rand(0, 5)==3 ) {
				$rand_name .= chr(48+rand(0, 9));
			} else {
				$rand_name .= chr(65+rand(0, 25));
			}
		}
		return strtolower($rand_name);
	}
	
    public function resize($image_name_old, $image_name_new, $width = 0, $height = 0) {
		$info = getimagesize($image_name_old);
		
		$image_info = array(
			'width'  => $info[0],
			'height' => $info[1],
			'bits'   => $info['bits'],
			'mime'   => $info['mime']
		);
		
		if($height == 0 || !is_numeric($height)) {
			$height = ($width * $image_info['height'])/$image_info['width'];
		}
		
		$xpos = 0;
		$ypos = 0;

		$scale = min($width / $image_info['width'], $height / $image_info['height']);

		if ($scale == 1 && $image_info['mime'] != 'image/png') {
			copy($image_name_old, $image_name_new);
			return;
		}
		
		$new_width = (int)($image_info['width'] * $scale);
		$new_height = (int)($image_info['height'] * $scale);			
    	$xpos = (int)(($width - $new_width) / 2);
   		$ypos = (int)(($height - $new_height) / 2);
        
			
		if ($image_info['mime'] == 'image/gif') {
			$img = imagecreatefromgif($image_name_old);
		} elseif ($image_info['mime'] == 'image/png') {
			$img = imagecreatefrompng($image_name_old);
		} elseif ($image_info['mime'] == 'image/jpeg') {
			$img = imagecreatefromjpeg($image_name_old);
		}
						
       	$image_old = $img;

        $img = imagecreatetruecolor($width, $height);
			
		if (isset($image_info['mime']) && $image_info['mime'] == 'image/png') {		
			imagealphablending($img, false);
			imagesavealpha($img, true);
			$background = imagecolorallocatealpha($img, $this->background['r'], $this->background['g'], $this->background['b'], $this->background['a']);
			imagecolortransparent($img, $background);
		} else {
			$background = imagecolorallocate($img, $this->background['r'], $this->background['g'], $this->background['b']);
		}
		
		imagefilledrectangle($img, 0, 0, $width, $height, $background);
	
        imagecopyresampled($img, $image_old, $xpos, $ypos, 0, 0, $new_width, $new_height, $image_info['width'], $image_info['height']);
        imagedestroy($image_old);
           
        $image_info['width']  = $width;
        $image_info['height'] = $height;
		
		// save
		$info = pathinfo($image_name_new);
       
		$extension = strtolower($info['extension']);
   		
		$ret_val = false;
		
		if ($extension == 'jpeg' || $extension == 'jpg') {
			imagejpeg($img, $image_name_new, $this->quality);
			$ret_val = true;
		} elseif($extension == 'png') {
			imagepng($img, $image_name_new);
			$ret_val = true;
		} elseif($extension == 'gif') {
			imagegif($img, $image_name_new);
			$ret_val = true;
		}
		   
		imagedestroy($img);
		
		return $ret_val;
    }
	
	public function set_background($r = 255, $g = 255, $b = 255, $a = 127) {
		$this->background = array('r' => $r, 'g' => $g, 'b' => $b, 'a' => $a);
	}
}