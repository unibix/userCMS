<div id="content">
	<h1 id="page_name"><?php echo $page_name; ?></h1>
	
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
	<?php if ($categories) { ?>
	
	<div id="add_tabs" class="tabs">
		<ul>
			<li><a class="tab_main active">Основное</a></li>
			<li><a class="tab_seo">SEO</a></li>
		</ul>
	</div>
	<form method="post" action="">
		<div id="tabs_content">
			<div id="tab_main" style="display: block;">
				<label for="page_name">Заголовок новости:</label>
				<input type="text"  name="name" value="<?php echo $name; ?>">
				<label for="page_text">Краткое описание (можно оставить пустым):</label>
				<textarea name="preview" ><?php echo $preview; ?></textarea>
				<label for="page_text">Текст:</label>
				<textarea class="wysiwyg" name="text" ><?php echo $text; ?></textarea>
				<label for="page_parent_id">Категория:</label>
				<select name="category_id">
        <?php foreach($categories as $category) { ?>
          <?php if($category['id'] == $category_id) { ?>
					<option selected value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
          <?php } ?>
        <?php } ?>
				</select>
        <label for="page_name">Дата добавления:</label>
				<input type="text"  name="date_add" value="<?php echo $date_add; ?>">
      <?php if($date_edit) { ?>
        <label for="page_name">Дата редактирования:</label>
				<input type="text"  name="date_edit" value="<?php echo $date_edit; ?>">
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
			<p class="buttons"><input type="submit" name="submit_news" value="<?php echo $text_submit; ?>"></p>
		</div>
	</form>
	<?php }  else { ?>
	<div class="notice error">
		<p>Необходимо сначала добавить категорию новостей...</p>
	</div>	
	<?php } ?>
	
</div>
