<div class="news_announce">
<?php foreach ($items as $item) { ?>
    <div class="article-preview">
        <p class="date">Опубликовано: <?=date('d.m.Y H:i', $item['date_publish'])?></p>
        <h2><?=$item['header']?></h2>
        <?php if ($params['show_photo']) { ?>
            <div class="image">
            <?php if (!empty($item['photo'])) { ?>
                <img src="/uploads/modules/<?=$img_folder?>/mini/<?=$item['photo']?>">
            <?php } else { ?>
                <img src="/user_cms/modules/components/<?=$img_folder?>/no-photo.jpg">
            <?php } ?>
            </div>
        <?php } ?>
        <?php if ($params['show_overview']) echo $item['overview']?>
        <a href="<?=$item['url']?>">Подробнее</a>
    </div>
<?php } ?>
<?php if ($params['show_all_news_link']) echo '<a href="'.SITE_URL.'/'.$component_url.'">Все новости</a>'?>
</div>
