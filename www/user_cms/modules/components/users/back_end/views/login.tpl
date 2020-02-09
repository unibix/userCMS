<div class="row mt-4" id="content"> 
    <h1 class="col-12 mt-3 mb-4 text-center">Вход</h1>
    <?php if($errors) { ?>
    <div class="col-12 alert alert-danger">
        <?php foreach ($errors as $error) { ?>
            <?php echo $error; ?> <br>
        <?php } ?>
    </div>
    <?php } ?>
    <form class="row" method="post" action="<?php echo SITE_URL . '/admin/users/login' ; ?>">
        <div class="col-12 form-group">
            <label for="username">Логин:</label>
            <input class="form-control" type="text" name="username" value="" placeholder="Например: usermaster" />
        </div>
        <div class="col-12 form-group">
            <label for="password">Пароль:</label>
            <input class="form-control" type="password" name="password" value="" placeholder="Например: 123456" />
        </div>
        <div class="col-12 form-group">
            <input class="btn btn-success" type="submit" name="login" value="Войти" />
        </div>
    </form>
</div>