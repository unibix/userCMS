<?php
echo '<ul class="pagination">';
    //стрелка влево
    if ($current_page > 1) {
        echo '<li><a href="'.sprintf($url_template, ($current_page-1)).'">&lt;</a></li>';
    } else {
        echo '<li><span>&lt;</span></li>';
    }
    //если много страниц
    if ($pages_amount > 15) {
        //если далеко от начала
        if ($current_page > 6) {
            $prefix = '<li><a href="'.sprintf($url_template, 1).'">1</a></li><li><span>...</span></li>';
            $start = $current_page - 5;
        } else {
            $prefix = '';
            $start = 1;
        }
        //если далеко от конца
        if ($current_page < $pages_amount - 5) {
            $postfix = '<li><span>...</span></li><li><a href="'.sprintf($url_template, $pages_amount).'">'.$pages_amount.'</a></li>';
        } else {
            $postfix = '';
            $start = $pages_amount - 10;
        }
        echo $prefix;
        for ($i=$start; $i<$start+11; $i++) if ($i == $current_page) {
            echo '<li class="current"><span>'.$i.'</span></li>';
        } else {
            echo '<li><a href="'.sprintf($url_template, $i).'">'.$i.'</a></li>';
        }
        echo $postfix;
    //если мало страниц
    } else {
        for ($i=1; $i<=$pages_amount; $i++) if ($i == $current_page) {
            echo '<li class="current"><span>'.$i.'</span></li>';
        } else {
            echo '<li><a href="'.sprintf($url_template, $i).'">'.$i.'</a></li>';
        }
    }
    //стрелка вправо
    if ($current_page < $pages_amount) {
        echo '<li><a href="'.sprintf($url_template, ($current_page+1)).'">&gt;</a></li>';
    } else {
        echo '<li><span>&gt;</span></li>';
    }
echo '</ul>';