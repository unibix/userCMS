<style>
    #wrapper label {
        display: block;
        box-sizing: border-box;
    }
    input, textarea, select {
        box-sizing: border-box;
    }
    #wrapper select {
        width: 100%;
    }
</style>

<div id="content">
    <h1><?=$page_header?></h1><br>
    <?=$breadcrumbs;?>  
    <p class="buttons"><a class="button" href="<?=$back_url?>">Назад</a></p>
    <?php
    if (isset($new_item_url)) {
        if (!empty($front_end_component_url)) echo '
        <div class="notice success">
            <p>Сохранено. Посмотреть на сайте: <a href="'.SITE_URL.'/'.$front_end_component_url.$new_item_url.'">'.SITE_URL.'/'.$front_end_component_url.$new_item_url.'</a></p>
        </div>';
        else echo '
        <div class="notice success">
            <p>Сохранено. Активируйте компонент чтобы посетители сайта смогли увидеть ваши публикации.</a></p>
        </div>';
    }
    if (!empty($errors)) echo '
        <div class="notice error">
            <p>'.implode('<br>', $errors).'</p>
        </div>';
    ?> 
    <div id="add_tabs" class="tabs">
        <ul>
            <li><a class="tab_main active">Основное</a></li>
            <li><a class="tab_seo">SEO</a></li>
        </ul>
    </div>
    <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST" enctype="multipart/form-data">
        <div id="tabs_content">
            <div id="tab_main" style="display: block;">
                <label>
                    Заголовок<br>
                    <input type="text" name="item[header]" value="<?=$item['header']?>">
                </label>
                <?php if ($item['is_category'] == 0) { ?>
                <label>
                    Главное фото. <?php if (!empty($item['photo'])) { ?><label><input type="checkbox" name="remove_photo"> Удалить фото</label><?php } ?><br>
                    <input type="file" name="photo">
                </label>
                <?php } ?>
                <label>
                    Краткий обзор<br>
                    <textarea name="item[overview]"><?=$item['overview']?></textarea>
                </label>
                <label>
                    Текст<br>
                    <textarea class="wysiwyg" name="item[text]" rows="40"><?=$item['text']?></textarea>
                </label>
                <label>
                    Дата публикации (до этой даты посетители сайта не будут видеть эту информацию)<br>
                    <input type="text" name="item[date_publish]" value="<?=date('d.m.Y H:i', $item['date_publish'])?>">
                </label>
                <label>
                    Поместить в категорию<br>
                    <select name="item[parent_id]">
                    <?php foreach ($available_parents as $parent) {
                        echo '<option';
                        if ($parent['id'] == $item['parent_id']) echo ' selected';
                        echo ' value="'.$parent['id'].'">'.$parent['header'].'</option>';
                    } ?>
                    </select>
                </label>
            </div>
            <div id="tab_seo">
                <label>
                    URL (не должен совпадать с уже имеющимися URL в этой категории)<br>
                    <input type="text" name="item[url]" value="<?=$item['url']?>">
                </label>
                <label>
                    Title<br>
                    <input type="text" name="item[title]" value="<?=$item['title']?>">
                </label>
                <label>
                    Keywords<br>
                    <input type="text" name="item[keywords]" value="<?=$item['keywords']?>">
                </label>
                <label>
                    Description<br>
                    <input type="text" name="item[description]" value="<?=$item['description']?>">
                </label>
            </div>
        </div>
        <p class="buttons">
            <input type="hidden" name="back_url" value="<?=$back_url?>">
            <input type="hidden" name="item[id]" value="<?=$item['id']?>">
            <input type="submit" name="save" value="Сохранить">
        </p>
    </form>
</div>