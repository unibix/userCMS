<div id="content">
	<h1 id="page_name"><?php echo $page_name; ?></h1>
	<?php 
	if(isset($errors) && !empty($errors)) { ?>
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
	<?php } ?>

	

	<div id="add_tabs" class="tabs">
		<ul>
			<li><a class="tab_main">Основное</a></li>
			<li><a class="tab_pages">Разделы</a></li>
			<li><a class="tab_params active">Параметры</a></li>
		</ul>
	</div>

	<form method="post" action="" enctype="multipart/form-data" >
		<input type="hidden" name="type" value="addon" >
		<div id="tabs_content">
			<div id="tab_main">

				<label for="name">Название</label>
				<input type="text" name="name" value="<?php echo $module_info['name']; ?>" >
        <?php if ($module_info['type'] == 'addon') { ?>
          <label for="position">Позиция</label>
          <select name="position">
            <?php if ($module_info['position'] == 'before') { ?>
            <option selected value="before">before</option>
            <option value="after">after</option>
            <?php } else { ?>
            <option value="before">before</option>
            <option selected value="after">after</option>
            <?php } ?>
          </select>
        <?php } elseif ($module_info['type'] == 'plugin') { ?>
          <input type="hidden" name="position" value="<?php echo $module_info['module_dir']; ?>">
        <?php } else { ?>
          <label for="position">Позиция</label>
          <input type="text" name="position" value="<?php echo $module_info['position']; ?>">
        <?php } ?>
				<label for="back_end">Использовать в админке:</label>
        <?php if($module_info['back_end']) { ?>
				<input type="radio" name="back_end" value="1" checked > Да  <input type="radio" name="back_end" value="0"> Нет
        <?php } else { ?>
				<input type="radio" name="back_end" value="1" > Да  <input type="radio" name="back_end" value="0" checked > Нет
        <?php } ?>
		     	<br>
		    </div>
		    <div id="tab_pages">
          <div class="backend-note" <?php if (!$module_info['back_end']) { ?>style="display: none"<?php } ?>>Настройка разделов для админки не требуется</div>
          <div id="module_section_types">
            <input <?php if ($section_type == 'all') { ?>checked<?php } ?> id="section_type_all" type="radio" name="section_type" value="all"> <label for="section_type_all">На всех</label>
            <input <?php if ($section_type == 'choosed') { ?>checked<?php } ?> id="section_type_choosed" type="radio" name="section_type" value="choosed"> <label for="section_type_choosed">На выбранных</label>
            <input <?php if ($section_type == 'except') { ?>checked<?php } ?> id="section_type_except" type="radio" name="section_type" value="except"> <label for="section_type_except">На всех, кроме выбранных</label>
          </div>
          <div id="module_sections" <?php if ($section_type == 'all') { ?>style="display: none;"<?php } ?>>
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
                <?php if ($module_info['sections'] && in_array($section['main_id'], $module_info['sections']['values'])) { ?>
                <input checked id="module_section_<?php echo $section['main_id']; ?>" type="checkbox" name="sections[]" value="<?php echo $section['main_id']; ?>">
                <?php } else { ?>
                <input id="module_section_<?php echo $section['main_id']; ?>" type="checkbox" name="sections[]" value="<?php echo $section['main_id']; ?>">
                <?php } ?>
              <label for="module_section_<?php echo $section['main_id']; ?>"><?php echo $section['name']; ?></label> </br>
              <?php } ?>
              </fieldset>
            </div>
            <div class="buttons">
              <a onClick="checkAll('#tab_pages')">Отметить все</a> | <a onClick="uncheckAll('#tab_pages')">Снять выделение</a>
            </div>
          </div>
		    </div>
		    <div id="tab_params" style="display: block;">

		    	<?php echo $params; ?>

		    </div>
		    


    </div>
		<input type="submit" name="edit_settings" value="Сохранить изменения"> 
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