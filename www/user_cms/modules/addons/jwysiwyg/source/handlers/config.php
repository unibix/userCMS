<?php
/**
 * PHP handler for jWYSIWYG file uploader.
 *
 * By Alec Gorge <alecgorge@gmail.com>
 */
define('ROOT_DIR', realpath('../../../../../../'));
require_once(ROOT_DIR . '/user_cms/helpers/helper_image.php');

// an array of file extensions to accept
$accepted_extensions = array(
	"png", "jpg", "gif"
);

// http://your-web-site.domain/base/url
$base_url = '/uploads';

// the root path of the upload directory on the server
$uploads_dir = realpath(ROOT_DIR . '/uploads');

// the root path that the files are available from the webserver
// YOU WILL NEED TO CHANGE THIS
$uploads_access_dir = ROOT_DIR . '/uploads';

if (DEBUG) {
	if (!file_exists($uploads_access_dir)) {
		$error = 'Folder "' . $uploads_access_dir . '" doesn\'t exists.';

		header('Content-type: text/html; charset=UTF-8');
		print('{"error":"config.php: ' . htmlentities($error) . '","success":false}');
		exit();
	}
}

$capabilities = array(
	"move" => true,
	"rename" => true,
	"remove" => true,
	"mkdir" => true,
	"upload" => true
);

/********************************************
	Functions
*********************************************/

function translit($str){
	$str = mb_strtr($str, array(
		"а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"e",
		"ж"=>"zh","з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l","м"=>"m",
		"н"=>"n","о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t","у"=>"u",
		"ф"=>"f","х"=>"h","ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"shch","ъ"=>"",
		"ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya","ї"=>"i", "є"=>"ie",
		"А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D","Е"=>"E","Ё"=>"E",
		"Ж"=>"ZH","З"=>"Z","И"=>"I","Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M",
		"Н"=>"N","О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T","У"=>"U",
		"Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH","Ш"=>"SH","Щ"=>"SHCH","Ъ"=>"",
		"Ы"=>"Y","Ь"=>"","Э"=>"E","Ю"=>"YU","Я"=>"YA","Ї"=>"I", "Є"=>"IE",
							)
				);			
	 return $str;
}

function mb_strtr($str, $from, $to = '') {
	if(is_array($from)) {
		$new_from = array_keys($from);
		return str_replace($new_from, $from, $str);
		
	} else {
		$from = preg_split('~~u', $from, null, PREG_SPLIT_NO_EMPTY);
		$to = preg_split('~~u', $to, null, PREG_SPLIT_NO_EMPTY);
		return str_replace($from, $to, $str);
	}
}

function img_resize($image_name_old, $image_name_new, $width = 0, $height = 0) {

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
		$background = imagecolorallocatealpha($img, 255, 255, 255, 127);
		imagecolortransparent($img, $background);
	} else {
		$background = imagecolorallocate($img, 255, 255, 255);
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
		imagejpeg($img, $image_name_new, 100);
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