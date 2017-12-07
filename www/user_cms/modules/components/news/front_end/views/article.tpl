<div id="content" class="content news item">
    
    <p class="date">Опубликовано: <?=date('d.m.Y H:i', $article['date_publish'])?></p>
    <h1><?=$page_header?></h1>
    <p class="breadcrumbs">
        <?php
        $links = array(); 
        foreach ($breadcrumbs['labels'] as $n => $label) $links[] = '<a href="'.$breadcrumbs['hrefs'][$n].'">'.$label.'</a>';
        echo implode(' / ', $links);
        ?>
    </p>
    <p class="image">
    <?php if (!empty($article['photo'])) { ?>
        <img src="<?=SITE_URL;?>/uploads/modules/<?=$img_folder?>/<?=$article['photo']?>">
    <?php } else { ?>
        <img src="<?=SITE_URL;?>/user_cms/modules/components/<?=$img_folder?>/no-photo.jpg">
    <?php } ?>
    </p>
    <div class="article">
        <?=$article['text']?>
    </div>
</div>
