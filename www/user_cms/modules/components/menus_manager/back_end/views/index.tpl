<div id="content">
	<h1><?php echo $page_name ; ?></h1>
	<?php if($success) { ?>
	<div class="notice success">
	<?php foreach($success as $success) { ?>
		<?php echo $success; ?><br>
	<?php } ?>
	</div>
	<?php } ?>
	<?php if($errors) { ?>
	<div class="notice error">
	<?php foreach($errors as $error) { ?>
		<?php echo $error; ?><br>
	<?php } ?>
	</div>
	<?php } ?>
  	<?php if($notices) { ?>
	<div class="notice attention">
		<?php foreach($notices as $notice) { ?>
		<p><?php echo $notice; ?></p>
		<?php } ?>
	</div>
	<?php } ?>
  <p class="buttons">
    <a class="button" href="<?php echo SITE_URL; ?>/admin/menus_manager/add">Создать новое меню</a>
  </p>
<?php if($menus) { ?>
<table class="main">
		<tr>
			<th>Название</th><th>Класс</th><th>Элементов</th><th>Действия</th>
		</tr>

		<?php foreach($menus as $menu) { ?>
		<tr>
			<td><?php echo $menu['name']; ?></td>
			<td><?php echo $menu['class']; ?></td>
			<td><?php echo $menu['count']; ?></td>
			<td class="actions">
				<a href="<?php echo SITE_URL;?>/admin/menus_manager/menu/<?php echo $menu['id']; ?>" >Элементы</a>
				<a href="<?php echo SITE_URL;?>/admin/menus_manager/edit/<?php echo $menu['id']; ?>" >Изменить</a>
				<a href="<?php echo SITE_URL;?>/admin/menus_manager/delete/<?php echo $menu['id']; ?>" >Удалить</a>
			</td>
		</tr>
  <?php } ?>
	</table>
<?php } ?>
</div>
<script type="text/javascript">
</script>