<!DOCTYPE html>
<html>
<head>
	<title>Админ панель</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta charset="utf-8" />
	<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
    <script type="text/javascript" src="jquery-1.2.3.pack.js"></script>
</head>
<body>

<div id="header-wrapper">
	<div id="header">
		<div id="logo">
			<h5><a href="#">User<span>CMS</span></a></h5>
			<p>Название сайта</p>
		</div>
		 <div id="h_right">
            <a href="<?php echo SITE_URL ; ?>/admin/users/view/1" >Добро пожаловать, admin</a>
            <a href="<?php echo SITE_URL ; ?>/admin/users/logout" >Выйти</a>
            <a href="<?php echo SITE_URL ; ?>" >Перейти на сайт</a>
       </div>
</div>
</div>
<div id="menu-wrapper">
	<div id="menu">
		<ul>
			<li><a href="/">Страницы</a></li>
			<li><a href="#">Меню</a></li>
			<li class="current"><a href="#">Компоненты</a></li>
			<li><a href="#">Модули</a></li>
			<li><a href="#">Настройки</a></li>
			<li><a href="#">Пользователи</a></li>
		</ul>
	</div>
	<!-- end #menu --> 
</div>
<div id="wrapper"> 
	<!-- end #header -->
	<div id="middle">
		
				<div id="leftside">
					<ul>

						<li>
							<h2>Categories</h2>
							<ul>
								<li><a href="#">Aliquam libero</a></li>
								<li><a href="#">Consectetuer adipiscing elit</a></li>
								<li><a href="#">Metus aliquam pellentesque</a></li>
								<li><a href="#">Suspendisse iaculis mauris</a></li>
								<li><a href="#">Urnanet non molestie semper</a></li>
								<li><a href="#">Proin gravida orci porttitor</a></li>
							</ul>
						</li>
						
						<li>
							<h2>Aliquam tempus</h2>
							<p>Mauris vitae nisl nec metus placerat perdiet est. Phasellus dapibus semper consectetuer hendrerit.</p>
						</li>
					</ul>
				</div><!-- end #leftside -->
				
				<div id="rightside">

					<div id="content">
						<h1 id="pagename">Название страницы</h1>
						<p class="breadcrumbs"><span class="date">  <a href="#">Имя сайта</a> ➜ <a href="#">Каталог</a> ➜ <a href="#">Категория</a> ➜ Товар </span><span class="posted">Posted by <a href="#">Someone</a></span></p>

						<p>This is <strong>Green Exposure</strong>, a free, fully standards-compliant CSS template designed by <a href="#">FCT</a>.  The photo used in this template is from <a href="#">Fotogrph</a>.  This free template is released under a <a href="#">Creative Commons Attributions 2.5</a> license, so you’re pretty much free to do whatever you want with it (even use it commercially) provided you keep the links in the footer intact. Aside from that, have fun with it :)</p>
						<p>Sed lacus. Donec lectus. Nullam pretium nibh ut turpis. Nam bibendum. In nulla tortor, elementum ipsum. Proin imperdiet est. Phasellus dapibus semper urna. Pellentesque ornare, orci in felis. Donec ut ante. In id eros. Suspendisse lacus turpis, cursus egestas at sem.</p>
						<p class="links"><a href="#" class="button">Read More</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="button">Comments</a></p>
						<form method="get" action="#">
							<div>
								<label for="login">Логин:</label><br>
								<input type="text" name="login" value="" placeholder="Например: usermaster" />
								<label for="password">Пароль:</label><br>
								<input type="password" name="password" value="" placeholder="Например: dgbfdghcxhgchfg" />
								<label for="text">Текст:</label><br>
								<textarea name="text" placeholder="Например: страница на стадии заполнения" ></textarea>
								<label for="age">Возвраст:</label><br>
								<select name="age" >
									<option value="10">10 лет</option>
									<option value="20">20 лет</option>
									<option value="30">30 лет</option>
									<option value="50">50 лет</option>
								</select>
								<label for="password">Радио баттоны:</label><br>
								<input type="radio" name="r1" value="1" /> Да 
								<input type="radio" name="r1" value="0" /> Нет<br>
								<label for="password">Чекбоксы:</label><br>
								<input type="checkbox" name="ch1" value="1" /> Синий <br>
								<input type="checkbox" name="ch2" value="1" /> Зеленый <br>
								<input type="checkbox" name="ch3" value="1" /> Красный<br>
								<input type="checkbox" name="ch4" value="1" /> Черный<br>
								

								

								<input type="submit"  value="Сохранить" /><br>
							</div>
						</form>

						<h2>
    Проверка инлайновых элементов</h2>
