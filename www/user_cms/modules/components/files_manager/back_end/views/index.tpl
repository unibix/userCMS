<div id="content">
	<h1><?php echo $page_name ; ?></h1>
	<?php if(isset($success)) { ?>
	<div class="notice success">
		<?php echo $success; ?>
	</div>
	<?php } ?>
	<?php if(isset($errors)) { ?>
	<div class="notice error">
	<?php foreach($errors as $error) { ?>
		<?php echo $error; ?><br>
	<?php } ?>
	</div>
	<?php } ?>
	<form method="post" action="" ectype="multipart/form-data">
		<label for="s_name">Выберите файл (максимальный размер: <b><?php echo $upload_max_filesize; ?></b> мб):</label><br>
		<input type="file" name="file" >

		<input type="submit" value="Загрузить" name="upload_file">
	<form>

	<table class="main">
		<tbody><tr>
			<th>Файл и папка</th><th>Размер</th><th>Действия</th>
		</tr>
		<?php foreach ($files as $file) {
		?>
		<tr>
			<td><a href="<?php echo SITE_URL . '/admin/files_manager/dir='.$file; ?>"><?php echo $file; ?></td>
			<td>13 Кб</td>
			<td class="actions">
				<a href="#">Изменить</a>
				<a href="#">Удалить</a>
				<a href="#">Скачать</a>
			</td>
		</tr>
		<?php 
		}
		?>
	</table>

</div>