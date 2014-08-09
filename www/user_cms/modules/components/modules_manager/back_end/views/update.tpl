<div id="content">
	<h1 id="page_name"><?php echo $page_name; ?></h1>
	<?php 
	if(isset($errors)) { ?>
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

	<form method="post" action="" enctype="multipart/form-data" >
		<label for="page_name">Выберите архив (.zip) для обновления</label>
		<input type="file"  name="file" >
		<input type="submit" name="update" value="Обновить"> 
	</form>
</div>
