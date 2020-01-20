<div id="content">
	<h1 id="module_name"><?=$page_name;?></h1>
  <?=$breadcrumbs;?>
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
        <th>ID</th><th>Название</th><th class="td_50">Тип</th><th class="td_190">Позиция</th><th class="td_70">Порядок загрузки</th><th class="td_115">Дата изменения</th><th class="td_115">Действия</th>
      </tr>
    </thead>
		<?php foreach($front_end_modules_list as $module) { ?>
		<tr data-item-id="<?php echo $module['id']; ?>">
			<td><?php echo $module['id']; ?></td>
			<td><?php echo $module['name']; ?></td>
			<td title="<?php echo $module['module_dir']; ?>"><?php echo $module['type']; ?></td>
			<td>
        <?php if($module['type'] == 'addon') { ?>
          <span class="addon_position">
        <?php } ?>

        <?php if ($module['type'] == 'block') { 
                $module['position'] = '[position=<span class="module-position">' . $module['position'] . '</span>]';
              } elseif ($module['type'] == 'plugin') {
                $module['position'] = '<span class="btn-copy">copy</span><span class="sibl"><span>{</span>plugin:' . $module['position'] . '=' . $module['id'] . '}</span>';
              } ?>
        <?php echo $module['position']; ?>
        <?php if($module['type'] == 'addon') { ?>
          </span>
        <?php } ?>
      </td>
			<td class="sort">
        <?php if($module['type'] != 'plugin') { ?>
          <span class="before">↑</span> <span class="after">↓</span>
        <?php } else {/*nothing*/} ?>
      </td>
			<td><?php echo date('d-m-Y', $module['date_edit']); ?></td>
			<td class="actions">
				<a href="<?php echo SITE_URL;?>/admin/modules_manager/settings/<?php echo $module['id']; ?>" >Настройки</a>
				<a class="confirmButton" href="<?php echo SITE_URL;?>/admin/modules_manager/deactivate/<?php echo $module['id']; ?>" >Деактивировать</a>
			</td>
		</tr>
		<?php } ?>
	</table>
  
  <h4>Админка <span>(back-end)</span></h4>
  <table class="main back_end">
    <thead>
      <tr>
         <th>ID</th><th>Название</th><th class="td_50">Тип</th><th class="td_190">Позиция</th><th class="td_70">Порядок загрузки</th><th class="td_115">Дата изменения</th><th class="td_115">Действия</th>
      </tr>
    </thead>
		<?php foreach($back_end_modules_list as $module) { ?>
		<tr data-item-id="<?php echo $module['id']; ?>">
			<td><?php echo $module['id']; ?></td>
      <td><?php echo $module['name']; ?></td>
			<td title="<?php echo $module['module_dir']; ?>" class="td_50"><?php echo $module['type']; ?></td>
			<td class="td_190">
        <?php if($module['type'] == 'addon') { ?>
          <span class="addon_position">
        <?php } ?>
        <?php if ($module['type'] == 'block') { 
                $module['position'] = '[position=<span class="module-position">' . $module['position'] . '</span>]';
              } elseif ($module['type'] == 'plugin') {
                $module['position'] = '<span class="btn-copy">copy</span><span class="sibl"><span>{</span>plugin:' . $module['position'] . '=' . $module['id'] . '}</span>';
              } ?>
        <?php echo $module['position']; ?>
        <?php if($module['type'] == 'addon') { ?>
          </span>
        <?php } ?>
      </td>
			<td class="sort td_70">
        <?php if($module['type'] != 'plugin') { ?>
          <span class="before">↑</span> <span class="after">↓</span>
        <?php } else {/*nothing*/} ?>   
      </td>
			<td class="td_115"><?php echo date('d-m-Y', $module['date_edit']); ?></td>
			<td class="actions td_115">
				<a href="<?php echo SITE_URL;?>/admin/modules_manager/settings/<?php echo $module['id']; ?>" >Настройки</a>
				<a class="confirmButton" href="<?php echo SITE_URL;?>/admin/modules_manager/deactivate/<?php echo $module['id']; ?>" >Деактивировать</a>
			</td>
		</tr>
		<?php } ?>
  </table>
  <script type="text/javascript">
    need_arrows();

    jQuery.fn.outerHTML = function(s) {
      return s
          ? this.before(s).remove()
          : jQuery("<p>").append(this.eq(0).clone()).html();
    };

    $('.btn-copy').each(function() {
      this.addEventListener('click', function() {
          let copy_text = $(this).siblings('.sibl').text();
          let temp = document.createElement('input');
          temp.value = copy_text;
          document.body.append(temp);
          temp.select();
          document.execCommand('copy'); 
          document.body.removeChild(temp);
      });
    });
    
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
      
      let replace_item_id = $(replace_row).data('item-id');

      $(search_row).addClass('moving'); 
      
      startLoading();
      
      $.ajax({
        url: '<?php echo SITE_URL ?>/admin/modules_manager/change_activated_module_sort/module_id=' + item_id + '/direction=' + direction + '/back_end=' + back_end + '/module_replace_id=' + replace_item_id,
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

          need_arrows();
          
          setTimeout(function() {
            $('table.main tr').removeClass('moving');
            endLoading();
          }, 300)
        }
      });
    });
    
    // Функция скрывает или показывает стрелки перемещения 
    function show_hide_arrows(obj, elements) {

       for(let i = 0; i < elements.length; i++) {
         if(obj[elements[i].innerText]) {
           obj[elements[i].innerText].push(elements[i]);
         } else {
           obj[elements[i].innerText] = [elements[i]];
           obj.length++;
         }
       }
       
      for(let key in obj) {
       if(obj[key].length <= 1) { 
         for(let j = 0; j < obj[key].length; j++) {
           // Если в позиции один элемент, то убираем стрелки перемещения
          let before = $(obj[key][j]).parent().parent()[0].querySelector('.sort .before');
          let after = $(obj[key][j]).parent().parent()[0].querySelector('.sort .after');
           before.style.display = 'none';
           after.style.display = 'none';
         }
       } else {
           for(let j = 0; j < obj[key].length; j++) {
             let before = $(obj[key][j]).parent().parent()[0].querySelector('.sort .before');
             let after = $(obj[key][j]).parent().parent()[0].querySelector('.sort .after');
             before.style.display = '';
             after.style.display = '';
             // Для первого элемента в одной и той же позиции скрываем стрелку выше
             if(j == 0) {
               before.style.display = 'none';
             } else if(j == obj[key].length - 1) {
              // Для последнего элемента в одной и той же позиции скрываем стрелку ниже
               after.style.display = 'none';
             } else {
              before.style.display = '';
              after.style.display = '';
             }
           }
       }
      }
    }

    // Функция "следит" нужны ли стрелки перемещения
    function need_arrows() {

       // Считаем количество элементов в каждой позиции
       // И если элементов > 1, то разрешаем сортировку
       let position_blocks = $('.main')[0].querySelectorAll('.module-position');// frontend
       let position_addons = $('.main')[0].querySelectorAll('.addon_position');// frontend

       position_blocks_backend = $('.main')[1].querySelectorAll('.module-position');// backend
       position_addons_backend = $('.main')[1].querySelectorAll('.addon_position');// backend

       let elements_positions_addons = {length : 0};
       let element_positions_blocks = {length : 0};
       let elements_positions_addons_backend = {length : 0};
       let element_positions_blocks_backend = {length : 0};

       // frontend
       show_hide_arrows(elements_positions_addons, position_addons);
       show_hide_arrows(element_positions_blocks, position_blocks);

       // backend
       show_hide_arrows(elements_positions_addons_backend, position_addons_backend);
       show_hide_arrows(element_positions_blocks_backend, position_blocks_backend);

    }
  </script>
</div>
<style>
  .btn-copy {
    background: lightgray;
    border-radius: 5px;
    padding: 5px;
    color: gray;
  }
  .btn-copy:hover {
    transition: all 0.2s;
    color: white;
    cursor: pointer;
  }
</style>