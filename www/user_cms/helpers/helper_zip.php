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
}
