<?php 

class model_component_core_backup extends model
{
    public function get_backups_list()
    {
		if (is_dir(ROOT_DIR.'/temp/backups')) {
			$backup_dir = scandir(ROOT_DIR.'/temp/backups');
			return array_values(array_diff($backup_dir, array('.', '..')));			
		}
		return array();
	}



    public function do_backup_process()
    {
        ignore_user_abort(true); // не обрываем процесс, даже если пользователь ушел

        $time_to_die = time() + intval(ini_get('max_execution_time')/2);
        $temp_backup = ROOT_DIR.'/temp/not_finished_backup.zip';
        $list_file = ROOT_DIR.'/temp/list_file.txt';
        $process = $this->get_process_info();

        // если данных о процессе нет или
        // процесс завершился с ошибкой или
        // процесс якобы выполняется, но время выполнения уже кончилось
        if (
            empty($process) ||
            ($process['status'] == 'terminated' && isset($process['error'])) ||
            ($process['status'] == 'executing' && time() - $process['timestamp'] > ini_get('max_execution_time')*2)
        ) {
            if (file_exists($temp_backup)) unlink($temp_backup);
            if (file_exists($list_file)) unlink($list_file);
            $process = array('status' => 'terminated');
            $this->set_process_info($process);
        }

        // если процесс выполняется, выходим. Клоны процесса нам не нужно создавать.
        if ($process['status'] == 'executing') die;

        // ecли прошлый процесс был завершен, начинаем новый
        if ($process['status'] == 'terminated') {
            $process['type'] = isset($_GET['type']) ? $_GET['type'] : 'no-uploads'; 
            
            $except = array(ROOT_DIR.'/temp', ROOT_DIR.'/temp/backups');
            if ($process['type'] == 'no-uploads') $except[] = ROOT_DIR.'/uploads';

            $process['status'] = 'executing';
            $process['progress'] = 0.0;
            $process['action'] = 'Создание списка файлов...';
            $this->set_process_info($process);

            $list = $this->get_list(ROOT_DIR, $except);
            $list = array_merge($list, $except);
            file_put_contents($list_file, serialize($list));
            $process['status'] = 'paused';
            $process['listSize'] = count($list);
            $process['listPointer'] = 0;
            $this->set_process_info($process);
        }

        // если процесс в стадии паузы, продолжаем с нужного места
        if ($process['status'] == 'paused') {

            $process['status'] = 'executing';
            $process['action'] = 'Открытие архива...';
            $this->set_process_info($process);

            if (file_exists($list_file)) {
                if (!isset($list) || empty($list)) $list = unserialize(file_get_contents($list_file)); 
            } else {
                $process['status'] = 'terminated';
                $process['error'] = 'Список файлов для архивации поврежден или удален.';
                $this->set_process_info($process);
                die;
            } 

            if (!isset($process['listSize']) || !isset($process['listPointer'])) {
                $process['status'] = 'terminated';
                $process['error'] = 'Информация о процессе бэкапа повреждена.';
                $this->set_process_info($process);
                die;
            }
            
            $zip = new ZipArchive();
            if ($process['listPointer'] == 0) $is_opened = $zip->open($temp_backup, ZipArchive::CREATE);
            else $is_opened = $zip->open($temp_backup);

            if (!$is_opened) {
                $process['status'] = 'terminated';
                $process['error'] = 'Временный архив бэкапа поврежден или удален.';
                $this->set_process_info($process);
                die;
            }

            $process['action'] = 'Добавление файлов в архив...';
            $this->set_process_info($process);
            
            for ($i=$process['listPointer']; $i<$process['listSize']; $i++) {
                
                $name = $list[$i];
                $zipName = str_replace(ROOT_DIR, '', $name);
                if (is_dir($list[$i])) {
                    $is_added = $zip->addEmptyDir($zipName);
                } elseif (pathinfo($name, PATHINFO_EXTENSION) == 'php_') {
                    $is_added = $zip->addFile($name, 'install.php');
                } else {
                    $is_added = $zip->addFile($name, $zipName);
                }

                if (!$is_added) {
                    $process['status'] = 'terminated';
                    $process['error'] = 'Не удалось добавить файл '.$name.'. Проверьте доступ на чтение.';
                    $this->set_process_info($process);
                    die;
                } else {
                    $p = round(100*$i/$process['listSize'], 1);
                    if ($p > $process['progress']) {
                        $process['progress'] = $p;
                        $this->set_process_info($process);
                    }
                }

                if (time() >= $time_to_die) {
                    $process['action'] = 'Промежуточная архивация...';
                    $this->set_process_info($process);
                    $zip->close();
                    $process['status'] = 'paused';
                    $process['listPointer'] = $i + 1;
                    $this->set_process_info($process);
                    die;
                }

                /*
                разрядка нужна чтобы не забить архив так, что не успеем его сжать прежде чем
                кончится лимит времени (если файлов много), а также чтобы успеть отобразить
                данные о процессе (если файлов мало). Значение 10000 подобрано опытным путем.
                */
                usleep(10000);
            }

            unlink($list_file);

            $process['action'] = 'Финальная архивация...';
            $this->set_process_info($process);
            $zip->close();

            $backup_file = ROOT_DIR.'/temp/backups/'.$_SERVER['HTTP_HOST'].'-'.$process['type'].'-'.date('d-m-Y-H-i-s').'.zip';
            
            if (!rename($temp_backup, $backup_file)) {
                $process['status'] = 'terminated';
                $process['error'] = 'Не удалось скопировать полученный архив. Проверьте права доступа к папке /temp/backups';
                $this->set_process_info($process);
                die;
            }

            $process['status'] = 'terminated';
            $this->set_process_info($process);
        }

        die;
    }

    protected function set_process_info($process) {
        $process['timestamp'] = time();
        return file_put_contents(__DIR__.'/process.json', json_encode($process));
    }

    protected function get_process_info() {
        if (file_exists(__DIR__.'/process.json')) return json_decode(file_get_contents(__DIR__.'/process.json'), true);
        else return array();
    }

    protected function get_list($dir, $except=array()) {
        $files = scandir($dir);
        $list = array();
        foreach ($files as $f) {
            if ($f == '.' || $f == '..') continue;
            $f = $dir.'/'.$f;
            if (in_array($f, $except)) continue;
            $list[] = $f;
            if (is_dir($f)) $list = array_merge($list, $this->get_list($f, $except));
        }
        return $list;
    }
}