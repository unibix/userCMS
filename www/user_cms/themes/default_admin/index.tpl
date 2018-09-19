<!DOCTYPE html>
<html>
<head>
   	<link href="<?=THEME_URL;?>_admin/bootstrap/bootstrap.min.css" rel="stylesheet"  type="text/css" >
    <link href="<?=THEME_URL;?>_admin/bootstrap/ie10-viewport-bug-workaround.css" rel="stylesheet"  type="text/css" >
	[head]
</head>
<body>
<div id="header-wrapper">
	<div id="header">
		<div id="logo">
			<h5><a href="<?php echo SITE_URL; ?>/admin">User<span>CMS</span></a></h5>
			<p><?php echo $this->config['site_name']; ?></p>
		</div>
    <div id="h_right">
      <a href="<?php echo SITE_URL ; ?>/admin/users" >Добро пожаловать, <?php echo $_SESSION['login']; ?></a>
      <a href="<?php echo SITE_URL ; ?>/admin/users/logout" >Выйти</a>
      <a href="<?php echo SITE_URL ; ?>" target="_blank">Перейти на сайт</a>
    </div>
</div>
</div>
<div id="menu-wrapper">
	<div id="menu">
    [position=main_menu]
	</div>
	<!-- end #menu --> 
</div>
<div id="wrapper">
  [position=left_menu]
	<!-- end #header -->
	<div id="middle">
	[component]

				
		<div class="clear">&nbsp;</div>
		
	</div>
	<!-- end #page --> 

<div id="footer">
	<p>
    <a href="<?php echo SITE_URL ; ?>/admin/update" >Обновить</a> /
    <a href="<?php echo SITE_URL ; ?>/admin/backup" >Бэкап</a> /
    <a href="http://usercms.ru/forum" target="_blank">Оф. форум</a> /
    <a href="http://usercms.ru/documentation" target="_blank">Оф. документация</a> /
    <a href="http://usercms.ru" target="_blank">User CMS <?php echo USER_CMS_VERSION; ?> Сборка <?php echo USER_CMS_EDITION; ?></a> © 2010-2013. 
  </p>
</div>
</div>
<!-- end #footer -->
<script>
function confirmDelete() {
		if (confirm("Вы уверены?")) {
			return true;
		} else {
			return false;
		}
}
$(".confirmButton").click(function(){
	return confirmDelete();
});
</script>
<script src="<?=THEME_URL?>_admin/bootstrap/bootstrap.min.js"></script>
<script src="<?=THEME_URL?>_admin/bootstrap/ie10-viewport-bug-workaround.js"></script>
</body>
</html>