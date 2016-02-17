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

  <div style="clear:both"></div>
  <?php if ($count_pages > 1) { ?>
  <div id="paginations">
	<?php for($i=1; $i<=$count_pages; $i++){ ?>
		<span class="pagination">
			<?php if ($i==$this_page) { ?>
				<?php echo $i; ?>
			<?php } else { ?>
				<a href="<?php echo SITE_URL . '/' . $full_category_url . '/page=' . $i;?>"><?php echo $i;?></a>
			<?php } ?>
		</span>
	<?php } ?>
  </div>
  <?php } ?>
</div>