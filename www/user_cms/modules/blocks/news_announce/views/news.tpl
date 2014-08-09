<div class="news_announce">
  <?php foreach($news as $item) { ?>
  <div>
    <h3><?php echo $item['name']; ?></h3>
    <div><?php echo $item['preview']; ?></div>
  </div>
  <?php } ?>
</div>