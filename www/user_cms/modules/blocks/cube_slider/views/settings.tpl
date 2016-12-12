<style>
	.slide {
		padding: 20px;
		border: 1px solid #E7DFD7;
    	border-radius: 8px;
    	background: #ffffff;
    	box-shadow: 0 2px 10px rgba(0,0,0,0.5);
    	box-sizing: border-box;
    	margin-bottom: 30px;
    	background-position: center center;
    	background-size: cover;
	}
	.slide > input {box-sizing: border-box;}
	.with_image > label {color: #000000; text-shadow: 0px 0px 5px #ffffff;}
	.with_image > label, .with_image > input {opacity: 0.3; transition: opacity 0.3s ease;}
	.with_image:hover > label, .with_image:hover > input {opacity: 1;} 
</style>

<div id="content">
	<?php if (!empty($errors)) echo '<div class="error">'.implode('<br>', $errors).'</div>' ?>
	<h2>Настройки слайдера CUBE</h2>
	<p>
		<label>Отношение ширина/высота слайда</label>
		<input type="text" name="aspect_ratio" value="<?=$settings['aspect_ratio']?>">
		<label>Длительность анимации смены слайда, мс</label>
		<input type="text" name="speed" value="<?=$settings['speed']?>">
		<label>Период смены слайдов, мс (должен быть больше длительности анимации)</label>
		<input type="text" name="frequency" value="<?=$settings['frequency']?>">
        <label><input type="checkbox" name="has_shadow" value="true" <?=($settings['has_shadow']) ? 'checked' : ''?>> Добавить тень под слайдером</label>
	</p>
	<h2>Слайды</h2>
	<p class="buttons">
		<input type="button" value="Добавить слайд" onclick="addSlide()">
	</p>
	<div id="slides">
	<?php foreach($settings['slides'] as $slide) {
		if ($slide['image'] != '') {
			$image = ' style="background-image: url(\''.SITE_URL.$slide['image'].'\')"';
			$class = ' with_image';
		} else {
			$image = '';
			$class = '';
		}
		echo
		'<div class="slide'.$class.'"'.$image.'>
			<label>Файл</label>
			<input type="file" name="files[]">
			<input type="hidden" name="images[]" value="'.$slide['image'].'">
			<label>Текст на картинке</label>
			<input type="text" name="texts[]" value="'.$slide['text'].'">
			<label>Текст на кнопке (ссылке)</label>
			<input type="text" name="btn_texts[]" value="'.$slide['btn_text'].'">
			<label>Адрес ссылки</label>
			<input type="text" name="hrefs[]" value="'.$slide['href'].'">
			<input type="button" value="Поднять" onclick="moveSlideUp(this)">
			<input type="button" value="Опустить" onclick="moveSlideDown(this)">
			<input type="button" value="Удалить" onclick="deleteSlide(this)">
		</div>';
	} ?>
	</div>
</div>

<script>
	function addSlide() {
		var div = document.createElement('DIV');
		div.className = 'slide';
		div.innerHTML = 
			'<label>Файл</label>\
			<input type="file" name="files[]">\
			<input type="hidden" name="images[]" value="">\
			<label>Текст на картинке</label>\
			<input type="text" name="texts[]">\
			<label>Текст на кнопке (ссылке)</label>\
			<input type="text" name="btn_texts[]">\
			<label>Адрес ссылки</label>\
			<input type="text" name="hrefs[]">\
			<input type="button" value="Поднять" onclick="moveSlideUp(this)">\
			<input type="button" value="Опустить" onclick="moveSlideDown(this)">\
			<input type="button" value="Удалить" onclick="deleteSlide(this)">';
		document.getElementById('slides').appendChild(div);
	}

	function deleteSlide(btn) {
		var slide = btn.parentNode;
		slide.parentNode.removeChild(slide);
	}

	function moveSlideUp(btn) {
		var slide = btn.parentNode;
		var index = $('.slide').get().indexOf(slide);

		if (index > 0) {
			$(slide).detach();
			$($('.slide').get(index-1)).before(slide);
		}
	}

	function moveSlideDown(btn) {
		var slide = btn.parentNode;
		var index = $('.slide').get().indexOf(slide);
		var cnt = $('.slide').get().length;

		console.log(index+'; '+cnt);

		if (index < cnt-1) {
			$(slide).detach();
			$($('.slide').get(index)).after(slide);
		}
	}
</script>
