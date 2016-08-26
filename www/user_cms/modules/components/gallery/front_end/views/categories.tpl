<div id="content">
    <h1 id="page_name"><?=$page_name;?></h1>
    <p class="bread_crumbs"><?=$bread_crumbs?></p>
    <div id="gallery-box">
        <?php if ($categories) foreach ($categories as $category) {?>
        <div class="item-box">
            <a href="<?=$category['href']?>" title="<?=$category['name']?>">
                <?php if (empty($category['image'])) $category['image'] = SITE_URL.'/user_cms/modules/components/gallery/front_end/views/no-photo.png'?> 
                <img width="<?=$category_thumb_width?>" height="<?=$category_thumb_height?>" src="<?=$category['image']?>">
                <div class="category-name"><?=$category['name']?></div>
                <div class="category-preview" style="width:<?=$category_thumb_width?>px"><?=$category['preview']?></div>
            </a>
        </div>
        <?php } ?>
    </div>
</div>