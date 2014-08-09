<div id="content">
  <h1><?php echo $page_name; ?></h1>
  <p class="buttons">
    <a class="button" href="<?php echo SITE_URL . '/admin/components_manager/activate'; ?>">Активировать</a>
    <a class="button" href="<?php echo SITE_URL . '/admin/components_manager'; ?>">К списку всех компонентов</a>
  </p>
  <?php if ($components) { ?>
  <table class="main">
    <thead>
      <tr>
        <th>Название компонента</th>
        <th>URL</th>
        <th>Дата изменения</th>
        <th>Компонент</th>
        <th>Действия</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($components as $component) { ?>
		<tr class="row_<?php echo $component['id']; ?>">
			<td class="page_name"><?php echo $component['name']; ?></td>
			<td class="page_url"><a href="<?php echo SITE_URL . '/' . $component['url']; ?>" target="_blank"><?php echo $component['url']; ?></a></td>
			<?php if ($component['date_edit']) { ?>
      <td class="page_date_add"><?php echo date('d.m.Y H:i', $component['date_edit']); ?></td>
      <?php } else { ?>
      <td class="page_date_add"><?php echo date('d.m.Y H:i', $component['date_add']); ?></td>
      <?php } ?>
			<td class="page_component"><?php echo $component['component']; ?></td>
			<td class="actions">
				<a href="<?php echo SITE_URL;?>/admin/<?php echo $component['component'] ?>" >Управление</a>
				<a href="<?php echo SITE_URL;?>/admin/components_manager/edit/<?php echo $component['id'] ?>" >Изменить</a>
				<a href="<?php echo SITE_URL;?>/admin/components_manager/deactivate/<?php echo $component['id'] ?>" >Деактивировать</a>
				<?php foreach($component['config'] as $key => $value) { 
					if(strpos($key, 'action_') === 0) {
						$key = str_replace('action_', '', $key);
					?>
					<a href="<?php echo SITE_URL;?>/admin/<?php echo $component['component']; ?>/<?php echo $key; ?>" ><?php echo $value; ?></a>
					<?php
					}
				} ?>
			</td>
		</tr>
		<?php } ?>
    </tbody>
  </table>
  <?php } ?>
</div>