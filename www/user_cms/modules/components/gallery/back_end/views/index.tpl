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
  
  <p class="buttons">
    <a class="button" href="<?php echo SITE_URL; ?>/admin/gallery/add">Добавить категорию</a>
  </p>
  <?php if($categories) { ?>
  <table class="main">
    <tr>
      <th>Заголок</th>
      <th>Количество фото</th>
      <th>Действия</th>
    </tr>
    <?php foreach($categories as $category) { ?>
    <tr>
      <td><div style="margin-left:<?php echo $category['step']*10;?>px;"><?php echo $category['name']; ?></div></td>
      <td><?php echo $category['count_items']; ?></td>
      <td class="actions">
        <a href="<?php echo SITE_URL; ?>/admin/gallery/category/<?php echo $category['id']; ?>">Изображения</a>
        <a href="<?php echo SITE_URL; ?>/admin/gallery/edit/<?php echo $category['id']; ?>">Изменить</a>
        <a class="confirmButton" href="<?php echo SITE_URL; ?>/admin/gallery/delete/<?php echo $category['id']; ?>">Удалить</a>
      </td>
    </tr>
    <?php } ?>
  </table>
  <?php } ?>
</div>
