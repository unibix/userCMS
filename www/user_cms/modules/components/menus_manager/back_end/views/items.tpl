<div id="content">
	<h1><?php echo $page_name ; ?></h1>
  <?=$breadcrumbs;?>
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
    <a class="button" href="<?php echo SITE_URL; ?>/admin/menus_manager/add_item/menu_id=<?php echo $menu['id']; ?>">Добавить элемент</a>
  </p>
<?php if($items) { ?>
<table class="main ajax-rows">
  <thead>
		<tr>
			<th>Название</th><th>Ссылка</th><th>Сортировка</th><th>Действия</th>
		</tr>
  </thead>
  <tbody>
    <?php echo $menu_table_body; ?>
  </tbody>
	</table>
<?php } ?>
<script type="text/javascript">
  jQuery.fn.outerHTML = function(s) {
    return s
        ? this.before(s).remove()
        : jQuery("<p>").append(this.eq(0).clone()).html();
  };
  
  $('table.main').on('click', '.sort span', function(event) {
    var search_row = $(this).closest('tr');
    
    var item_id = $(search_row).data('item-id');
    
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
      url: '<?php echo SITE_URL ?>/admin/menus_manager/change_item_sort/item_id=' + item_id + '/direction=' + direction,
      success: function(result) {
        if (result) {
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