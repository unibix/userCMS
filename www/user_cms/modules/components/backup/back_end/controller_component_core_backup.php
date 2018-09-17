<?php 

class controller_component_core_backup extends component
{
    public function action_index()
    {
        $this->data['backups'] = array();
        $backups = $this->model->get_backups_list();
        
        foreach ($backups as $backup) {
            $this->data['backups'][] = array(
                'name'          => $backup,
                'href_download' => SITE_URL.'/temp/backups/'.$backup,
                'href_delete'   => SITE_URL.'/admin/backup/delete/del='.$backup,
                'href_restore'  => SITE_URL.'/admin/backup/restore/res='.$backup,
                'date'          => date('d.m.Y H:i', filemtime(ROOT_DIR.'/temp/backups/'.$backup)),
                'size'          => round(filesize(ROOT_DIR.'/temp/backups/'.$backup) / 0x100000)
            );
        }
        
        $this->data['restore_backup'] = SITE_URL.'/admin/backup/restore';
        $this->data['create_backup'] = SITE_URL.'/admin/backup/create_backup';
        $this->data['breadcrumbs'] = $this->helper_breadcrumbs->render();
        
        $this->page['title'] = 'Резервное копирование';
        $this->page['keywords'] = 'Резервное копирование';
        $this->page['description'] = 'Резервное копирование';
        $this->page['html'] = $this->load_view();

        return $this->page;
    }




    public function action_delete()
    {
        if (isset($this->url['params']['del'])) {
            $backup_file = ROOT_DIR.'/temp/backups/'.$this->url['params']['del'];
            if (file_exists($backup_file) && is_writable($backup_file)) unlink($backup_file);
        }
        $this->redirect(SITE_URL.'/admin/backup');
    }
    



    public function action_restore()
    {
        $this->data['errors'] = array();
        $this->data['success'] = array();
        $archive_types = array(
            'application/force-download',
            'application/x-zip-compressed',
            'application/zip',
            'application/x-zip',
            'multipart/x-zip',
            'application/octet-stream'
        );
        
        $file = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && is_uploaded_file($_FILES['backup']['tmp_name'])) {
            if(!in_array($_FILES['backup']['type'], $archive_types)) {
                $this->data['errors'][] = 'Выбранный файл не является архивом ZIP';
            } elseif (move_uploaded_file($_FILES['backup']['tmp_name'], ROOT_DIR.'/temp/backups/'.$_FILES['backup']['name'])) {
                $file = ROOT_DIR.'/temp/backups/'.$_FILES['backup']['name'];
            } else {
                $this->data['errors'][] = 'Не удалось переместить файл. Проверьте доступна ли для записи папка /temp/backups';
            }
        } elseif (isset($this->url['params']['res'])) {
            $file = ROOT_DIR.'/temp/backups/'.$this->url['params']['res'];
        } else {
            $this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs('Восстановление', '');
            $this->page['html'] = $this->load_view('restore_form');
            return $this->page;
        }
        
        if ($file) {
            $zip = new ZipArchive;
            if ($zip->open($file) === TRUE) {
                $zip->extractTo(ROOT_DIR.'/');
                $zip->close();
                $this->data['success'][] = 'Резервная копия восстановлена';
            } else {
                $this->data['errors'][] = 'Не удалось распаковать архив';
            }
        }

        return $this->action_index();
    }
    



    public function action_create_backup()
    {
        $this->data['get_process_status_url'] = str_replace(ROOT_DIR, SITE_URL, __DIR__.'/process.json');
        $this->data['do_backup_url'] = SITE_URL.'/admin/backup/ajax_do_backup_process';
        $this->page['title'] = $this->data['page_name'] = 'Резервное копирование';
        $this->data['breadcrumbs'] = $this->helper_breadcrumbs->make_breadcrumbs('Создание резервной копии', '');
        $this->page['keywords'] = 'Резервное копирование';
        $this->page['description'] = 'Резервное копирование';
        $this->page['html'] = $this->load_view('backup_form');
        return $this->page;
    }



    public function action_ajax_do_backup_process()
    {
        $this->model->do_backup_process();
    }
}