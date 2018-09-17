<div id="content">
    <h1 id="page_name"><?=$page_name;?></h1>
    <?=$breadcrumbs;?>
    <div id="gallery-box">
        <div class="category-info"><?=$category['text']?></div>
        <?php if ($items) foreach ($items as $item) {?>
        <div class="item-box">
            <a class="fancybox" rel="gallery" href="<?=$item['full']?>" title="<?=$item['text']?>">
                <img width="<?=$item_thumb_width?>" height="<?=$item_thumb_height?>" src="<?=$item['image']?>">
            </a>
        </div>
        <?php } ?>
        <div class="item-separator"></div>
        <?php if ($categories) foreach ($categories as $category) {?>
        <div class="item-box">
            <a href="<?=$category['href']?>" title="<?=$category['name']?>">
                <?php if ($category['image']) {?>
                <img width="<?=$category_thumb_width?>" height="<?=$category_thumb_height?>" src="<?=$category['image']?>">
                <div class="category-name"><?=$category['name']?></div>
                <?php } ?>
                <div class="category-preview" style="width:<?=$category_thumb_width?>px"><?=$category['preview']?></div>
            </a>
        </div>
        <?php } ?>
    </div>
</div>