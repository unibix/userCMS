<div id="content">
	<h1><?php echo $page_name ; ?></h1>
	<?php if($success) { ?>
	<div class="notice success">
		<?php echo $success; ?>
	</div>
	<?php } ?>
	<?php if($errors) { ?>
	<div class="notice error">
	<?php foreach($errors as $error) { ?>
		<?php echo $error; ?><br>
	<?php } ?>
	</div>
	<?php } ?>
	<form method="post" action="">
		<label for="s_name">Название сайта:</label><br>
		<input id="s_name" type="text" name="site_name" value="<?php echo $config['site_name']; ?>" >
		
		<label for="s_slogan">Слоган:</label><br>
		<input id="s_slogan" type="text" name="site_slogan" value="<?php echo $config['site_slogan']; ?>">
		
		<label for="s_url">Адрес сайта:</label><br>
		<input id="s_url" type="text" name="site_url" value="<?php echo $config['site_url']; ?>" >	
		
		<label for="s_theme">Тема сайта:</label><br>
		<select id="s_theme" name="site_theme">
			<?php foreach($themes as $theme) { 
				$attr = ($theme == $config['site_theme']) ? 'selected' : ''; ?>
			<option <?php echo $attr; ?> value="<?php echo $theme; ?>"><?php echo $theme; ?></option>
			<?php } ?>
		</select>
		
		<label for="e_reporting">Вывод ошибок:<a class="help" href="http://php.net/manual/ru/errorfunc.constants.php" target="_blank"></a></label><br>
		<input id="e_reporting" type="text" name="error_reporting" value="<?php echo $config['error_reporting']; ?>" >
		<label for="db_e_reporting">Вывод ошибок базы данных:</label>
		<input id="db_e_reporting" type="checkbox" name="db_error_reporting" value="1" <?php if((int)$config['db_error_reporting'] > 0) { ?> checked <?php } ?> ><br>
		
		<input type="submit" value="Сохранить изменения" name="edit_config">
	<form>
</div>