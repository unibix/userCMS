<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  [head]
</head>
    <body>
		<div id="bg">
			<div id="outer">
				<div id="header">
                  	[position=hello]
					<div id="logo">
						<h1>
							<a href="<?php echo SITE_URL; ?>"><?php echo SITE_NAME; ?></a>
						</h1>
					</div>
					<div id="nav">
            [position=top]
						<br class="clear" />
					</div>
				</div>
				<div id="main">
					[component]
					[position=bottom]
					<div id="sidebar1">
            [position=main_menu]
					</div>
					<br class="clear" />
				</div>
				<div id="footer">
          [position=footer] 
				</div>
			</div>
			<div id="copyright">
				© <?php echo SITE_NAME; ?> | Работает на <a href="http://www.usercms.ru/">UserCMS 2</a>
			</div>
		</div>
    </body>
</html>
