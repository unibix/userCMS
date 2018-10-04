<div id="content" class="users login">
  <h1><?php echo $page_name; ?></h1>
  <?php echo $breadcrumbs;?>
  <div id="register_form">
    <?php if ($errors) { ?>
    <div class="notice errors">
      <?php foreach ($errors as $error) { ?>
      <?php echo $error; ?><br>
      <?php } ?>
    </div>
    <?php } ?>
    <form method="POST" action="">
      <label>Имя пользователя:</label>
      <input required type="text" name="login" value="<?php echo $login; ?>">
      
      <label>Пароль:</label>
      <input required type="password" name="password" value="">
      
      <?php if ($captcha) { ?>
      <div class="captcha-block">
        <img src="<?php echo $src_captcha; ?>">
        <label>Введите символы с картинки:</label>
        <input required class="captcha" type="text" name="captcha" value="">
      </div>
      <?php } ?>
      
      <div style="text-align: center">
        <input type="submit" name="users_login" value="Войти">
      </div>
    </form>

    <div style="text-align: center; margin-top: 20px;">
        <a href="<?=SITE_URL?>/users/register">Регистрация</a> | <a href="<?=SITE_URL?>/users/password_recovery_request">Восстановление пароля</a>
    </div>
  </div>
</div>