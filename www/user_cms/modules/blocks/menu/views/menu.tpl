<ul>
  <?php foreach($items as $item) { ?>
    <?php if($this->is_active($item['url'])) { ?>
      <li class="current"><a href="<?php echo $item['url']; ?>"><?php echo $item['name']; ?></a></li>
    <?php } else { ?>
      <li><a href="<?php echo $item['url']; ?>"><?php echo $item['name']; ?></a></li>
    <?php } ?>
  <?php } ?>
</ul>