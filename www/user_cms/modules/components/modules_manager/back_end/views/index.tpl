<div id="content">
	<h1 id="module_name"><?=$page_name;?></h1>
	<?php if($success) { ?>
	<div class="notice success">
		<?php echo $success; ?>
	</div>
	<?php } ?>
	<p class="buttons">
		<a href="<?php echo SITE_URL;?>/admin/modules_manager/installed" class="button">Активировать</a> 
		<a href="<?php echo SITE_URL;?>/admin/modules_manager/install" class="button">Установить</a> 
		<a href="<?php echo SITE_URL;?>/admin/modules_manager/update" class="button">Обновить</a> 
	</p>
  <h4>Сайт <span>(front-end)</span></h4>
	<table class="main front_end">
    <thead>
      <tr>
        <th>Название</th><th class="td_50">Тип</th><th class="td_190">Позиция</th><th class="td_70">Порядок загрузки</th><th class="td_115">Дата изменения</th><th class="td_115">Действия</th>
      </tr>
    </thead>
		<?php foreach($front_end_modules_list as $module) { ?>
		<tr data-item-id="<?php echo $module['id']; ?>">
			<td><?php echo $module['name']; ?></td>
			<td title="<?php echo $module['module_dir']; ?>"><?php echo $module['type']; ?></td>
			<td>
        <?php if ($module['type'] == 'block') { 
                $module['position'] = '[position=<span class="module-position">' . $module['position'] . '</span>]';
              } elseif ($module['type'] == 'plugin') {
                $module['position'] = '<span>{</span>plugin:<span class="module-position">' . $module['position'] . '</span>=params}';
              } ?>
        <?php echo $module['position']; ?>
      </td>
			<td class="sort"><span class="before">↑</span> <span class="after">↓</span></td>
			<td><?php echo date('d-m-Y', $module['date_edit']); ?></td>
			<td class="actions">
				<a href="<?php echo SITE_URL;?>/admin/modules_manager/settings/<?php echo $module['id']; ?>" >Настройки</a>
				<a href="<?php echo SITE_URL;?>/admin/modules_manager/deactivate/<?php echo $module['id']; ?>" >Деактивировать</a>
			</td>
		</tr>
		<?php } ?>
	</table>
  
  <h4>Админка <span>(back-end)</span></h4>
  <table class="main back_end">
    <thead>
      <tr>
        <th>Название</th><th class="td_50">Тип</th><th class="td_190">Позиция</th><th class="td_70">Порядок загрузки</th><th class="td_115">Дата изменения</th><th class="td_115">Действия</th>
      </tr>
    </thead>
		<?php foreach($back_end_modules_list as $module) { ?>
		<tr data-item-id="<?php echo $module['id']; ?>">
      <td><?php echo $module['name']; ?></td>
			<td title="<?php echo $module['module_dir']; ?>" class="td_50"><?php echo $module['type']; ?></td>
			<td class="td_190">
        <?php if ($module['type'] == 'block') { 
                $module['position'] = '[position=<span class="module-position">' . $module['position'] . '</span>]';
              } elseif ($module['type'] == 'plugin') {
                $module['position'] = '<span>{</span>plugin:<span class="module-position">' . $module['position'] . '</span>=params}';
              } ?>
        <?php echo $module['position']; ?>
      </td>
			<td class="sort td_70"><span class="before">↑</span> <span class="after">↓</span></td>
			<td class="td_115"><?php echo date('d-m-Y', $module['date_edit']); ?></td>
			<td class="actions td_115">
				<a href="<?php echo SITE_URL;?>/admin/modules_manager/settings/<?php echo $module['id']; ?>" >Настройки</a>
				<a href="<?php echo SITE_URL;?>/admin/modules_manager/deactivate/<?php echo $module['id']; ?>" >Деактивировать</a>
			</td>
		</tr>
		<?php } ?>
  </table>
  <script type="text/javascript">
    jQuery.fn.outerHTML = function(s) {
      return s
          ? this.before(s).remove()
          : jQuery("<p>").append(this.eq(0).clone()).html();
    };
    
    $('table.main').on('click', '.sort span', function(event) {
      var search_row = $(this).closest('tr');
      
      var item_id = $(search_row).data('item-id');
      
      var table = $(search_row).closest('table.main');
      if ($(table).hasClass('back_end')) {
        var back_end = 1;
      } else {
        var back_end = 0;
      }
      
      if (!item_id) {
        return;
      }
      
      if ($(event.target).hasClass('before')) {
        var replace_row = $(search_row).prevAll('tr:not([class=child]):first');
        var direction = 'before';
      } else {
        var replace_row = $(search_row).nextAll('tr:not([class=child]):first');
        var direction = 'after';
      }
      
      $(search_row).addClass('moving'); 
      
      startLoading();
      
      $.ajax({
        url: '<?php echo SITE_URL ?>/admin/modules_manager/change_activated_module_sort/module_id=' + item_id + '/direction=' + direction + '/back_end=' + back_end,
        success: function(result) {
          if (result == 1) {
              // все ок, меняем строки местами
              var r = $(replace_row).outerHTML();
              var s = $(search_row).outerHTML();
              
              if ($(replace_row).next().hasClass('child')) {
                r += $(replace_row).next().outerHTML();
                $(replace_row).next().remove();
              }
              
              if ($(search_row).next().hasClass('child')) {
                s += $(search_row).next().outerHTML();
                $(search_row).next().remove();
              }
              
              $(search_row).replaceWith(r);
              $(replace_row).replaceWith(s);
              
          }
          
          setTimeout(function() {
            $('table.main tr').removeClass('moving');
            endLoading();
          }, 300)
        }
      });
    });
  </script>
</div>
