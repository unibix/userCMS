<div id="content">
	<h1><?php echo $page_name ; ?></h1>
	<?=$breadcrumbs;?>
	<?php if($success) { ?>
	<div class="notice success">
		<?php echo $success; ?>
	</div>
	<?php } ?>
	
	<p class="buttons">
		<a class="button" href="<?php echo SITE_URL . '/admin/users/add'; ?>">Добавить пользователя</a>
	</p>
	<table class="users main">
		<tr>
			<th>id</th><th>Логин</th><th>Email</th><th>admin</th><th>Дата регистрации</th><th>Дата изменения</th><th>Действия</th>
		</tr>
	<?php foreach($users as $user) { ?>
		<tr <?php if($added_id == $user['id']) { ?> class="just-added" <?php } ?>>
			<td><?php echo $user['id']; ?></td>
			<td><?php echo $user['login']; ?></td>
			<td><?php echo $user['email']; ?></td>
			<td><?php if($user['access_level'] >= 1 ) { ?> + <?php } else { ?> - <?php } ?></td>
			<td><?php echo date('d.m.Y H:i', $user['date_add']); ?></td>
			<td><?php echo date('d.m.Y H:i', $user['date_edit']); ?></td>
			<td>
				<a href="<?php echo SITE_URL . '/admin/users/edit/' . $user['id']; ?>">Изменить</a> |
				<a class="confirmButton" href="<?php echo SITE_URL . '/admin/users/delete/' . $user['id']; ?>">Удалить</a>
			</td>
		</tr>
	<?php } ?>
	</table>
</div>