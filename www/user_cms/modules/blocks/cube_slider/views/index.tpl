<?php if (!empty($settings['slides'])) { ?>
<div class="cube-slider" data-aspect-ratio="<?=$settings['aspect_ratio']?>" data-speed="<?=$settings['speed']?>" data-frequency="<?=$settings['frequency']?>">
	<div class="left-arrow"></div>
	<div class="perspective-wrap">
		<ul class="slides">
			<?php foreach ($settings['slides'] as $slide) { ?>
			<li class="slide" style="background-image: url('<?=$slide['image']?>')">
				<div class="slide-info">
				<?php if ($slide['text'] != '') { ?>
					<h2><?=$slide['text']?></h2>
				<?php } ?>
				<?php if ($slide['href'] != '') { 
					if ($slide['btn_text'] == '') $slide['btn_text'] = 'Подробнее'; ?>
					<a class="btn" href="<?=$slide['href']?>"><?=$slide['btn_text']?></a>
				<?php } ?>
				</div>
			</li>
			<?php } ?>
		</ul>
		<div class="shadow" <?=($settings['has_shadow']) ? '' : 'style="display:none"'?>></div>
	</div>
	<div class="right-arrow"></div>
</div>
<?php } ?>