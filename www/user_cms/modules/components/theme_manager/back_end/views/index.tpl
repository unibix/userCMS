<style type="text/css">
  .actions {width: 200px;}
  #content table tr td.folder {background: #F6EA9D;}
  #content table tr td.subfile {padding-left: 15px;}
  #content table tr td.file {}
  h3 {font-size: 1.3em; padding-bottom: 5px;}
</style>
<div id="content">
	<h1><?php echo $page_name ; ?></h1>
  <?=$breadcrumbs;?>
  <p class="buttons">
    <a class="button" href="<?php echo $button_install; ?>">Установить тему</a>
    <a class="button" href="<?php echo $button_change_theme; ?>">Сменить тему</a>
  </p>
	<table class="main themes">
    <tr>
      <th>
        Название
      </th>
      <th class="actions">
        Действие
      </th>
    </tr>
  <?php foreach ($themes as $theme) { ?>
    <tr>
      <td colspan="2">
        <div class="theme">
          <h3><?php echo $theme['name']; ?></h3>
          <table style="width: 100%;">
          <?php foreach($theme['folders'] as $folder => $value) { ?>
            <?php if($value) { ?>
            <tr>
              <td class="folder">
                <?php echo $folder; ?>
              </td>
              <td class="actions">
                <a href="">
              </td>
            </tr>
              <?php foreach($value as $subfile) {  ?>
              <tr>
                <td class="subfile">
                  <?php echo $subfile; ?>
                </td>
                <td class="actions">
                  <a href="<?php echo SITE_URL; ?>/admin/theme_manager/theme/<?php echo $theme['name']; ?>/folder=<?php echo $folder; ?>/file=<?php echo $subfile; ?>">Изменить</a>
                </td>
              </tr>
              <?php } ?>
            <?php } ?>
          <?php } ?>
          <?php foreach($theme['files'] as $file) { ?>
            <tr>
              <td class="file">
                <?php echo $file; ?>
              </td>
              <td class="actions">
                <a href="<?php echo SITE_URL; ?>/admin/theme_manager/theme/<?php echo $theme['name']; ?>/file=<?php echo $file; ?>">Изменить</a>
              </td>
            </tr>
          <?php } ?>
          </table>
        <?php // echo '<pre>'; print_r($theme); echo '</pre>'; ?>
        </div>
      </td>
    </tr>
  <?php } ?>
	</table>

</div>