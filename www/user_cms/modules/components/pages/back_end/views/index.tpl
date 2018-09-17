<div id="content">
	<h1 id="page_name"><?=$page_name;?></h1>
	<?=$breadcrumbs;?>
	<?php if($success) { ?>
	<div class="notice success">
		<?php echo $success; ?>
	</div>
	<?php } ?>
	<?php if($errors) { ?>
	<div class="error">
	<?php foreach($errors as $error) { ?>
		<?php echo $error; ?><br>
	<?php } ?>
	</div>
	<?php } ?>
	<p class="buttons">
    <a href="<?php echo SITE_URL;?>/admin/pages/add" class="button">Создать новую страницу</a> 
	<table id="pages_list" class="main with-children ajax-rows">
		<tr>
			<th>Название</th><th>URL</th><th>Дата изменения</th><th>Действия</th>
		</tr>
		<tr class="row_<?php echo $main_page['id']; ?>">
			<td class="page_name"><?php echo $main_page['name']; ?></td>
			<td><a href="<?php echo SITE_URL; ?>" target="_blank"><?php echo $main_page['url']; ?></a></td>
			<td class="td_140"><?php echo date('d.m.Y H:i', $main_page['date_edit']); ?></td>
			<td class="td_190 actions">
				<a href="<?php echo SITE_URL;?>/admin/pages/edit/<?php echo $main_page['id'] ?>" >Изменить</a>
			</td>
		</tr>
		<?php foreach($pages_list as $page) { ?>
		<?php if($page['id']!= 1) { ?>
		<tr class="row_<?php echo $page['id']; ?>">
			<td class="page_name">
				<?php if($page['children_count']) { ?>
				<span class="parent-page" parent_id="<?php echo $page['id']; ?>">
				</span>
				<?php } ?>
        <?php echo $page['name']; ?>
			</td>
			<td><a href="<?php echo SITE_URL . $page['full_url']; ?>" target="_blank">/<?php echo $page['url']; ?></a></td>
			<td class="td_140"><?php echo date('d.m.Y H:i', $page['date_add']); ?></td>
			<td class="td_190 actions">
				<a href="<?php echo SITE_URL;?>/admin/pages/edit/<?php echo $page['id'] ?>" >Изменить</a>
				<a class="confirmButton" href="<?php echo SITE_URL;?>/admin/pages/delete/<?php echo $page['id'] ?>" >Удалить</a>
			</td>
		</tr>
		<?php } ?>
		<?php } ?>
	</table>
  
  <?php if ($components) { ?>
  <h2>Активированные компоненты</h2>
	<p class="buttons"><a href="<?php echo SITE_URL;?>/admin/components_manager/activate" class="button">Активировать компонент</a></p>
  <table class="main" style="margin-top: 20px;">
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
		<tr class="row_<?php echo $page['id']; ?>">
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
				<a class="confirmButton" href="<?php echo SITE_URL;?>/admin/components_manager/deactivate/<?php echo $component['id'] ?>" >Деактивировать</a>
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
<script type="text/javascript">
$(document).ready(function() {
	$('table.main').on('click', '.parent-page', function(){
		if($('table.main tr td div:animated').length == 0){
			var parent_id = $(this).attr('parent_id');
			var children = $('.children_'+parent_id);
			$(this).parents('.row_'+parent_id).toggleClass('parent_row'); // добавляем тень к родительской строке
			if($(children).length > 0){
				if($(children).css('display')=='none'){
					$(children).show();
					$('#children_'+parent_id).slideDown(700);
				} else {
					$('#children_'+parent_id).slideUp(700, function(){
						$(children).hide();
					});
				}
				
				
			} else { // добавляем строки
        var level = 0;
        $(this).parents('table').each(function() {
            level++;
            if ($(this).attr('id') == 'pages_list') {
              return;
            }
        });
        
				$.ajax({
					url: '<?php echo SITE_URL ?>/admin/pages/ajax_get_children',
					type: 'post',
					data: 'parent_id=' + parent_id,
					cache: false,
					success: function(data) {
						$(data).insertAfter('.row_' + parent_id); // если сразу добавлять data в таблицу, jquery выдаст ошибку.
						// добавляем отступ слева
            level++;
            var p = level*12 + 10;
            $('#children_' + parent_id + ' .page_name').css('padding-left', p + 'px');
            $('#children_'+parent_id).slideDown(700);
					}
				});
			}
		}
	});
});
</script>