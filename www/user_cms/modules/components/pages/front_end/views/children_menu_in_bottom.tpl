<div id="content" class="content">
	<h1 id="page_name"><?php echo $page_name; ?></h1>
	<?php echo $breadcrumbs;?>
  
	<?php echo $content; ?>
	
	<?php if (isset($children) && !empty($children)) { ?>
	  <div id="page_children">
		<ul>
		  <?php foreach ($children as $child) { ?>
		  <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
		  <?php } ?>
		</ul>
	  </div>
	<?php } ?>
  
</div>