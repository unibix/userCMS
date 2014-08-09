<div id="content">
	<h1 id="module_name"><?php echo $page_name; ?></h1>
	<?php if($success) { ?>
	<div class="notice success">
		<?php echo $success; ?>
	</div>
	<?php } ?>
	<p class="buttons">
		<a href="<?php echo SITE_URL;?>/admin/components_manager/activate" class="button">Активировать</a> 
		<a href="<?php echo SITE_URL;?>/admin/components_manager/activated" class="button">Активированые компоненты</a> 
	</p>
	<table class="main"> 
		<tr>
			<th>Название</th><th>Просмотр</th><th>Действия</th>
		</tr>
		<?php foreach($components_list as $component) { ?>
		<tr>
			<td><?php echo $component['name']; ?></td>
			<td>
        <?php if ($component['href']) { ?>
        <a target="_blank" href="<?php echo $component['href']; ?>"><?php echo $component['dir']; ?></a>
        <?php } else { ?>
        <?php echo $component['dir']; ?>
        <?php } ?>
      </td>
			<td class="actions">
				[
        <?php if (file_exists(ROOT_DIR . '/modules/components/' . $component['dir'] . '/back_end/controller_component_' . $component['dir'] . '.php')) { ?>
          <a href="<?php echo SITE_URL;?>/admin/<?php echo $component['dir']; ?>" >Управление</a> |
        <?php } ?>
        <a href="<?php echo SITE_URL;?>/admin/components_manager/settings/<?php echo $component['dir']; ?>" >Настройки</a>
        ] <br>
        <?php if ($component['actions']) { ?>
        <ul>
          <?php foreach ($component['actions'] as $action) { ?>
          <li><a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a></li>
          <?php } ?>
        </ul>
        <?php } ?>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>
