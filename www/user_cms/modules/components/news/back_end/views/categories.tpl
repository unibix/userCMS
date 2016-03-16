<div id="content">
	<h1 id="page_name"><?=$page_name;?></h1>
	<?php if($success) { ?>
	<div class="notice success">
		<?php foreach($success as $msg) { ?>
		<p><?php echo $msg; ?></p>
		<?php } ?>
	</div>
	<?php } ?>
	<?php if($errors) { ?>
	<div class="notice error">
	<?php foreach($errors as $error) { ?>
		<p><?php echo $error; ?></p>
	<?php } ?>
	</div>
	<?php } ?>
	<p class="buttons">
    <a class="button" href="<?php echo SITE_URL; ?>/admin/news/add_category">Добавить категорию</a>
  </p>
  <?php if($categories) { ?>
  <table class="main">
    <tr>
      <th>Заголок</th>
      <th>Количество <br/> новостей</th>
      <th>Действия</th>
    </tr>
    <?php foreach($categories as $category) { ?>
    <tr>
      <td><?php echo $category['name']; ?></td>
      <td><?php echo $category['count_news']; ?></td>
      <td class="actions">
        <a href="<?php echo SITE_URL; ?>/admin/news/add/category_id=<?php echo $category['id']; ?>">Добавить новость</a>
        <a href="<?php echo SITE_URL; ?>/admin/news/category_id=<?php echo $category['id']; ?>">Обзор новостей</a> |
        <a href="<?php echo SITE_URL; ?>/admin/news/edit_category/<?php echo $category['id']; ?>">Изменить</a>
        <a class="confirmButton" href="<?php echo SITE_URL; ?>/admin/news/delete_category/<?php echo $category['id']; ?>">Удалить</a>
      </td>
    </tr>
    <?php } ?>
  </table>
  <?php } ?>
</div>