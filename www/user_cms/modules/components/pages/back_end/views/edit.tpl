<div id="content">
	<h1 id="page_name"><?php echo $page_name . ' "' . trim($name) . '"'; ?></h1>
	<?php if($errors) { ?>
	<div class="notice error">
		<?php foreach($errors as $error) { ?>
		<p><?php echo $error; ?></p>
		<?php } ?>
	</div>
	<?php } ?>
		<?php if($success) { ?>
	<div class="notice success">
		<?php foreach($success as $msg) { ?>
		<p><?php echo $msg; ?></p>
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
	<div id="add_tabs" class="tabs">
		<ul>
			<li><a class="tab_main active">Основное</a></li>
			<li><a class="tab_seo">SEO</a></li>
			<li><a class="tab_view">Вид</a></li>
		</ul>
	</div>
	<form method="post" action="<?php echo SITE_URL;?>/admin/pages/edit/<?php echo $id;?>">
		<div id="tabs_content">
			<div id="tab_main" style="display: block;">
				<label for="page_name">Название страницы</label>
				<input type="text"  name="page_name" value="<?php echo $name; ?>">
				<label for="page_text">Текст</label>
				<textarea class="wysiwyg" name="page_text" ><?php echo $text; ?></textarea>
        <?php if ($id != 1) { ?>
				<label for="page_parent_id">Родительская страница</label>
				<select name="page_parent_id">
					<option value="0">Нет родительской страницы</option>
          <?php echo $categories_options; ?>
				</select>
        <?php } ?>
			</div>
			<div id="tab_seo">
				<label for="page_title">Заголовок (title)<span>Количество символов: <?php echo mb_strlen($title, 'UTF-8'); ?> (рекомендуется до 70).</span></label>
				<input type="text"  name="page_title" value="<?php echo $title; ?>">
				<label for="page_keywords">Ключевые слова(keywords)</label>
				<input type="text"  name="page_keywords" value="<?php echo $keywords; ?>">
				<label for="page_description">Описание (description)</label>
				<input type="text"  name="page_description" value="<?php echo $description; ?>">
        <?php if ($id !== 1) { ?>
          <label for="page_url">URL</label>
          <input type="text"  name="page_url" value="<?php echo $url; ?>">
        <?php } else { ?>
          <input type="hidden" name="page_url" value="<?php echo $url; ?>">
        <?php } ?>
			</div>
			<div id="tab_view">
        <label>Вид контента (по умолч. index)</label>
				<select name="page_view">
          <?php foreach ($page_views as $filename) { ?>
            <?php if ($filename == $page_view) { ?>
            <option selected value="<?php echo $filename; ?>"><?php echo $filename; ?></option>
            <?php } else { ?>
            <option value="<?php echo $filename; ?>"><?php echo $filename; ?></option>            
            <?php } ?>
          <?php } ?>
        </select>
        <label>Файл темы (по умолч. index)</label>
				<select name="theme_view">
          <?php foreach ($theme_views as $filename) { ?>
            <?php if ($filename == $theme_view) { ?>
            <option selected value="<?php echo $filename; ?>"><?php echo $filename; ?></option>
            <?php } else { ?>
            <option value="<?php echo $filename; ?>"><?php echo $filename; ?></option>            
            <?php } ?>
          <?php } ?>
        </select>
			</div>
			<p class="buttons"><input type="submit" name="edit" value="Сохранить"> <input type="submit" name="edit_exit" value="Сохранить и выйти"> </p>
		</div>
	</form>
  <script type="text/javascript">
    $('input[name="page_title"]').keyup(function() {
        var l = $(this).val().length;
        var text = 'Количество символов: ' + l + ' (рекомендуется до 70).';
        $('label[for="page_title"] span').html(text);
        if (l>70) {
          $('label[for="page_title"] span').addClass('warning-text');
        } else {
          $('label[for="page_title"] span').removeClass('warning-text');
        }
    });
  </script>
</div>