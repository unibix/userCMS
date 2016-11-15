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
		<label for="image_text">Описание:</label>
		<input type="text" name="text">
		<label for="page_name">Выберите файл загрузки или архив ZIP c изображениями внутри (максимальный размер файла: <b><?=$max_file_size?>МБ</b>)</label>
		<input type="file"  name="image">
		<input type="checkbox" name="stamp" /><label for="image_stamp">Применить водяной знак</label><br>
		<input type="submit" name="submit" value="Закачать">
	</form>
  <?php if($items) { ?>
  <div style="overflow: hidden;">
  <?php foreach($items as $item) { ?>
    <div style="float: left; text-align: center; margin: 5px; padding: 5px; background: #FFFFFF; border-radius: 4px; box-shadow: 0 0 2px #999999">
      <img width="100" src="<?php echo $category['path'] . '/mini/' . $item['image']; ?>"><br>
      <a href="<?php echo SITE_URL . '/admin/gallery/delete_img/' . $item['id']; ?>">Удалить</a>
    </div>
  <?php } ?>
  </div>
  <?php } ?>
</div>
