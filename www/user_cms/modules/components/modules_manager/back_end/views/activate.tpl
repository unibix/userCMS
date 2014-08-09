<div id="content">
	<h1 id="page_name"><?php echo $page_name; ?></h1>
	<?php 
	if(isset($errors)) { ?>
	<div class="error">
		<?php foreach($errors as $error) { 
		 echo $error . '<br>';
		 } ?>
	</div>
	<?php 
	}
	if(isset($message)) { ?>
	<div class="success">
		<?php echo $message; ?>
	</div>
	<?php 
	} ?>
  
	<div id="add_tabs" class="tabs">
		<ul>
			<li><a class="tab_main active">Основное</a></li>
			<li><a class="tab_pages">Разделы</a></li>
			<li><a class="tab_params">Параметры</a></li>
		</ul>
	</div>

	<form method="post" action="" enctype="multipart/form-data" >
		<input type="hidden" name="type" value="addon" >

		<div id="tabs_content">
			<div id="tab_main" style="display: block;">
        <input type="hidden" name="type" value="<?php echo $module_type; ?>">
				<label for="name">Название</label>
				<input type="text" name="name" >
        <?php if ($module_type == 'addon') { ?>
          <label for="position">Позиция</label>
          <select name="position">
            <option value="before">before</option>
            <option value="after">after</option>
          </select>
        <?php } elseif ($module_type == 'plugin') { ?>
          <input type="hidden" name="position" value="<?php echo $module_dir; ?>">
        <?php } else { ?>
          <label for="position">Позиция</label>
          <input type="text" name="position">
        <?php } ?>
				<label for="back_end">Использовать в админке:</label>
				<input type="radio" name="back_end" value="1" > Да  <input type="radio" name="back_end" value="0" checked > Нет
		     	<br>
		    </div>
		    <div id="tab_pages">
          <div class="backend-note" style="display: none">Настройка разделов для админки не требуется</div>
          <div id="module_section_types">
            <input id="section_type_all" checked type="radio" name="section_type" value="all"> <label for="section_type_all">На всех</label>
            <input id="section_type_choosed" type="radio" name="section_type" value="choosed"> <label for="section_type_choosed">На выбранных</label>
            <input id="section_type_except" type="radio" name="section_type" value="except"> <label for="section_type_except">На всех, кроме выбранных</label>
          </div>
          <div id="module_sections" style="display: none;">
            <div class="list">
              <?php $first_component = true; ?>
              <fieldset>
                <legend>Страницы</legend>
                <?php foreach ($sections as $section) { ?>
                <?php if ($section['component'] != 'pages' && $first_component) {
                        $first_component = false; ?>
              </fieldset>
              <fieldset>
                <legend>Компоненты</legend>
                <?php } ?>
                <input checked id="module_section_<?php echo $section['main_id']; ?>" type="checkbox" name="sections[]" value="<?php echo $section['main_id']; ?>">
                <label for="module_section_<?php echo $section['main_id']; ?>"><?php echo $section['name']; ?></label> </br>
                <?php } ?>
              </fieldset>
            </div>
            <div class="buttons">
              <a onClick="checkAll('#tab_pages')">Отметить все</a> | <a onClick="uncheckAll('#tab_pages')">Снять выделение</a>
            </div>
          </div>
		    </div>
		    <div id="tab_params">
		    	<?php echo $params; ?>
		    </div>
        </div>
        <input type="submit" name="activate" value="Активировать"> 
	</form>
</div>

<script type="text/javascript">
$(document).ready(function() {
  $('#module_section_types input[type="radio"]').change(function() {
    if ($(this).val() == 'all') {
      $('#module_sections').hide();
    } else {
      $('#module_sections').show();
    }
  });
  
  $('#tab_main').on('change', 'input[name="back_end"]', function () {
    if ($(this).val() == 1) {
      $('#module_section_types').append('<input type="hidden" name="section_type" value="all">');
      $('#tab_pages div.backend-note').show();
      $('#module_section_types').hide();
      $('#module_sections').hide();
    } else {
      $('#module_section_types input[type="hidden"][name="section_type"]').remove();
      $('#tab_pages div.backend-note').hide();
      $('#module_section_types').show();
      $('#module_sections').show();
    }
  });
});
</script>