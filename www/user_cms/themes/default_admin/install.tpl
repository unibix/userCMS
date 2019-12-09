<!DOCTYPE html>
<html>
<head>
    <title>Админ панель</title>
    <meta charset="utf-8" />
    <link href="user_cms/themes/default_admin/css/style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>

<div id="wrapper">
<div id="wrapper_login">
    <div id="content"> 
        <h1 id="pagename">Установка UserCMS 2</h1>
        <form method="post" action="">
            <label for="login">Название сайта:</label><br>
            <input type="text" name="site_name" value="<?php echo $config['site_name'] ; ?>" placeholder="Например: usermaster" />
            <label for="password">URL сайта:</label><br>
            <input type="text" name="site_url" value="<?php echo $config['site_url'] ; ?>" placeholder="Например: http://www.usercms.ru" />
            <label for="login">Логин администратора:</label><br>
            <input type="text" name="login" value="<?php echo $config['login'] ; ?>"  />
            <label for="password">Пароль администратора:</label><br>
            <input type="password" name="password" value="<?php echo $config['password'] ; ?>"  />
            <label for="demo">Установить демоданные</label>
            <input id="demo" type="checkbox" name="demo_data" value="1"><br>
            <input type="submit" name="form_install" value="Установить" /><br>
        </form>
    </div>
</div><!-- end #wrapper_login -->
<div id="wrapper">

<div id="footer">
    <p>
        <a href="http://usercms.ru/forum" target="_blank">Оф. форум</a> /
        <a href="http://usercms.ru/documentation" target="_blank">Оф. документация</a> /
    </p>
</div><!-- end #footer -->


</body>
</html>
