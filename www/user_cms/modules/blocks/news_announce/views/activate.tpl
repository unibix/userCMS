<label for="count_news">Количество новостей:</label>
<input id="count_news" type="text" name="count_news" value="5">

<p>Категория:</p>
<input id="cat" type="radio" name="category_id" value="0" checked>
<label for="cat">Все категории</label><br>
<?php foreach($categories as $category) { ?>
<input id="cat" type="radio" name="category_id" value="<?php echo $category['id']; ?>">
<label for="cat"><?php echo $category['name']; ?></label><br>
<?php } ?>
