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
  
  <!--p class="buttons">
    <a class="button" href="<?php echo SITE_URL; ?>/admin/gallery/add"></a>
  </p-->
	<form method="post" action="" enctype="multipart/form-data">
		<?php if ($stamp) { ?>
			<img src="/uploads/modules/gallery/stamp/stamp.png" alt="Водяной знак"/><br>
		<?php } ?>
		<label>Выберите изображение:</label><br>
		<input type="file"  name="image" /><br>
		<input type="submit" name="submit" value="<?php echo $text_submit;?>" />
	</form>
 </div>
