<!DOCTYPE html>
<html lang="zxx">
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   [head]
   
</head>
<body>
	<div id="wrapper" class="container-fluid special-border  p-0 position-relative">
		<div class="row no-gutters">
			<div class="col left-side">
				<div class="row no-gutters">
					<div class="col-12 pt-1" id="logo">
						<div class="row no-gutters px-md-3 pb-1 text-center">
							<div class="header-menu">
								<h5 class="px-md-3">
									<a href="<?php echo SITE_URL; ?>/admin">User<span>CMS</span></a>
								</h5>
								<div role="navigation" class="btn close-open-menu" data-toggle="collapse" data-target="#close_menu" aria-expanded="false" >
									<div class="burger-btn">
										<span></span>
										<span></span>
										<span></span>
									</div>
								</div>
							</div>
							<p class="col-12 text-white  font-weight-bold"><?php echo $this->config['site_name']; ?></p>
						</div>
					</div>
					<div id="close_menu" class="col-12 collapse show">
						<div class="text-lg-left text-center" id="aside">
							[position=main_menu]
						</div>
						<div class="usefull-btns mt-5 mb-3 no-gutters row">
							<div class="col text-lg-left text-center">
								<ul>
									<li>
										<a href="<?=SITE_URL?>/admin/users" >Добро пожаловать, <?php echo $_SESSION['login']; ?></a>
									</li>
									<li>
										<a href="<?=SITE_URL?>/admin/users/logout" >Выйти</a>
									</li>
									<li>
										<a href="<?=SITE_URL?>" target="_blank">Перейти на сайт</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg right-side">
				<div class="row h-100 no-gutters">
					<div class="col">[position=left_menu]</div>
					<!-- end #header -->
					<div class="col-12 component-block">
						<div class="additional-menu-btn">Доп. Меню</div>
						[component]
					</div>
					<!-- end #page --> 
				</div>
				  <!-- end #footer -->
			</div>
		</div>
		<div id="footer">
			<p>
				<a href="<?php echo SITE_URL ; ?>/admin/update" >Обновить</a> /
				<a href="<?php echo SITE_URL ; ?>/admin/backup" >Бэкап</a> /
				<a href="http://usercms.ru/forum" target="_blank">Оф. форум</a> /
				<a href="http://usercms.ru/documentation" target="_blank">Оф. документация</a> /
				<a href="http://usercms.ru" target="_blank">User CMS <?php echo USER_CMS_VERSION; ?> Сборка <?php echo USER_CMS_EDITION; ?></a> © 2010-<?=date('Y')?>. 
			</p>
		</div>
	</div>
<script src="<?=SITE_URL;?>/user_cms/themes/default_admin/bootstrap/bootstrap.min.js"></script>
<script src="<?=SITE_URL;?>/user_cms/themes/default_admin/bootstrap/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
