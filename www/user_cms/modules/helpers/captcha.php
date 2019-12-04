<?php 
session_start();
require_once('helper_captcha.php');

if (isset($_GET['suffix'])) {
	$suffix = $_GET['suffix'];
} else {
	$suffix = '';
}

$c = new helper_captcha();
$_SESSION['captcha' . $suffix] = $c->getCode();
$c->showImage();