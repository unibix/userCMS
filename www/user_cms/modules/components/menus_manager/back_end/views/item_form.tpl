<div id="content">
	<h1><?php echo $page_name ; ?></h1>
	<?=$breadcrumbs;?>
	<?php if($success) { ?>
	<div class="notice success">
		<?php echo $success; ?>
	</div>
	<?php } ?>
	<?php if($errors) { ?>
	<div class="notice error">
	<?php foreach($errors as $error) { ?>
		<?php echo $error; ?><br>
	<?php } ?>
	</div>
	<?php } ?>
	<form method="post" action="">
		<label for="item_name">Название:</label><br>
		<input id="item_name" type="text" name="item_name" value="<?php echo $item['name']; ?>" >
		
		<label for="item_url">Ссылка:</label><br>
		<input id="item_url" type="text" name="item_url" value="<?php echo $item['url']; ?>">
		
    <label for="items_list">Родительская ссылка</label>
    <select name="parent_id">
      <option value="0">Нет</option>
    <?php foreach ($items as $parent_item) { ?>
      <?php if (isset($item['parent_id']) && $parent_item['id'] == $item['parent_id']) { ?>
      <option selected value="<?php echo $parent_item['id']; ?>"><?php echo $parent_item['name']; ?></option>
      <?php } else { ?>
      <option value="<?php echo $parent_item['id']; ?>"><?php echo $parent_item['name']; ?></option>
      <?php } ?>
    <?php } ?>
    </select>
		<input type="submit" value="<?php echo $text_submit; ?>" name="submit">
	<form>
</div>