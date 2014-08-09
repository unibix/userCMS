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
</div>