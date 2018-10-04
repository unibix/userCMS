<div id="content" class="users index index-not-logged">
  <h1><?php echo $page_name; ?></h1>
  <?=$breadcrumbs;?>

  <div class="row">
  	<div class="col-12">
  		Логин: <?=$user['login'];?>
  	</div>
  	<div class="col-12">
  		E-mail: <?=$user['email'];?>
  	</div>
  </div>

  <div class="row">
  	<div class="col-12" align="center">
  		<a href="<?=SITE_URL;?>/users/logout">Выйти</a>
  	</div>
  </div>
 
</div>