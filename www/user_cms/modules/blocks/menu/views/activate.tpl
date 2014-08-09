<?php if($menus) { ?>
  <h2>Выберите меню:</h2>
  <?php foreach($menus as $menu) { ?>
  <label for="menu_<?php echo $menu['id']; ?>"><?php echo $menu['name']; ?></label>
  <input id="menu_<?php echo $menu['id']; ?>" type="radio" name="menu" value="<?php echo $menu['id']; ?>"><br>
  <?php } ?>
<?php } ?>