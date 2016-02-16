<div id="content">
	<h1 id="page_name"><?=$page_name;?></h1>
	<p class="bread_crumbs"><?php echo $bread_crumbs; ?></p>
  <div id="gallery-box">
    <div class="category-info"><?php echo $category['text']; ?></div>


    <?php if($items) { ?>
      <div class="category-items">
        <?php foreach($items as $item) { ?>
        <div>
          <a class="fancybox" rel="gallery" href="<?php echo $item['full']; ?>" title="<?php echo $item['text']; ?>">
            <img width="<?php echo $item_thumb_width; ?>" height="<?php echo $item_thumb_height; ?>" src="<?php echo $item['image']; ?>">
          </a>
        </div>
        <?php } ?>
      </div>
    <?php } ?>
  </div>
  
    <?php if($categories) { ?>
  <div id="gallery-box" class="categories">
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
  	  <div style="clear:both; height:0px; width:0px; margin:0 0 10px 0; padding:0px; "></div>
      <?php } ?>
  </div>
    <?php } ?>

  
</div>