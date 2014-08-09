<div id="content">
  <?php if($success) { ?>
  <div class="notice success">
    <?php foreach($success as $msg) { ?>
    <?php echo $msg; ?><br>
    <?php } ?>
  </div>
  <?php } ?>
  <?php if($errors) { ?>
  <div class="notice error">
    <?php foreach($errors as $error) { ?>
    <?php echo $error; ?><br>
    <?php } ?>
  </div>
  <?php } ?>
  <form method="post" action="" enctype="multipart/form-data">
    <label>Выберите архив(.zip) для загрузки:</label>
    <input type="file" name="theme">
    <input type="submit" name="upload_theme" value="Загрузить">
  </form>
</div>