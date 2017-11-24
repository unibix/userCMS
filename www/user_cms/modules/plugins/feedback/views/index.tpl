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

            <?php } ?>
            </div>
        <?php } ?>
        * - обязательны для заполнения
    <?php } ?>
       <input type="hidden" name="phone_label" value="">
       <input type="text" name="email_label" value="check@gmail.com" style="display: none;">
    </form>
</div>
