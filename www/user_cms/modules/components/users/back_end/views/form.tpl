<div id="content">
	<h1 id="page_name"><?php echo $page_name ; ?></h1>
	<?php if($user) { ?>
	<?php if($errors) { ?>
	<div class="notice error">
		<?php foreach($errors as $error) { ?>
		<p><?php echo $error; ?></p>
		<?php } ?>
	</div>
	<?php } ?>
	<form method="post" action="">
		<label for="login">Имя пользователя:</label><br>
		<input type="text" name="login" value="<?php echo $user['login']; ?>" >
		
		<label for="password">Пароль:</label><br>
		<input type="text" name="password" value="">
		
		<label for="email">E-mail</label><br>
		<input type="text" name="email" value="<?php echo $user['email']; ?>" >
		
		<label for="email">Admin</label>
		<input type="checkbox" name="access_level" <?php if($user['access_level'] > 0) { ?> checked <?php } ?> >
		
		<input type="submit" value="<?php echo $text_submit; ?>" name="<?php echo $name_submit; ?>">
	<form>
	<?php } ?>
</div>