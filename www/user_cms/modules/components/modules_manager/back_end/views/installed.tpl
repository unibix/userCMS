<div id="content">
	<h1 id="module_name"><?=$page_name;?></h1>
	<?php if($success) { ?>
	<div class="notice success">
		<?php echo $success; ?>
	</div>
	<?php } ?>
	<p class="buttons">
		<a href="<?php echo SITE_URL;?>/admin/modules_manager/install" class="button">Установить</a> 
		<a href="<?php echo SITE_URL;?>/admin/modules_manager/update" class="button">Обновить</a> 
	</p>
	<table class="main">
		<tr>
			<th>Название</th><th>Тип</th><th>Папка</th><th>Версия</th><th>Дата установки</th><th>Действия</th>
		</tr>
		<?php foreach($modules_list as $module) { 
			$module['date_add'] = date('d-m-Y', (int)$module['date_add']);
		?>
		<tr>
			<td title="<?php echo $module['description']; ?>"><?php echo $module['name']; ?></td>
			<td><?php echo $module['type']; ?></td>
			<td><?php echo $module['dir']; ?></td>
			<td><?php echo $module['version']; ?></td>
			<td><?php echo $module['date_add']; ?></td>
			<td class="actions">
				<a href="<?php echo SITE_URL;?>/admin/modules_manager/activate/<?php echo $module['id']; ?>" >Активировать</a>
				<a class="confirmButton" href="<?php echo SITE_URL;?>/admin/modules_manager/delete/<?php echo $module['id']; ?>" >Удалить</a>
			</td>
		</tr>
		<?php } ?>
	</table>
	
</div>
