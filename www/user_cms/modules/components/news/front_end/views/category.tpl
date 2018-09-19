<div id="content" class="content news">   
    <h1><?=$page_header?></h1>
    <?=$breadcrumbs?>
    <?php if (isset($category['text'])) { ?>
    <?=$category['text']?>
    <?php } ?>
    <?php if (!empty($items)) { ?>
        <?php foreach ($items as $item) if ($item['is_category'] == 1) { ?>
            <div class="category-preview">
                <p class="date">Опубликовано: <?=date('d.m.Y H:i', $item['date_publish'])?></p>
                <h2><?=$item['header']?></h2>
                <?=$item['overview']?> <a href="<?=$base_url?>/<?=$item['url']?>">Открыть категорию</a>
            </div>
        <?php } ?>
        <?php foreach ($items as $item) if ($item['is_category'] == 0) { ?>
            <div class="article-preview">
                <p class="date">Опубликовано: <?=date('d.m.Y H:i', $item['date_publish'])?></p>
                <h2><?=$item['header']?></h2>
                <div class="image">
                <?php if (!empty($item['photo'])) { ?>
                    <img src="/uploads/modules/<?=$img_folder?>/mini/<?=$item['photo']?>" alt="<?=$item['header']?>">
                <?php } else { ?>
                    <img src="/user_cms/modules/components/<?=$img_folder?>/no-photo.jpg" alt="нет фото">
                <?php } ?>
                </div>
                <?=$item['overview']?> <a href="<?=$base_url?>/<?=$item['url']?>">Подробнее</a>
            </div>
        <?php } ?>
        <?=$pagination;?>
    <?php } else { ?>
        <p>Здесь пока нет новостей.</p>
    <?php } ?>
</div>
