<div id="content">
	<h1 id="page_name"><?php echo $page_name; ?></h1>
	<p class="buttons">
    <a class="button" href="<?php echo SITE_URL; ?>/admin/news/categories">К списку категорий</a>
  </p>
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
		</ul>
	</div>
	<form method="post" action="">
		<div id="tabs_content">
			<div id="tab_main" style="display: block;">
				<label for="page_name">Название категории:</label>
				<input type="text"  name="name" value="<?php echo $name; ?>">
				<label for="page_category">Род. категория:</label>
				<select name="parent_category">
					<option value="0">Новости</option>
					<?php if (!empty ($parent_categories)) foreach ($parent_categories as $parent_categorie) { ?>
						<option value="<?php echo $parent_categorie['id']; ?>" <?php if ($sub==$parent_categorie['id']) { ?>selected<?php } ?>><?php echo $parent_categorie['name']; ?></option>
					<?php } ?>
				</select>
				<label for="page_text">Краткое описание (можно оставить пустым):</label>
				<textarea name="preview" ><?php echo $preview; ?></textarea>
				<label for="page_text">Текст:</label>
				<textarea class="wysiwyg" name="text" ><?php echo $text; ?></textarea>
		        <label for="date">Дата публикации (до этой даты все новости из этой категории будут скрыты)</label>
				<input type="text" name="date" value="<?=date('d.m.Y H:i', $date)?>">
				<p>Дата создания: <?=date('d.m.Y H:i', $date_add)?></p>
		      	<?php if($date_edit != 0) { ?>
		        <p>Дата изменения: <?=date('d.m.Y H:i', $date_edit)?></p>
		      	<?php } ?>
			</div>
			<div id="tab_seo">
				<label for="page_title">Заголовок (title):</label>
				<input type="text"  name="title" value="<?php echo $title; ?>">
				<label for="page_keywords">Ключевые слова(keywords):</label>
				<input type="text"  name="keywords" value="<?php echo $keywords; ?>">
				<label for="page_description">Описание (description):</label>
				<input type="text"  name="description" value="<?php echo $description; ?>">
				<label for="page_url">URL:</label>
				<input type="text"  name="url" value="<?php echo $url; ?>">
			</div>
			<p class="buttons"><input type="submit" name="submit_category" value="<?php echo $text_submit; ?>"></p>
		</div>
	</form>
</div>