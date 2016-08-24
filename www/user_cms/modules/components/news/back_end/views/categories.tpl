<div id="content">
	<h1 id="page_name"><?=$page_name?></h1>
	<?php if($success) { ?>
	<div class="notice success">
		<?php foreach($success as $msg) { ?>
		<p><?=$msg?></p>
		<?php } ?>
	</div>
	<?php } ?>
	<?php if($errors) { ?>
	<div class="notice error">
	<?php foreach($errors as $error) { ?>
		<p><?=$error?></p>
	<?php } ?>
	</div>
	<?php } ?>
	<p class="buttons">
    <a class="button" href="<?=SITE_URL?>/admin/news/add_category">Добавить категорию</a>
  </p>
  <?php if($categories) { ?>
  <table class="main">
    <tr>
      <th>Дата<br>публикации</th>
      <th>Заголок</th>
      <th>Количество <br/> новостей</th>
      <th>Действия</th>
    </tr>
    <?php foreach($categories as $category) { ?>
    <tr>
      <td><?=date('d.m.Y H:i', $category['date'])?></td>
      <td><?=$category['name']?></td>
      <td><?=$category['count_news']?></td>
      <td class="actions">
        <a href="<?=SITE_URL?>/admin/news/add/category_id=<?=$category['id']?>">Добавить новость</a>
        <a href="<?=SITE_URL?>/admin/news/category_id=<?=$category['id']?>">Обзор новостей</a> |
        <a href="<?=SITE_URL?>/admin/news/edit_category/<?=$category['id']?>">Изменить</a>
        <a class="confirmButton" href="<?=SITE_URL?>/admin/news/delete_category/<?=$category['id']?>">Удалить</a>
      </td>
    </tr>
    <?php } ?>
  </table>
  <?php } ?>
</div>