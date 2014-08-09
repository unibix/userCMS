<div id="content">
	<h1 id="page_name"><?php echo $page_name; ?></h1>
	<?php 
	if($errors) { ?>
	<div class="error">
		<?php foreach($errors as $error) { 
		 echo $error . '<br>';
		 } ?>
	</div>
	<?php 
	}
	if(isset($message)) { ?>
	<div class="success">
		<?php echo $message; ?>
	</div>
	<?php 
	} ?>
	<p class="buttons">
		<a href="<?php echo SITE_URL;?>/admin/modules_manager/manual_install" class="button">Ручная установка</a> 
	</p>
	<form method="post" action="" enctype="multipart/form-data" >
		<label for="page_name">Выберите архив (.zip) для установки</label>
		<input type="file"  name="file" >
		<input type="submit" name="install" value="Установить"> 
	</form>
</div>
