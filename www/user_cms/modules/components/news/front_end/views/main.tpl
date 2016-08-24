<div id="content">
	<h1 id="page_name"><?=$page_name;?></h1>
	<p class="bread_crumbs"><?php echo $bread_crumbs; ?></p>
    <div id="news-box">
        <?php if($news_items) { ?>
            <?php foreach($news_items as $item) { ?>
            <div>
                <h2><a href="<?php echo $item['href']; ?>"><?php echo $item['name']; ?></a></h2>
                <div><?php echo $item['preview']; ?></div>
                <div class="date"><?php echo $item['date']; ?></div>
            </div>
            <?php } ?>
        <?php } ?>
    </div>
    <?php if ($pages_amount > 1) {
        echo '<ul class="pagination">';
            //стрелка влево
            if ($current_page > 1) {
                echo '<li><a href="'.SITE_URL.$base_url.'/page='.($current_page-1).'">&lt;</a></li>';
            } else {
                echo '<li><span>&lt;</span></li>';
            }
            //если много страниц
            if ($pages_amount > 15) {
                //если далеко от начала
                if ($current_page > 6) {
                    $prefix = '<li><a href="'.SITE_URL.$base_url.'/page=1">1</a></li><li><span>...</span></li>';
                    $start = $current_page - 5;
                } else {
                    $prefix = '';
                    $start = 1;
                }
                //если далеко от конца
                if ($current_page < $pages_amount - 5) {
                    $postfix = '<li><span>...</span></li><li><a href="'.SITE_URL.$base_url.'/page='.$pages_amount.'">'.$pages_amount.'</a></li>';
                } else {
                    $postfix = '';
                    $start = $pages_amount - 10;
                }
                echo $prefix;
                for ($i=$start; $i<$start+11; $i++) if ($i == $current_page) {
                    echo '<li class="current"><span>'.$i.'</span></li>';
                } else {
                    echo '<li><a href="'.SITE_URL.$base_url.'/page='.$i.'">'.$i.'</a></li>';
                }
                echo $postfix;
            //если мало страниц
            } else {
                for ($i=1; $i<=$pages_amount; $i++) if ($i == $current_page) {
                    echo '<li class="current"><span>'.$i.'</span></li>';
                } else {
                    echo '<li><a href="'.SITE_URL.$base_url.'/page='.$i.'">'.$i.'</a></li>';
                }
            }
            //стрелка вправо
            if ($current_page < $pages_amount) {
                echo '<li><a href="'.SITE_URL.$base_url.'/page='.($current_page+1).'">&gt;</a></li>';
            } else {
                echo '<li><span>&gt;</span></li>';
            }
        echo '</ul>';
    } ?>
</div>