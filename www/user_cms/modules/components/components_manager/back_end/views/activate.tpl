<div id="content">
	<h1 id="page_name"><?php echo $page_name; ?></h1>
	<?php 
	if(isset($errors)) { ?>
	<div class="error">
		<?php foreach($errors as $error) { 
		 echo $error . '<br>';
		 } ?>
	</div>
	<?php 
	}
	if(isset($message)) { ?>
	<div class="success">
		<?php echo $message; ?>
	</div>
	<?php 
	} ?>

	

	<div id="add_tabs" class="tabs">
		<ul>
			<li><a class="tab_main active">Основное</a></li>
			<li><a class="tab_pages">Разделы</a></li>
			<li><a class="tab_params">Параметры</a></li>
		</ul>
	</div>

	<form method="post" action="" enctype="multipart/form-data" >
		<input type="hidden" name="type" value="addon" >
		<input type="hidden" name="module" value="jquery" >

		<div id="tabs_content">
			<div id="tab_main" style="display: block;">

				<label for="name">Название</label>
				<input type="text" name="name" >
				<label for="position">Позиция</label>
				<input type="text" name="position" >
				<label for="back_end">Использовать в админке:</label>
				<input type="radio" name="back_end" value="1" > Да  <input type="radio" name="back_end" value="1" checked > Нет
		     	<br>
		    </div>
		    <div id="tab_pages">

				<label for="pages">Выводить в разделах</label><br>
				<input type="radio" name="pages" value="0" checked > на всех  
				<input type="radio" name="pages" value="1" > на выбранных
				<input type="radio" name="pages" value="2" > на всех кроме выбранных <br>

				<input type="checkbox" name="name_1" > Главная <br>
				<input type="checkbox" name="name_1" > Контакты <br>
				<input type="checkbox" name="name_1" > Галерея <br>
				<input type="checkbox" name="name_1" > Каталог <br>
				
		     	<br>
		    </div>
		    <div id="tab_params">

		    	<?php echo $params; ?>

		    	
		    </div>
		    



		<input type="submit" name="activate" value="Активировать"> 
	</form>
</div>


<script type="text/javascript">
$(document).ready(function() {
	$('.tabs ul li a').click(function(){
		if(!$(this).hasClass('active')){
			$('.tabs ul li a').removeClass('active');
			$('#tabs_content > div').fadeOut(100, function(){$('#'+container).fadeIn(100);});
			var container = $(this).attr('class');

			$(this).addClass('active');
		}
	});

});

</script>