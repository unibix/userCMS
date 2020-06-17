<!DOCTYPE html>
<html>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   [head]
   
</head>
<body>
	<div id="wrapper" class="container-fluid special-border  p-0 position-relative">
		<div class="row no-gutters">
			<div class="col left-side">
				<div class="row no-gutters">
					<div class="col-12 pt-3" id="logo">
						<div class="row no-gutters px-md-3 pb-3 text-center">
							<h5 class="col-12 px-md-3">
								<a href="<?php echo SITE_URL; ?>/admin">User<span>CMS</span></a>
							</h5>
							<p class="col-12 text-white  font-weight-bold"><?php echo $this->config['site_name']; ?></p>
							<div class="btn d-lg-none close-open-menu col-12" data-toggle="collapse" data-target="#close_menu" aria-expanded="false" aria-controls="collapseExample">
								Открыть меню
							</div>
						</div>
					</div>
					<div id="close_menu" class="col-12 collapse show">
						<div class="text-lg-left text-center" id="menu">
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
				<div class="row no-gutters">
					<div class="col">[position=left_menu]</div>
					<!-- end #header -->
					<div class="col-12">
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
				<a href="http://usercms.ru" target="_blank">User CMS <?php echo USER_CMS_VERSION; ?> Сборка <?php echo USER_CMS_EDITION; ?></a> © 2010-2013. 
			</p>
		</div>
	</div>

<script>
function confirmDelete() {
		if (confirm("Вы уверены?")) {
			return true;
		} else {
			return false;
		}
}
$(".confirmButton").click(function(){
	return confirmDelete();
});

$(document).ready(function () {            

	if($(document).width() <= 992) {
		$('#close_menu.collapse').removeClass('show');
	} else {
		$('#close_menu.collapse').addClass('show');
	}

	$(window).resize(function() {
		if($(document).width() <= 992) {
			$('#close_menu.collapse').removeClass('show');
		} else {
			$('#close_menu.collapse').addClass('show');
		}
	});

});  
</script>
<script src="<?=SITE_URL;?>/user_cms/themes/default_admin/bootstrap/bootstrap.min.js"></script>
<script src="<?=SITE_URL;?>/user_cms/themes/default_admin/bootstrap/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
