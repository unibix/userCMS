<div id="news_announce_settings">
  <div>
    <label>Количество новостей:</label>
    <input type="text" name="count_news" value="<?php echo $count_news; ?>">
    <label>Категория:</label>
    <input type="text" name="category_id" value="<?php echo $category_id; ?>">
    <label>Отображать краткую новость:</label><br>
    <input type="radio" name="show_preview" value="1" <?php if ($show_preview) { ?>checked<?php } ?>> Да<br>
    <input type="radio" name="show_preview" value="0" <?php if (!$show_preview) { ?>checked<?php } ?>> Нет<br>
    <label>Отобразить ссылки "Посмотреть все новости":</label><br>
    <input type="radio" name="show_link_all_news" value="1" <?php if ($show_link_all_news) { ?>checked<?php } ?>> Да<br>
    <input type="radio" name="show_link_all_news" value="0" <?php if (!$show_link_all_news) { ?>checked<?php } ?>> Нет<br>
  </div>
</div>