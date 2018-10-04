<h1>Сброс пароля</h1>

<?php if (isset($errors) && count($errors) > 0): ?>
    <p class="alert alert-danger">
        <?php foreach ($errors as $key => $error): ?>
            <?=$error . ($key != count($errors)-1?'<br>':'');?>        
        <?php endforeach ?>
    </p>
<?php endif ?>
<?php if ($success) { ?>
    <p class="alert alert-success">Ваш пароль успешно изменен. На email, который вы указали в профиле придет письмо с новым паролем.</p>
<?php } else { ?>
    <form method="POST">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Введите новый пароль</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Повторите пароль</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password2" required>
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
