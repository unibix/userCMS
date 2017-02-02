<?php

// installator v 1.3

/*
	порядок
    0. если нет файла config.ini то выходим
	1. проверка всех требований ( php5, mod_rewrite, SimpleXML, sqlite, pdo sqlite, zip)
	2. проверка на запись папок themes, modules, .htaccess, config.ini, install.php
	3. выдаем форму для заполнения (название сайта, url сайта, логин, пароль админа), подставляем из админки, если там настройки не по умолчанию
	4. меняем конфиг сайта, логин и пароль админа, htaccess (rewrite base)
	5. переносим install.php в user_cms/install.php_
    6. переадресация на сайт


*/

error_reporting(E_ALL);

if( ! file_exists('config.ini')) {
    exit('config.ini not found');
}


	$errors  = array( );
$php_modules = get_loaded_extensions();

if (PHP_VERSION_ID < 50200) { 
            $errors[] = 'Версия php менее 5.2.0';
}

$need_modules = array('SimpleXML', 'sqlite3', 'PDO', 'curl', 'pdo_sqlite', 'zip' ,'gd' ,'mbstring'  );
foreach ($need_modules as $value) {
	if (!in_array( $value, $php_modules)) {
	    $errors[] = 'Не установлено расширение php ' . $value . ' <a href="http://usercms.ru/documentation/admininstrator/nastroyka-servera-pered-ustanovkoy" target="_blank">Статья в документации</a>, <a href="http://usercms.ru/forum">топик на форуме</a>';
	} 
}


if (function_exists('apache_get_modules')) {
            if ( ! in_array('mod_rewrite', apache_get_modules())) {
                $errors[] = 'Не установлен модуль Apache mod_rewrite';
            } 
        } 

$need_writable_files = array('install.php','.htaccess','config.ini');
foreach ($need_writable_files as $value) {
	if ( ! is_writable($value)){
        $errors[] = 'Файл ' . $value . ' не доступен для записи';
       }
}


$need_writable_directories = array('uploads', 'modules', 'themes', 'temp' );
foreach ($need_writable_directories as $dir) {
	if (!is_writable($dir.'/')) {
		$errors[] = 'Папка ' . $dir . ' не доступна для записи';
	}
}

if (get_magic_quotes_gpc() || get_magic_quotes_runtime()) {
	$errors[] = 'Директива magic_quotes должна быть отключена';
}

if (!file_exists('db.sqlite') && !file_exists('install.sql')) {
    $errors[] = 'Невозможно создать базу данных. Отсутствует файл install.sql';
}

if(count($errors) == 0) {
    if (!file_exists('db.sqlite')) file_put_contents('db.sqlite', '');
    $dbh = new PDO('sqlite:db.sqlite');
    if (file_exists('install.sql')) {
        $dbh->exec(file_get_contents('install.sql'));
        unlink('install.sql');
    }

    $show_form = TRUE;
	$config = parse_ini_file('config.ini');
	
    if(isset($_POST['site_name'])) {
        $config['site_name'] = $_POST['site_name'];
        $config['site_url'] = 'http://' . rtrim($_POST['site_url'], '/')  ;;
        
        // Обновляем config.ini
        update_config($config);

        // Обновляем логин и пароль
        $dbh->exec("UPDATE users SET login = '" . $_POST['login'] . "', password = '" . md5($_POST['password']) . "' WHERE id = '1' ; ");

        $main_page = $dbh->query("SELECT * FROM main WHERE url='/'");
        $main_page = $main_page->fetch(PDO::FETCH_ASSOC);
        if ($main_page['title'] == "Главная страница") {
            $dbh->exec("UPDATE main SET title='".$config['site_name']."' WHERE url='/'");
        }
        		
		// Обновляем htaccess
        update_htaccess();
        
        //5. переносим install.php в user_cms/install.php_
        rename("install.php", "user_cms/install" . rand(100000,200000) . ".php_");
        //6. переадресация на сайт
        header('Location: ' . $config['site_url']);
    } 

    if($show_form) {
        // выводим форму для заполнения
        $config['site_name'] = $config['site_name'];
        $config['site_url'] =   check_url(rtrim($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], '/'));
		$config['login'] = (isset($_POST['login'])) ? $_POST['login'] : 'admin';
        $config['password'] = (isset($_POST['password'])) ? $_POST['password'] : 'admin';
        require('user_cms/themes/default_admin/install.tpl');
    }
    
} else {
	foreach($errors as $error) {
		echo $error . '<br>';
	}
}

function check_url($url){
	$root_exp = explode(DIRECTORY_SEPARATOR, ROOT_DIR);
	$site_exp = explode('/', $url);
	$i=0;
	$j=0;
	$str = '';
	while (($i<count($root_exp)) && ($j<count($site_exp))) {
		if ($site_exp[$j]==$root_exp[$i]) {
			$str .= $site_exp[$j] . '/'; 
			$j++;
		}
		$i++;
	}
	return rtrim($str, '/');
}

function update_config($array) {
    if ( file_exists('config.ini') ) {
        $fp = fopen('config.ini',"w");
        foreach ($array as $key => $value) {
            fwrite($fp, $key . "=\"" . $value . "\"\r\n");
        }
        
        fclose($fp);
    }
    else {
        exit('Error: 1'); 
    }
}



function update_htaccess() {
    // нужно ли раскомментить RewriteBase
    if(rtrim($_POST['site_url'], '/') != $_SERVER['HTTP_HOST'] ) {
        if ( file_exists('.htaccess') ) {
            $dir = str_replace($_SERVER['HTTP_HOST'], '', rtrim($_POST['site_url'], '/'));
            //echo $dir;
            $t = file_get_contents('.htaccess');
            $t = str_replace('# RewriteBase /test', 'RewriteBase ' . $dir .'/', $t, $count);
            $fp = fopen('.htaccess',"w");
            fwrite($fp, $t);
            fclose($fp);
            if($count==0) {
                exit('Не найдена запись RewriteBase в файле .htaccess. Отройте его самостоятельно и вставьте после RewriteEngine On строку "#RewriteBase /dir/", а другие RewriteBase удалите и повторите установку.');
            }
            else {
                //chmod('.htaccess', 0400);
            }
        }
        else {
            exit('Error: 2'); 
        }
    }
    else {
        // не нужно
    }
    
}