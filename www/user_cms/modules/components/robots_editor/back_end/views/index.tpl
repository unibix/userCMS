<div id="content">
<h1 id="page_name"><?php echo $page_name; ?></h1>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php if ($robots !== false) { ?>
<form method="POST" action="">
<textarea class="code-editor" id="code_editor" style="min-heigth: 900px;" rows="50" name="robots_content"><?php echo $robots; ?></textarea>
<input type="submit" name="edit_robots" value="Сохранить изменения">
</form>
<?php } else { ?>
  Файл robots.txt не доступен для чтения
<?php } ?>
</div>