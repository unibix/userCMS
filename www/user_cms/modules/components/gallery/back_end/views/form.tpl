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
	<div id="add_tabs" class="tabs">
		<ul>
			<li><a class="tab_main active">Основное</a></li>
			<li><a class="tab_seo">SEO</a></li>
		</ul>
	</div>
	<form method="post" action="" enctype="multipart/form-data">
		<div id="tabs_content">
			<div id="tab_main" style="display: block;">
      
				<label for="page_name">Заголовок категории:</label>
				<input type="text"  name="name" value="<?php echo $name; ?>">
      
      <div class="image-box">  
        <?php if($image) { ?>
        <img width="120" src="<?php echo SITE_URL . '/uploads/images/gallery/' . $dir . '/mini/' . $image; ?>">
        <style type="text/css">
.image-box {overflow: hidden;}
.image-box img {
  float: left;
  margin: 0 15px 0 0;
}  
#wrapper .image-box input[type="file"] {
    width: 75%;
}
</style>
        <?php } ?>
        <label for="page_name">Изображение:</label><br>
				<input type="file"  name="image">
      </div>
      
				<label for="page_text">Родительская категория:</label>
				<select name="parent">
					<option value="0">Галерея</option>
					<?php if (!empty($parents)) foreach($parents as $prt) { ?>
					<option value="<?php echo $prt['id']; ?>"<?php if ($prt['id']==$parent) { ?> selected<?php } ?>><?php echo $prt['name']; ?></option>
					<?php } ?>
				</select>
				
				<label for="page_text">Краткое описание (можно оставить пустым):</label>
				<textarea name="preview" ><?php echo $preview; ?></textarea>
        
				<label for="page_text">Текст:</label>
				<textarea class="wysiwyg" name="text" ><?php echo $text; ?></textarea>
        
        <?php if($this->url['actions'][0] != 'edit') { ?>
        <label for="page_name">Название папки для изображений:</label>
				<input type="text"  name="dir" value="<?php echo $dir; ?>">
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
			<p class="buttons"><input type="submit" name="submit_gallery" value="<?php echo $text_submit; ?>"></p>
		</div>
	</form>
</div>
