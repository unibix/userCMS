<style>
    .symbol {
        font-size: 20px;
        text-decoration: none;
    }
</style>
<?php
$base_url_public = str_replace('/admin','',$base_url);
?>
<div id="content">    
    <h1><?=$page_header?></h1><br>
    <?=$breadcrumbs;?>
    <p class="buttons">
        <?php if ($upper_url != '') { ?>
            <a class="button" href="<?=$upper_url?>" title="Перейти в родительскую категорию"><span class="symbol">&larr;</span></a>
        <?php } ?>
        <a class="button" href="<?=$base_url?>/do=add_category">Добавить категорию</a>
        <a class="button" href="<?=$base_url?>/do=add_article">Добавить новость</a>
    </p>
    <?php if (!empty($items)) { ?>
        <table class="main">
            <tr>
                <th>
                    <a href="<?=$base_url?>/do=order/order_by=id">ID</a>
                    <?php if ($order_by == 'id') {
                        if ($is_asc) echo '<span class="symbol">&uarr;</span>';
                        else echo '<span class="symbol">&darr;</span>';
                    } ?>
                </th>
                <th>
                    <a href="<?=$base_url?>/do=order/order_by=is_category">Тип</a>
                    <?php if ($order_by == 'is_category') {
                        if ($is_asc) echo '<span class="symbol">&uarr;</span>';
                        else echo '<span class="symbol">&darr;</span>';
                    } ?>
                </th>
                <th>
                    <a href="<?=$base_url?>/do=order/order_by=header">Заголовок</a>
                    <?php if ($order_by == 'header') {
                        if ($is_asc) echo '<span class="symbol">&uarr;</span>';
                        else echo '<span class="symbol">&darr;</span>';
                    } ?>
                </th>
                <th>Фото</th>
                <th>
                    <a href="<?=$base_url?>/do=order/order_by=url">URL</a>
                    <?php if ($order_by == 'url') {
                        if ($is_asc) echo '<span class="symbol">&uarr;</span>';
                        else echo '<span class="symbol">&darr;</span>';
                    } ?>
                </th>
                <th>
                    <a href="<?=$base_url?>/do=order/order_by=date_create">Создана</a>
                    <?php if ($order_by == 'date_create') {
                        if ($is_asc) echo '<span class="symbol">&uarr;</span>';
                        else echo '<span class="symbol">&darr;</span>';
                    } ?>
                </th>
                <th>
                    <a href="<?=$base_url?>/do=order/order_by=date_edit">Изменена</a>
                    <?php if ($order_by == 'date_edit') {
                        if ($is_asc) echo '<span class="symbol">&uarr;</span>';
                        else echo '<span class="symbol">&darr;</span>';
                    } ?>
                </th>
                <th>
                    <a href="<?=$base_url?>/do=order/order_by=date_publish">Опубликована</a>
                    <?php if ($order_by == 'date_publish') {
                        if ($is_asc) echo '<span class="symbol">&uarr;</span>';
                        else echo '<span class="symbol">&darr;</span>';
                    } ?>
                </th>
                <th></th>
            </tr>
            <?php foreach ($items as $item) { ?>
                <tr>
                    <td><?=$item['id']?></td>

                    <?php if ($item['is_category'] == 1) { ?>
                        <td>Категория</td>
                        <td><b><a href="<?=$base_url?>/<?=$item['url']?>"><?=$item['header']?></a></b></td>
                        <td></td>
                    <?php } else { ?>
                        <td>Статья</td>
                        <td><?=$item['header']?></td>
                        <?php if (!empty($item['photo'])) { ?>
                        <td style="
                            background-image:url('/uploads/modules/<?=$component?>/mini/<?=$item['photo']?>');
                            background-size: cover;
                            background-position: center center;
                        "></td>
                        <?php } else { ?>
                        <td style="
                            background-image:url('/user_cms/modules/components/<?=$component?>/no-photo.jpg');
                            background-size: cover;
                            background-position: center center;
                        "></td>
                        <?php } ?>
                    <?php } ?>

                    <td><a href="<?=$base_url_public?>/<?=$item['url']?>" target="_blank" title="Посмотреть" ><?=$item['url']?></a></td>
                    <td><?=date('d.m.Y H:i', $item['date_create'])?></td>
                    <td><?=date('d.m.Y H:i', $item['date_edit'])?></td>
                    <td><?=date('d.m.Y H:i', $item['date_publish'])?></td>
                    <td style="text-align:center">
                        <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
                            <?php if ($item['is_category'] == 1) { ?>
                                <button title="Удалить" type="submit" class="link" name="delete_category" value="<?=$item['id']?>" onclick="return confirm('Удалить категорию?')"><span class="symbol" style="color:#c00">&#10008;</span></button>
                                <a title="Редактировать" href="<?=$base_url?>/<?=$item['url']?>/do=edit"><span class="symbol">&#10000;</span></a>
                            <?php } else { ?>
                                <button title="Удалить" type="submit" class="link" name="delete_article" value="<?=$item['id']?>" onclick="return confirm('Удалить новость?')"><span class="symbol" style="color:#c00">&#10008;</span></button>
                                <a title="Редактировать" href="<?=$base_url?>/<?=$item['url']?>"><span class="symbol">&#10000;</span></a>
                            <?php } ?>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?=$pagination;?>
    <?php } else { ?>
        <p>Категория пуста</p>
    <?php } ?>
</div>
