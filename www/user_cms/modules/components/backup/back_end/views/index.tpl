<div id="content">
  <h1 class="page_name">Резервное копирование</h1>
  <?php if (isset($errors) && !empty($errors)) { ?>
  <div class="notice error">
    <?php foreach ($errors as $error) { ?>
    <p><?php echo $error; ?></p>
    <?php } ?>
  </div>
  <?php } ?>
  <?php if (isset($success) && !empty($success)) { ?>
  <div class="notice success">
    <?php foreach ($success as $msg) { ?>
    <?php echo $msg; ?><br>
    <?php } ?>
  </div>
  <?php } ?>
  <p class="buttons">
    <a class="button" href="<?php echo $create_backup; ?>">Создать бэкап</a>
    <a class="button" href="<?php echo $restore_backup; ?>">Восстановить</a>
  </p>
  <table class="main">
    <tr>
      <th>Файл</th>
      <th>Размер</th>
      <th>Дата создания</th>
      <th>Действия</th>
    </tr>
    <?php foreach ($backups as $backup) { ?>
    <tr>
      <td><?php echo $backup['name']; ?></td>
      <td><?php echo $backup['size']; ?> мб</td>
      <td><?php echo $backup['date']; ?></td>
      <td>
        <a href="<?php echo $backup['href_download']; ?>">скачать</a> |
        <a href="<?php echo $backup['href_restore']; ?>">восстановить</a> |
        <a href="<?php echo $backup['href_delete']; ?>">удалить</a>
      </td>
    </tr>
    <?php } ?>
  </table>
</div>