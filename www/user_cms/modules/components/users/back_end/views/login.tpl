    <div id="content"> 
        <h1 id="pagename">Вход</h1>
		<?php if($errors) { ?>
		<div class="notice error">
			<?php foreach ($errors as $error) { ?>
				<?php echo $error; ?> <br>
			<?php } ?>
		</div>
		<?php } ?>
        <form method="post" action="<?php echo SITE_URL . '/admin/users/login' ; ?>">
            <label for="username">Логин:</label><br>
            <input type="text" name="username" value="" placeholder="Например: usermaster" />
            <label for="password">Пароль:</label><br>
            <input type="password" name="password" value="" placeholder="Например: dgbfdghcxhgchfg" />
            <input type="submit" name="login" value="Войти" /><br>
        </form>
    </div>