<a href="#">Ссылка</a>, <a href="#">посещенная ссылка</a>, <a href="#">ссылка при наведении</a>, <span>обычный текст</span>, <strong>полужирный текст</strong>, <b>полужирный текст 2</b>, <em>наклонный текст</em>, <i>наклонный текст 2</i>.
<h2>
    Проверка блочных элементов</h2>
<h1>
    Заголовок первого уровня</h1>
<h2>
    Заголовок 2 уровня</h2>
<h3>
    Заголовок 3 уровня</h3>
<h4>
    Заголовок 4 уровня</h4>
<h5>
    Заголовок 5 уровня</h5>
<h6>
    Заголовок 6 уровня</h6>
<p>
    Параграф.</p>
<p>
    Параграф (проверяем отступы между ними).</p>
<p>
    Параграф.</p>
<h2>
    Проверка списков</h2>
<h3>
    Маркированный список</h3>
<ul>
    <li>
        Маркеры должны быть!!! И не должны вылазить!!</li>
    <li>
        Автотор</li>
    <li>
        Продукты питания комбинат</li>
    <li>
        СОЯ</li>
    <li>
        Морской торговый порт</li>
    <li>
        Калининградский судоремонтный завод</li>
    <li>
        Калининградский рыбоконсервный комбинат, просто длинный элемент списка Калининградский рыбоконсервный<a href="#"> А это ссылка</a> комбинат , пожалуй самый длинный элемент, Калининградский рыбоконсервный комбинат</li>
    <li>
        Калининградские деликатесы</li>
    <li>
        Светловский мясокомбинат</li>
    <li>
        Союз ТТ и десятки других предприятий</li>
</ul>
<h3>
    Нумерованный список</h3>
<ol>
    <li>
        Маркеры должны быть!!! И не должны вылазить!!</li>
    <li>
        Автотор</li>
    <li>
        Продукты питания комбинат</li>
    <li>
        СОЯ</li>
    <li>
        Морской торговый порт</li>
    <li>
        Калининградский судоремонтный завод</li>
    <li>
        Калининградский рыбоконсервный комбинат, просто длинный элемент списка Калининградский рыбоконсервный<a href="#"> А это ссылка</a> комбинат , пожалуй самый длинный элемент, Калининградский рыбоконсервный комбинат</li>
    <li>
        Калининградские деликатесы</li>
    <li>
        Светловский мясокомбинат</li>
    <li>
        Союз ТТ и десятки других предприятий</li>
</ol>
<h2>
    Проверка изображений</h2>
<p>
    <img alt=" вставь реальное  изображение" src="http://img.yandex.net/i/www/logo.png" align="left"> Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat. <img alt=" вставь реальное  изображение" src="http://img.yandex.net/i/www/logo.png" align=""></p>
<h3>
    Пример таблицы</h3>
<table border="1">
    <tbody>
        <tr>
            <th>
                #</th>
            <th>
                Заголовок</th>
            <th>
                должен отличаться</th>
        </tr>
        <tr>
            <td>
                1</td>
            <td>
                от обычных</td>
            <td>
                ячеек</td>
        </tr>
        <tr>
            <td>
                2</td>
            <td>
                Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</td>
            <td>
                Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</td>
        </tr>
        <tr>
            <td>
                3</td>
            <td>
                Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</td>
            <td>
                Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</td>
        </tr>
        <tr>
            <td>
                4</td>
            <td>
                Nam libero tempore, cum soluta nobis est eligendi optio, cumque nihil impedit, quo minus id, quod maxime placeat, facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet, ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</td>
            <td>
                Проверь вертикальное выравнивание по умолчанию!!!!</td>
        </tr>
    </tbody>
</table>



						<div class="clear">&nbsp;</div>
					</div><!-- end #content -->

				</div><!-- end #rightside -->

				
				
				
				
				<div class="clear">&nbsp;</div>
		
	</div>
	<!-- end #page --> 
</div>
<div id="footer">
	<p>
		<a href="http://usercms.ru/forum" target="_blank">Оф. форум</a> /
        <a href="http://usercms.ru/documentation" target="_blank">Оф. документация</a> /
        <a href="<?php echo SITE_URL ; ?>/admin/update'" >Обновить</a> /
        <a href="http://usercms.ru" target="_blank">User CMS <?php echo USER_CMS_VERSION; ?> Сборка <?php echo USER_CMS_EDITION; ?></a> © 2010-2013. 
    </p>
</div>
<!-- end #footer -->

</body>
</html>
