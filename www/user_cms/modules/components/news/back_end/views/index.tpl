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
    <?php if($category_id) { ?>
    <a class="button" href="<?php echo SITE_URL; ?>/admin/news/add/category_id=<?php echo $category_id; ?>">Добавить новость</a>
    <?php } else { ?>
    <a class="button" href="<?php echo SITE_URL; ?>/admin/news/add">Добавить новость</a>
    <?php } ?>
  </p>
  <?php if($categories) { ?>
  <select name="category" onChange="this.options[this.selectedIndex].onclick()">
    <option onClick="window.location=this.value;" value="<?php echo $option_value; ?>">Все новости</option>
    <?php foreach($categories as $category) { ?>
      <?php if($category_id == $category['id']) { ?>
      <option onClick="window.location=this.value;" value="<?php echo $option_value . '/category_id=' . $category['id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
      <?php } else { ?>
      <option onClick="window.location=this.value;" value="<?php echo $option_value . '/category_id=' . $category['id']; ?>"><?php echo $category['name']; ?></option>
      <?php } ?>
    <?php } ?>
  </select>
  <?php } ?>
  <?php if($news) { ?>
  <table class="main">
    <tr>
      <th>Заголок</th>
      <th>Категория</th>
      <th>Действия</th>
    </tr>
    <?php foreach($news as $item) { ?>
    <tr>
      <td><?php echo $item['name']; ?></td>
      <td><?php echo $item['cat_name']; ?></td>
      <td class="actions">
        <a href="<?php echo SITE_URL; ?>/admin/news/edit/<?php echo $item['id']; ?>">Изменить</a>
        <a class="confirmButton" href="<?php echo SITE_URL; ?>/admin/news/delete/<?php echo $item['id']; ?>">Удалить</a>
      </td>
    </tr>
    <?php } ?>
  </table>
  <?php } ?>
</div>