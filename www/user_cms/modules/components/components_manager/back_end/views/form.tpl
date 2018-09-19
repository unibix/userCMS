<div id="content">
	<h1 id="page_name"><?php echo $page_name; ?></h1>
  <?=$breadcrumbs;?>
	<?php 
	if($errors) { ?>
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
  <form method="post" action="">
  <?php if($this->url['actions'][0]=='activate') { ?>
    <label>Компонент:</label>
    <select name="component">
      <?php foreach($components as $component) { ?>
        <?php if($component_dir == $component['dir']) { ?>
          <option selected value="<?php echo $component['dir']; ?>"><?php echo $component['name'] . ' &nbsp;(' . $component['dir'] . ')'; ?></option>
        <?php } else { ?>
          <option value="<?php echo $component['dir']; ?>"><?php echo $component['name'] . ' &nbsp; (' . $component['dir'] . ')'; ?></option>
        <?php } ?>
      <?php } ?>
    </select>
  <?php } ?>
    
    <label>Название</label>
    <input type="text" name="name" value="<?php echo $name; ?>">
    
    <label for="page_title">Заголовок (title)</label>
    <input type="text"  name="title" value="<?php echo $title; ?>">
    
    <label for="page_keywords">Ключевые слова(keywords)</label>
    <input type="text"  name="keywords" value="<?php echo $keywords; ?>">
    
    <label for="page_description">Описание (description)</label>
    <input type="text"  name="description" value="<?php echo $description; ?>">
    
    <label for="page_url">URL</label>
    <input type="text"  name="url" value="<?php echo $url; ?>">
    
    <input type="submit" name="component_info" value="<?php echo $text_submit; ?>">
  </form>
</div>