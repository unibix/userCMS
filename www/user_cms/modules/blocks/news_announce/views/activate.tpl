<label for="count_news">Количество новостей:</label>
<input id="count_news" type="text" name="count_news" value="5">

<p>Категория:</p>
<input id="cat" type="radio" name="category_id" value="0" checked>
<label for="cat">Все категории</label><br>
<?php foreach($categories as $category) { ?>
<input id="cat" type="radio" name="category_id" value="<?php echo $category['id']; ?>">
<label for="cat"><?php echo $category['name']; ?></label><br>
<?php } ?>

    <label>Отображать краткую новость:</label><br>
    <input type="radio" name="show_preview" value="1" checked> Да<br>
    <input type="radio" name="show_preview" value="0"> Нет<br>
    <label>Отобразить ссылки "Посмотреть все новости":</label><br>
    <input type="radio" name="show_link_all_news" value="1" > Да<br>
    <input type="radio" name="show_link_all_news" value="0" checked> Нет<br>