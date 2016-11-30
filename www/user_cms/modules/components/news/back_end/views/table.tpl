<div id="content">    
    <h1><?=$page_header?></h1><br>
    <p class="buttons">
        <?php if ($upper_url != '') { ?>
            <a class="button" href="<?=$upper_url?>" title="Перейти в родительскую категорию"><i class="fa fa-lg fa-level-up"></i></a>
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
                        if ($is_asc) echo '<i class="fa fa-sort-numeric-asc"></i>';
                        else echo '<i class="fa fa-sort-numeric-desc"></i>';
                    } ?>
                </th>
                <th>
                    <a href="<?=$base_url?>/do=order/order_by=is_category">Тип</a>
                    <?php if ($order_by == 'is_category') {
                        if ($is_asc) echo '<i class="fa fa-sort-amount-asc"></i>';
                        else echo '<i class="fa fa-sort-amount-desc"></i>';
                    } ?>
                </th>
                <th>
                    <a href="<?=$base_url?>/do=order/order_by=header">Заголовок</a>
                    <?php if ($order_by == 'header') {
                        if ($is_asc) echo '<i class="fa fa-sort-alpha-asc"></i>';
                        else echo '<i class="fa fa-sort-alpha-desc"></i>';
                    } ?>
                </th>
                <th>Фото</th>
                <th>
                    <a href="<?=$base_url?>/do=order/order_by=url">URL</a>
                    <?php if ($order_by == 'url') {
                        if ($is_asc) echo '<i class="fa fa-sort-alpha-asc"></i>';
                        else echo '<i class="fa fa-sort-alpha-desc"></i>';
                    } ?>
                </th>
                <th>
                    <a href="<?=$base_url?>/do=order/order_by=date_create">Создана</a>
                    <?php if ($order_by == 'date_create') {
                        if ($is_asc) echo '<i class="fa fa-sort-numeric-asc"></i>';
                        else echo '<i class="fa fa-sort-numeric-desc"></i>';
                    } ?>
                </th>
                <th>
                    <a href="<?=$base_url?>/do=order/order_by=date_edit">Изменена</a>
                    <?php if ($order_by == 'date_edit') {
                        if ($is_asc) echo '<i class="fa fa-sort-numeric-asc"></i>';
                        else echo '<i class="fa fa-sort-numeric-desc"></i>';
                    } ?>
                </th>
                <th>
                    <a href="<?=$base_url?>/do=order/order_by=date_publish">Опубликована</a>
                    <?php if ($order_by == 'date_publish') {
                        if ($is_asc) echo '<i class="fa fa-sort-numeric-asc"></i>';
                        else echo '<i class="fa fa-sort-numeric-desc"></i>';
                    } ?>
                </th>
                <th></th>
            </tr>
            <?php foreach ($items as $item) { ?>
                <tr>
                    <td><?=$item['id']?></td>

                    <?php if ($item['is_category'] == 1) { ?>
                        <td style="text-align:center;color:#DBBE3B"><i class="fa fa-2x fa-folder-open"></i></td>
                        <td><b><a href="<?=$base_url?>/<?=$item['url']?>"><?=$item['header']?></a></b></td>
                        <td></td>
                    <?php } else { ?>
                        <td style="text-align:center;color:#888"><i class="fa fa-2x fa-file-text-o"></i></td>
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

                    <td><?=$item['url']?></td>
                    <td><?=date('d.m.Y H:i', $item['date_create'])?></td>
                    <td><?=date('d.m.Y H:i', $item['date_edit'])?></td>
                    <td><?=date('d.m.Y H:i', $item['date_publish'])?></td>
                    <td style="text-align:center">
                        <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
                            <?php if ($item['is_category'] == 1) { ?>
                                <button title="Удалить" type="submit" class="link" name="delete_category" value="<?=$item['id']?>" onclick="return confirm('Удалить категорию?')"><i class="fa fa-lg fa-times" style="color:#c00"></i></button>
                                <a title="Редактировать" href="<?=$base_url?>/<?=$item['url']?>/do=edit"><i class="fa fa-lg fa-pencil-square-o"></i></a>
                            <?php } else { ?>
                                <button title="Удалить" type="submit" class="link" name="delete_article" value="<?=$item['id']?>" onclick="return confirm('Удалить новость?')"><i class="fa fa-lg fa-times" style="color:#c00"></i></button>
                                <a title="Редактировать" href="<?=$base_url?>/<?=$item['url']?>"><i class="fa fa-lg fa-pencil-square-o"></i></a>
                            <?php } ?>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?php if ($pages_count > 1) echo '{plugin:pagination='.$current_page.','.$pages_count.','.$base_url.'/page=%u}'?>
    <?php } else { ?>
        <p>Категория пуста</p>
    <?php } ?>
</div>