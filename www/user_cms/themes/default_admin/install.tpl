<!DOCTYPE html>
<html>
<head>
    <title>Админ панель</title>
    <meta charset="utf-8" />
    <link href="user_cms/themes/default_admin/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="user_cms/themes/default_admin/css/install.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>

<div class="container">
    <div class="row">
        <div id="content" class="col-md-6 my-4 offset-md-3 col-10 offset-1">
            <div class="col">
                <h1 class="text-center mb-4">Установка UserCMS 2</h1>
            </div>
            <form class="row " method="post" action="">
                <div class="form-group col-12">
                    <label for="login">Название сайта:</label>
                    <input class="form-control" type="text" name="site_name" value="<?php echo $config['site_name'] ; ?>" placeholder="Например: usermaster" />
                </div>
                <div class="form-group col-12">
                    <label>Протокол сайта:</label>
                    <label>http <input checked type="radio" name="protocol" value="http"></label>
                    <label>https <input type="radio" name="protocol" value="https"></label>
                </div>
                <div class="form-group col-12">
                    <label for="password">URL сайта:</label>
                    <input class="form-control" type="text" name="site_url" value="<?php echo $config['site_url'] ; ?>" placeholder="Например: http://www.usercms.ru" />
                </div>
                <div class="form-group col-12">
                    <label for="login">Логин администратора:</label>
                    <input class="form-control" type="text" name="login" value="<?php echo $config['login'] ; ?>"  />    
                </div>
                <div class="form-group col-12">
                    <label for="password">Пароль администратора:</label>
                    <input class="form-control" type="password" name="password" value="<?php echo $config['password'] ; ?>"  /> 
                </div>
                <div class="form-group col-12">
                    <label for="demo">Установить демоданные</label>
                    <input id="demo" type="checkbox" name="demo_data" value="1">
                </div>
                <div class="form-group col-12">
                    <input class="btn btn-success" type="submit" name="form_install" value="Установить" />
                </div>
            </form>
        </div>
    </div>
</div>

<div id="footer">
    <p>
        <a href="http://usercms.ru/forum" target="_blank">Оф. форум</a> /
        <a href="http://usercms.ru/documentation" target="_blank">Оф. документация</a> /
    </p>
</div><!-- end #footer -->

<script>

</script>
</body>
</html>
