<div id="content">
    <h1><?=$page_name?></h1>
    <?=$breadcrumbs;?>
    <?php if (isset($errors) && count($errors) > 0): ?>
        <p class="alert alert-danger">
            <?php foreach ($errors as $key => $error): ?>
                <?=$error . ($key != count($errors)-1?'<br>':'');?>        
            <?php endforeach ?>
        </p>
    <?php endif ?>
    <?php if ($success) { ?>
        <p class="alert alert-success">Мы получили ваш запрос. На email, который вы указали в профиле придет письмо с инструкцией для восстановления пароля.</p>
    <?php } else { ?>
        <p>
            Укажите свой адрес почты, который вы вводили при регистрации. <br>
            <!-- <span class="text-danger">Вводите данные внимательно. У вас только ОДНА попытка.</span> -->
        </p>
        <form method="POST">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Ваш e-mail</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" required value="<?=isset($_POST['email'])?$_POST['email']:'';?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Сбросить мой пароль</button>
                </div>
                <!-- <div class="offset-sm-2 col-sm-10 pt-3">Нажимая кнопку &quot;Сбросить мой пароль&quot;, вы даете согласие на обработку ваших персональных данных согласно закону №152-ФЗ.</div> -->
            </div>
        </form>
    <?php } ?>
    
</div>

