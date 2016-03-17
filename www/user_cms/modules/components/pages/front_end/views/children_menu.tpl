<div id="content" class="content">
	<h1 id="page_name"><?php echo $page_name; ?></h1>
	<p class="bread_crumbs"><?php echo $bread_crumbs; ?></p>
  <?php if ($children) { ?>
  <div id="page_children">
    <ul>
      <?php foreach ($children as $child) { ?>
      <li><a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a></li>
      <?php } ?>
    </ul>
  </div>
  <?php } ?>
	<?php echo $content; ?>
</div>