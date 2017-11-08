<div id="content">
	<h1><?php echo $page_name ; ?></h1>
	<ul class="sitemap">
		<?php
			foreach ($pages as $value) {
				?>
				<li <?php if ($value['lvl']) { ?>style="padding-left: <?php echo ($value['lvl'] * 25); ?>px"<?php } ?>><a href="<?php echo $value['url']; ?>"><?php echo $value['name']; ?></a></li>
				<?php
			}

		?>
	</ul>
</div>
