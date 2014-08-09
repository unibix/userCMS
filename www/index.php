<?php

/*	
	User CMS 2

*/
define('ROOT_DIR', dirname(__FILE__));

if(file_exists('install.php')) {
	require('install.php');
} else {
	
	// загружаем основное ядро системы, ядро сборки и ядро от пользователя.
	require(ROOT_DIR . '/user_cms/user_cms_core.php');
	require(ROOT_DIR . '/user_cms/user_cms_core_edition.php');
	require(ROOT_DIR . '/modules/core.php');

	$u = new core();
	
	$u -> load_addons('before');
	$u -> load_component();
	$u -> load_theme();
	$u -> load_blocks();
	$u -> load_plugins();
	$u -> load_addons('after');
	$u -> load_pre_echo();
	
	echo $u -> html;

	$u = NULL;

}