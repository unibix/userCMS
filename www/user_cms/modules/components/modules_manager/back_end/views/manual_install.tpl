<div id="content">
  <h1>Ручная установка</h1>
  <?=$breadcrumbs;?>
  <form action="" method="POST">
  <label>Название</label>
  <input type="text" name="name" value="">
  
  <label>Тип</label>
  <select name="type">
    <?php foreach ($module_types as $type) { ?>
    <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
    <?php } ?>
  </select>
  
  <label>Папка</label>
  <input type="text" name="dir">
  
  <label>Версия</label>
  <input type="text" name="version" value="1.0">
  
  <label>Описание</label>
  <input type="text" name="description" value="">
  
  <input type="submit" name="install" value="Установить">
</div>