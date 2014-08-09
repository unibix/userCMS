<div class="feedback">
  <form action="#plugin-feedback-<?php echo $plugin_id; ?>" method="POST">
    <a name="plugin-feedback-<?php echo $plugin_id; ?>"></a>
  <?php if ($success) { ?>
  <div class="notice success"><?php echo $success; ?></div>
  <?php } else { ?>
    <?php foreach ($fields as $i => $field) { ?>
      <div>
        <?php if ($field['type'] == 'text') { ?>
          <label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
          <?php if ($field['error']) { ?><span class="notice error"><?php echo $field['error']; ?></span><?php } ?>
          
          <input id="<?php echo $field['name']; ?>" type="text" name="<?php echo $field['name']; ?>" value="<?php echo $field['value']; ?>" <?php if ($field['required']) { ?>required<?php } ?>>
        
        <?php } elseif ($field['type'] == 'textarea') { ?>
          <label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
          <?php if ($field['error']) { ?><span class="notice error"><?php echo $field['error']; ?></span><?php } ?>
          
          <textarea id="<?php echo $field['name']; ?>" name="<?php echo $field['name']; ?>"><?php echo $field['value']; ?></textarea>
          
        <?php } elseif ($field['type'] == 'select') { ?>
          <label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label>
          <?php if ($field['error']) { ?><span class="notice error"><?php echo $field['error']; ?></span><?php } ?>
          
          <select id="<?php echo $field['name']; ?>" name="<?php echo $field['name']; ?>">
            <?php foreach ($field['option_list'] as $option) { ?>
              <?php if ($option == $field['value']) { ?>
              <option value="<?php echo $option; ?>" selected><?php echo $option; ?></option>
              <?php } else { ?>
              <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
              <?php } ?>
            <?php } ?>
          </select>
          
        <?php } elseif ($field['type'] == 'checkbox') { ?>
          <label for="<?php echo $field['name']; ?>" class="checkbox-label"><?php echo $field['label']; ?></label>
          <?php if ($field['error']) { ?><span class="notice error"><?php echo $field['error']; ?></span><?php } ?>
          
          <?php if ($field['value']) { ?>
          <input id="<?php echo $field['name']; ?>" type="checkbox" name="<?php echo $field['name']; ?>" value="1" checked >
          <?php } else { ?>
          <input id="<?php echo $field['name']; ?>" type="checkbox" name="<?php echo $field['name']; ?>" value="1">
          <?php } ?>
          
        <?php } elseif ($field['type'] == 'submit') { ?>
          <input type="submit" name="<?php echo $field['name']; ?>" value="<?php echo $field['label']; ?>">
        <?php } ?>
        
      </div>
    <?php } ?>
  <?php } ?>
  </form>
</div>