<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    [head]
</head>
<body>
	<header id="header" class="hidden-xs">
        <?=SITE_NAME?>
    </header>

    <nav class="navbar navbar-inverse" id="top_menu">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Меню</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand hidden-sm hidden-md hidden-lg" href="<?=SITE_URL?>"><?=SITE_NAME?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            [position=top_menu]
        </div>
      </div>
    </nav>

    <?=IS_MAIN_PAGE ? '[position=slider]' : ''?>

    <div class="container">
        <main class="row">
            <article class="col-md-9">
                [component]
            </article>
            <aside class="col-md-3" id="aside">
                [position=aside]
            </aside>
        </main>
    </div>

    <footer id="footer" class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-xs-6">
                <?=SITE_NAME?> &copy; 2010 - <?=date('Y')?>
            </div>
            <div class="col-sm-3 col-xs-6">
                <a href="<?=SITE_URL?>/map">Карта сайта</a><br>
                <a href="<?=SITE_URL?>/dir">Написать директору</a>
            </div>
            <div class="col-sm-3 col-xs-6">
                Место для счетчиков
            </div>
            <div class="col-sm-3 col-xs-6">
                Работает на <a href="http://usercms.ru">UserCMS <?=USER_CMS_VERSION?></a>
            </div>
        </div>
    </footer>

    <script src="<?=THEME_URL?>/bootstrap/bootstrap.min.js"></script>
    <script src="<?=THEME_URL?>/bootstrap/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
