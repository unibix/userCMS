<div id="content">
	<h1 id="page_name"><?=$page_name;?></h1>
	<p class="bread_crumbs"><?php echo $bread_crumbs; ?></p>
  <div id="news-box">
    <?php if($news_items) { ?>
      <?php foreach($news_items as $item) { ?>
      <div>
        <h2><a href="<?php echo $item['href']; ?>"><?php echo $item['name']; ?></a></h2>
        <div><?php echo $item['preview']; ?></div>
        <div class="date"><?php echo $item['date_add']; ?></div>
      </div>
      <?php } ?>
    <?php } ?>
  </div>
</div>