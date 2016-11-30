<div id="news_announce_settings">
    <div>
        <label>Количество новостей:</label>
        <input type="text" name="count_news" value="<?=$params['count_news']?>">

        <label>Категория:</label><br>
        <select name="category_id">
        <?php foreach ($categories as $category) {
            echo '<option';
            if ($category['id'] == $params['category_id']) echo ' selected';
            echo ' value="'.$category['id'].'">'.$category['header'].'</option>';
        } ?>
        </select>

        <label><input type="checkbox" name="show_overview" <?=$params['show_overview'] ? 'checked' : ''?>>Отображать краткую новость</label><br>
        <label><input type="checkbox" name="show_photo" <?=$params['show_photo'] ? 'checked' : ''?>>Отображать фото</label><br>
        <label><input type="checkbox" name="show_all_news_link" <?=$params['show_all_news_link'] ? 'checked' : ''?>>Отображать ссылку на все новости</label><br>
    </div>
</div>