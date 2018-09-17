<div id="content" class="settings">
  <h1 id="page_name"><?php echo $page_name; ?></h1>
  <?=$breadcrumbs;?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <?php if ($config) { ?>
  <form method="POST" action="">
    <?php foreach ($config as $key => $data) { ?>
    <div>
      <label><?php echo $data['name']; ?></label><br>
      <input type="text" name="<?php echo $key; ?>" value="<?php echo $data['value']; ?>">
    </div>
    <?php } ?>
    <input type="submit" name="edit_settings" value="Сохранить">
  </form>
  <div class="help-message">
    1 - да, 0 - нет
  </div>
  <?php } else { ?>
  <p>Настройки не требуются</p>
  <?php } ?>
</div>