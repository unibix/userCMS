<div id="content">
	<h1 id="page_name"><?=$page_name;?></h1>
	<?php if($success) { ?>
	<div class="notice success">
		<?php foreach($success as $msg) { ?>
		<p><?php echo $msg; ?></p>
		<?php } ?>
	</div>
	<?php } ?>
	<?php if($errors) { ?>
	<div class="notice error">
	<?php foreach($errors as $error) { ?>
		<p><?php echo $error; ?></p>
	<?php } ?>
	</div>
	<?php } ?>
	<p class="buttons">
    <?php if($category_id) { ?>
    <a class="button" href="<?php echo SITE_URL; ?>/admin/news/add/category_id=<?php echo $category_id; ?>">Добавить новость</a>
    <?php } else { ?>
    <a class="button" href="<?php echo SITE_URL; ?>/admin/news/add">Добавить новость</a>
    <?php } ?>
  </p>
  <?php if($categories) { ?>
  <select name="category" onChange="this.options[this.selectedIndex].onclick()">
    <option onClick="window.location=this.value;" value="<?php echo $option_value; ?>">Все новости</option>
    <?php foreach($categories as $category) { ?>
      <?php if($category_id == $category['id']) { ?>
      <option onClick="window.location=this.value;" value="<?php echo $option_value . '/category_id=' . $category['id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
      <?php } else { ?>
      <option onClick="window.location=this.value;" value="<?php echo $option_value . '/category_id=' . $category['id']; ?>"><?php echo $category['name']; ?></option>
      <?php } ?>
    <?php } ?>
  </select>
  <?php } ?>
  <?php if($news) { ?>
  <table class="main">
    <tr>
      <th>Заголок</th>
      <th>Категория</th>
      <th>Действия</th>
    </tr>
    <?php foreach($news as $item) { ?>
    <tr>
      <td><?php echo $item['name']; ?></td>
      <td><?php echo $item['cat_name']; ?></td>
      <td class="actions">
        <a href="<?php echo SITE_URL; ?>/admin/news/edit/<?php echo $item['id']; ?>">Изменить</a>
        <a class="confirmButton" href="<?php echo SITE_URL; ?>/admin/news/delete/<?php echo $item['id']; ?>">Удалить</a>
      </td>
    </tr>
    <?php } ?>
  </table>
    <?php if ($pages_amount > 1) {
      echo '<ul class="pagination">';
          //стрелка влево
          if ($current_page > 1) {
              echo '<li><a href="'.SITE_URL.$base_url.'/page='.($current_page-1).'">&lt;</a></li>';
          } else {
              echo '<li><span>&lt;</span></li>';
          }
          //если много страниц
          if ($pages_amount > 15) {
              //если далеко от начала
              if ($current_page > 6) {
                  $prefix = '<li><a href="'.SITE_URL.$base_url.'/page=1">1</a></li><li><span>...</span></li>';
                  $start = $current_page - 5;
              } else {
                  $prefix = '';
                  $start = 1;
              }
              //если далеко от конца
              if ($current_page < $pages_amount - 5) {
                  $postfix = '<li><span>...</span></li><li><a href="'.SITE_URL.$base_url.'/page='.$pages_amount.'">'.$pages_amount.'</a></li>';
              } else {
                  $postfix = '';
                  $start = $pages_amount - 10;
              }
              echo $prefix;
              for ($i=$start; $i<$start+11; $i++) if ($i == $current_page) {
                  echo '<li class="current"><span>'.$i.'</span></li>';
              } else {
                  echo '<li><a href="'.SITE_URL.$base_url.'/page='.$i.'">'.$i.'</a></li>';
              }
              echo $postfix;
          //если мало страниц
          } else {
              for ($i=1; $i<=$pages_amount; $i++) if ($i == $current_page) {
                  echo '<li class="current"><span>'.$i.'</span></li>';
              } else {
                  echo '<li><a href="'.SITE_URL.$base_url.'/page='.$i.'">'.$i.'</a></li>';
              }
          }
          //стрелка вправо
          if ($current_page < $pages_amount) {
              echo '<li><a href="'.SITE_URL.$base_url.'/page='.($current_page+1).'">&gt;</a></li>';
          } else {
              echo '<li><span>&gt;</span></li>';
          }
      echo '</ul>';
    } ?>
  <?php } ?>
</div>