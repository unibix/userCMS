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


    public function get_process_status()
    {
        return file_get_contents(__DIR__.'/console/output.txt');
    }


    public function start_process($backup_name, $is_full)
    {
        file_put_contents(__DIR__.'/console/output.txt', 'FINISHED');
        $script = str_replace(ROOT_DIR.'/', '', __DIR__.'/console/create_backup.php');
        $cmd  = 'cd '.ROOT_DIR.'; php '.$script.' --file="'.$backup_name.'"'.($is_full ? ' --full' : '').' 1> /dev/null 2> /dev/null &';
        exec($cmd);
        for ($i=0; $i<1000; $i++) {
            if ($this->get_process_status() != 'FINISHED') return true;
            usleep(3000);
        }
        return false;
    }
}