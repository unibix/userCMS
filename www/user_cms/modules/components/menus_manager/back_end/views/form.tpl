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
		<label for="menu_name">Название:</label><br>
		<input id="menu_name" type="text" name="menu_name" value="<?php echo $menu['name']; ?>" >
		
		<label for="menu_class">Класс:</label><br>
		<input id="menu_class" type="text" name="menu_class" value="<?php echo $menu['class']; ?>">
    
    <?php if($this->url['actions'][0]=='add') { ?>
		<input type="hidden" name="menu_act" value="1" >
    
		<label for="menu_pos">Позиция:</label><br>
		<input id="menu_pos" type="text" name="menu_pos" value="<?php echo $menu['position']; ?>" >	

    <?php } ?>
    
		<input type="submit" value="<?php echo $text_submit; ?>" name="submit">
	<form>
</div>