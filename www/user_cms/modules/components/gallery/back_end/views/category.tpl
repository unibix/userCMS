<div id="content">
	<h1 id="page_name"><?php echo $page_name; ?></h1>
	<?=$breadcrumbs;?>
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
  <form method="post">
  <div id="sortable">
  <?php foreach($items as $item) { ?>
    <div class="item">
      <img width="100" src="<?php echo $category['path'] . '/mini/' . $item['image']; ?>"><br>
      <a href="<?php echo SITE_URL . '/admin/gallery/delete_img/' . $item['id']; ?>">Удалить</a>
      <input type="hidden" class="sort" name="order_<?=$item['id']?>" value="<?=$item['id']?>">
    </div>
  <?php } ?>
  </div>
  <input type="submit" name="save_order" value="Сохранить сортировку">
  </form>
  <?php } ?>
</div>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
	$( "#sortable" ).sortable();
	$( "#sortable" ).disableSelection();
} );
 $( function() {
	   $("#sortable .item").on("mouseleave", function() {
		    // заносим в скрытые поля порядковые номера изображений

		    $('.sort').each(function(i,elem) {
		    	$(elem).val($("#sortable .item").index($(elem).parent()));
			});
		});
	    
  } );
</script>
<style>
	#sortable {display: flex;}
	#sortable .item{ text-align: center; margin: 5px 10px; padding: 5px; background: #FFFFFF; border-radius: 4px; box-shadow: 0 0 2px #999999;}
</style>

