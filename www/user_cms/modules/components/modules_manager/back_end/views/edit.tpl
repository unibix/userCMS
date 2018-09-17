<script type="text/javascript">
	var redactor_object;
	$(function()
	{
		redactor_object = $('#imperator').redactor();
	});
	</script>
<div id="content">
	<h1 id="page_name">Добавление новой страницы</h1>
	<?=$breadcrumbs;?>
	<p class="buttons"><a href="<?php echo SITE_URL;?>/pages/add_component">Активировать компонент</a></p>
	<?php if($errors) { ?>
	<div class="notice error">
		<?php foreach($errors as $error) { ?>
		<p><?php echo $error; ?></p>
		<?php } ?>
	</div>
	<?php } ?>
	<div id="add_tabs" class="tabs">
		<ul>
			<li><a class="tab_main active">Основное</a></li>
			<li><a class="tab_seo">SEO</a></li>
			<li><a class="tab_view">Вид</a></li>
			<li><a class="tab_settings">Настройки</a></li>
		</ul>
	</div>
	<form method="post" action="<?php echo SITE_URL;?>/admin/pages/edit/<?php echo $id;?>">
		<div id="tabs_content">
			<div id="tab_main" style="display: block;">
				<label for="page_name">Название страницы</label>
				<input type="text"  name="page_name" value="<?php echo $name; ?>">
				<label for="page_text">Текст</label>
				<textarea id="imperator" name="page_text" ><?php echo $text; ?></textarea>
				<label for="page_parent_id">Категория</label>
				<select name="page_parent_id">
					<option value="0" <?php if(!$parent_id) { ?> selected <?php } ?>>Нет родительской страницы</option>
					<?php foreach($categories as $category) { ?>
					<option value="<?php echo $category['id'];?>" <?php if($parent_id==$category['id']) { ?> selected <?php } ?> ><?php echo $category['name'];?></option>
					<?php } ?>
				</select>
			</div>
			<div id="tab_seo">
				<label for="page_title">Заголовок (title)</label>
				<input type="text"  name="page_title" value="<?php echo $title; ?>">
				<label for="page_keywords">Ключевые слова(keywords)</label>
				<input type="text"  name="page_keywords" value="<?php echo $keywords; ?>">
				<label for="page_description">Описание (description)</label>
				<input type="text"  name="page_description" value="<?php echo $description; ?>">
				<label for="page_url">URL</label>
				<input type="text"  name="page_url" value="<?php echo $url; ?>">
			</div>
			<div id="tab_view">
				view
			</div>
			<div id="tab_settings">
				settings
			</div>
			<p class="buttons"><input type="submit" name="edit" value="Сохранить"> <input type="submit" name="edit_exit" value="Сохранить и выйти"> </p>
		</div>
	</form>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('.tabs ul li a').click(function(){
		if(!$(this).hasClass('active')){
			$('.tabs ul li a').removeClass('active');
			$('#tabs_content > div').fadeOut(100, function(){$('#'+container).fadeIn(100);});
			var container = $(this).attr('class');

			$(this).addClass('active');
		}
	});

});

</script>