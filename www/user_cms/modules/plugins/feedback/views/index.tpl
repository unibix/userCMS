<div class="feedback" id="plugin-feedback-<?=$plugin_id?>">
    <form action="#plugin-feedback-<?=$plugin_id?>" method="POST" enctype="multipart/form-data">
    <?php if ($success) { ?>
        <div class="alert alert-success"><?=$success?></div>
    <?php } else { ?>
        <?php foreach ($fields as $i => $field) { ?>
            <div class="form-group <?=($field['error']) ? 'has-error' : ''?>">
            <?php if ($field['type'] == 'text') { ?>

                <label for="<?=$field['name']?>"><?=$field['label']?><?=($field['required']) ? ' *' : ''?></label>
                <?php if ($field['error']) { ?><span class="text-danger"><?=$field['error']?></span><?php } ?>
                <input id="<?=$field['name']?>" type="text" class="form-control" name="<?=$field['name']?>" value="<?=$field['value']?>" <?=($field['required']) ? 'required' : ''?>>
            
            <?php } elseif ($field['type'] == 'file') { ?>

                <label for="<?=$field['name']?>"><?=$field['label']?><?=($field['required']) ? ' *' : ''?></label>
                <?php if ($field['error']) { ?><span class="text-danger"><?=$field['error']?></span><?php } ?>
                <input id="<?=$field['name']?>" type="file" class="form-control" name="<?=$field['name']?>" <?=($field['required']) ? 'required' : ''?>>
            
            <?php } elseif ($field['type'] == 'textarea') { ?>

                <label for="<?=$field['name']?>"><?=$field['label']?><?=($field['required']) ? ' *' : ''?></label>
                <?php if ($field['error']) { ?><span class="text-danger"><?=$field['error']?></span><?php } ?>
                <textarea id="<?=$field['name']?>" class="form-control" name="<?=$field['name']?>" <?=($field['required']) ? 'required' : ''?>><?=$field['value']?></textarea>
                
            <?php } elseif ($field['type'] == 'select') { ?>

                <label for="<?=$field['name']?>"><?=$field['label']?><?=($field['required']) ? ' *' : ''?></label>
                <?php if ($field['error']) { ?><span class="text-danger"><?=$field['error']?></span><?php } ?>
                
                <select id="<?=$field['name']?>" class="form-control" name="<?=$field['name']?>" <?=($field['required']) ? 'required' : ''?>>
                    <?php foreach ($field['option_list'] as $option) { ?>
                        <?php if ($option == $field['value']) { ?>
                        <option value="<?=$option?>" selected><?=$option?></option>
                        <?php } else { ?>
                        <option value="<?=$option?>"><?=$option?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
                
            <?php } elseif ($field['type'] == 'checkbox') { ?>

                <?php if ($field['value']) { ?>
                    <input id="<?=$field['name']?>" type="checkbox" name="<?=$field['name']?>" value="1" checked >
                <?php } else { ?>
                    <input id="<?=$field['name']?>" type="checkbox" name="<?=$field['name']?>" value="1">
                <?php } ?>

                <label for="<?=$field['name']?>"><?=$field['label']?><?=($field['required']) ? ' *' : ''?></label>
                <?php if ($field['error']) { ?><span class="text-danger"><?=$field['error']?></span><?php } ?>
                
            <?php } elseif ($field['type'] == 'submit') { ?>

                <input type="submit" class="btn btn-primary" name="<?=$field['name']?>" value="<?=$field['label']?>">

            <?php } elseif ($field['type'] == 'recaptcha'){;?>
                
                <div style="margin:10px 0">
                   <script src='https://www.google.com/recaptcha/api.js'></script>
                    <div class="g-recaptcha" data-sitekey="<?=$field['option_list']['key'];?>"></div>
                   <?php if ($field['error']) { ?><span class="text-danger"><?=$field['error']?></span><?php } ?> 
                </div>
                
            <?php } elseif ($field['type'] == 'captcha'){?>
                <div style="margin:10px 0">
                    <img id="img-captcha" src="<?=SITE_URL;?>/user_cms/helpers/captcha.php?suffix=<?=$plugin_id;?>" width="<?=isset($field['option_list']['captcha_width'])&&$field['option_list']['captcha_width']?$field['option_list']['captcha_width']:'150';?>px" height="<?=isset($field['option_list']['captcha_height'])&&$field['option_list']['captcha_height']?$field['option_list']['captcha_height']:'35';?>px">
                    <label for="captcha">Введите символы с картинки: </label>
                    <input type="text" class="form-control" id="captcha" name="captcha" >
                    <?php if ($field['error']) { ?><span class="text-danger"><?=$field['error']?></span><?php } ?> 
                </div>
                
            <?php } ?>
        <?php } ?>
        * - обязательны для заполнения
    <?php } ?>
       <input type="hidden" name="phone_label" value="">
       <input type="text" name="email_label" value="check@gmail.com" style="display: none;">
    </form>
</div>
