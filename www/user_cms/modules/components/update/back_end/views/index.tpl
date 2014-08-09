<h1 id="page_name">Обновление User CMS</h1>
<?php if(isset($message)) { ?> <div class="success"><?php echo $message; ?></div><?php } ?>
<?php if(isset($error)) { ?> <div class="error"><?php echo $error; ?></div><?php } ?>

<form action="" method="post" enctype="multipart/form-data">

<label for="archive">Выберите архив для обновления</label>
<input type="file" name="archive">

<input type="submit" name="update_core" value="Обновить">

</form>