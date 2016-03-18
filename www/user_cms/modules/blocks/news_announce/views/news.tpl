<div class="news_announce">
  <?php foreach($news as $item) { ?>
  <div>
    <a href="<?php echo $item['url']; ?>"><h3><?php echo $item['name']; ?></h3></a>
    <?php if ($params['show_preview']) { ?><div><?php echo $item['preview']; ?></div><?php } ?>
  </div>
  <?php } ?>
  
  <?php if ($params['show_link_all_news']) { ?>
	<div>
		<a href="/<?php echo $news_url; ?>">Посмотреть все новости</a>
	</div>
  <?php  }?>
</div>
