<div id="content">
	<h1 id="page_name"><?=$page_name;?></h1>
	<p class="bread_crumbs"><?php echo $bread_crumbs; ?></p>
  <div id="gallery-box" class="categories">
    <?php if($categories) { ?>
      <?php foreach($categories as $category) { ?>
      <div>
        <h2><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></h2>
        <?php if($category['image']) { ?>
          <a href="<?php echo $category['href']; ?>" title="<?php echo $category['name']; ?>">
            <img width="<?php echo $category_thumb_width; ?>" height="<?php echo $category_thumb_height; ?>" src="<?php echo $category['image']; ?>">
          </a>
        <?php } ?>
        <div>
          <?php echo $category['preview']; ?>
        </div>
      </div>
      <?php } ?>
    <?php } ?>
  </div>
</div>