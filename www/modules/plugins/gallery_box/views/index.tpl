<!-- Плагин gallery_box НАЧАЛО -->
<div class="gallery_box">
    <?php if($items) { ?>
    
        <?php foreach($items as $item) { ?>
        
          <a class="fancybox gallery_box_item" rel="chapter" href="<?=SITE_URL . '/uploads/modules/gallery/' . $category_dir . '/' . $item['image']; ?>" title="<?=$item['text']; ?>">
            <img src="<?=SITE_URL . '/uploads/modules/gallery/' . $category_dir . '/mini/' . $item['image']; ?>"  alt="Изображение удалено">
          </a>
       
        <?php } ?>
    <?php } ?>
</div>
<!-- Плагин gallery_box КОНЕЦ  -->
