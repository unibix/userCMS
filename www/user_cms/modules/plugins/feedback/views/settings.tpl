<div id="feedback_settings">
  <div>
    <label>Направление отправки (можно указать несколько адресов через запятую):</label><br>
    <label>
    <?php if(SITE_EMAIL){?>
      Site e-mail1<input type="checkbox" id='site-email-1' value="<?=SITE_EMAIL?>" checked class="check-email" onchange="addDefaultEmails()">
    <?php } ?>
    <?php if(SITE_EMAIL2){?>
      Site e-mail2<input type="checkbox" id='site-email-2' value="<?=SITE_EMAIL2;?>" checked class="check-email" onchange="addDefaultEmails()">
    <?php } ?>
    </label>
    <input type="text" name="mail_to" value="<?php echo $mail_to; ?>" id="mail-to"> 
    <label>Тема письма:</label>
    <input type="text" name="mail_subject" value="<?php echo $mail_subject; ?>">
    <label>Email "От кого"</label>
    <input type="text" name="mail_from" value="<?php echo $mail_from; ?>">
    <label>Текст "От кого"</label>
    <input type="text" name="mail_text_from" value="<?php echo $mail_text_from; ?>">
    <label>Сообщение об успешной отправке формы</label>
    <input type="text" name="mail_text_success" value="<?php echo $mail_text_success; ?>">
  </div>
  
  <h2>Поля формы</h2>
  
  <div id="form_selected_fields" style="text-align: left">
    <?php if ($fields) { $i = 0; ?>
      <?php foreach ($fields as $field) { ?>
        <div>
          <h3>
            <span title="Поднять выше" class="arrows" onclick="moveUp(this.parentNode.parentNode)">&uarr;</span>
            <span title="Опустить ниже" class="arrows" onclick="moveDown(this.parentNode.parentNode)">&darr;</span>
            <span class="remove" title="Удалить">x</span>
            <span class="text">Поле №<?php echo $i + 1; ?>: <?=$field['label'];?> </span> - <?php echo $field_types[$field['type']]?>
          </h3>
          <div class="field-content">
            <input type="hidden" name="fields[<?=$i?>][type]" value="<?=$field['type']?>">
            
            <span>Заголовок:</span> 
            <input type="text" name="fields[<?=$i?>][label]" value="<?=$field['label']?>">
            
          <?php if ($field['type'] == 'select') { ?>
            <span>Укажите пункты списка (каждый с новой строки): </span>
            <textarea name="fields[<?=$i?>][option_list]"><?=$field['option_list']?></textarea>
            
          <?php } elseif ($field['type'] == 'checkbox' || $field['type'] == 'radio') { ?>
            <span>Атрибут тега name:</span>
            <input type="text" name="fields[<?=$i?>][name]" value="<?=$field['name']?>">
            
            <span>Значение в письме - если выбрано:</span> 
            <input type="text" name="fields[<?=$i?>][text_selected]" value="<?=$field['text_selected']?>">
            
            <span>Значение в письме - если не выбрано:</span> 
            <input type="text" name="fields[<?=$i?>][text_not_selected]" value="<?=$field['text_not_selected']?>">
            
            <span>Начальное положение:</span>
              <input type="radio" name="fields[<?=$i?>][default_checked]" value="1" <?php if ($field['default_checked'] == 1) { ?>checked<?php } ?>> Выбран
              <input type="radio" name="fields[<?=$i?>][default_checked]" value="0" <?php if ($field['default_checked'] == 0) { ?>checked<?php } ?>> Не выбран <br>
            
          <?php } elseif($field['type'] == 'recaptcha'){?>
            <br><span>Ключ</span><br>
            <input type="text" name="fields[<?=$i?>][key]" value="<?=$field['key']?>">
            <span>Секретный ключ</span>
            <input type="text" name="fields[<?=$i?>][secret_key]" value="<?=$field['secret_key']?>">
            <input type="hidden" name="fields[<?=$i?>][validation]" value="recaptcha">


          <?php } elseif($field['type'] == 'captcha'){?>
            <span>Ширина картинки (px)</span>
            <input type="text" name="fields[<?=$i?>][captcha_width]" value="<?=isset($field['captcha_width'])?$field['captcha_width']:'';?>">
            <span>Высота картинки (px)</span>
            <input type="text" name="fields[<?=$i?>][captcha_height]" value="<?=isset($field['captcha_height'])?$field['captcha_height']:'';?>">
            <input type="hidden" name="fields[<?=$i?>][validation]" value="captcha">

          <?php } ?>
          
          <?php if ($field['type'] != 'submit' && $field['type'] != 'select') { ?>
            <input type="hidden" name="fields[<?=$i?>][required]" value="0">
            <span>Обязательно для заполнения:</span>
            <input type="checkbox" name="fields[<?=$i?>][required]" value="1" <?php if ($field['required'] == 1) { ?>checked<?php } ?>>
            
            <div class="validation-block">
              <?php if ($field['type'] == 'text' || $field['type'] == 'textarea') { ?>
                <span>Метод валидации:</span>
                <select name="fields[<?=$i?>][validation]">
                  <?php foreach ($validation_methods as $validation_method => $name) { ?>
                    <?php if ($field['validation'] == $validation_method) { ?>
                    <option selected value="<?php echo $validation_method; ?>"><?php echo $name; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $validation_method; ?>"><?php echo $name; ?></option>
                    <?php } ?>
                  <?php } ?>
                </select>
              <?php } ?>

              <span>Сообщение об ошибке:</span> 
              <input type="text" name="fields[<?=$i?>][error_message]" value="<?=$field['error_message']?>">
            </div>
          <?php } ?>
          
          </div>
        </div>
      <?php $i++; } ?>
    <?php } ?>
  </div>
  
  <div id="field_types_block">
    <label>Выберите тип поля для добавления:</label>
    <select multiple name="field_types">
      <?php foreach ($field_types as $field_type => $name) { ?>
      <option value="<?php echo $field_type; ?>"><?php echo $name; ?></option>
      <?php } ?>
    </select>
  </div>
  <script type="text/javascript">
    var field;
    var field_num = <?php echo count($fields); ?>;
    var field_length = <?php echo count($fields); ?>;
    var fields_list = $('#form_selected_fields');
    
    $('#feedback_settings select[name="field_types"] option').on('click', function() {
      field_length = $(fields_list).children().length + 1;
      
      field = '<h3><span title="Поднять выше" class="arrows" onclick="moveUp(this.parentNode.parentNode)">&uarr;</span> <span title="Опустить ниже" class="arrows" onclick="moveDown(this.parentNode.parentNode)">&darr;</span><span class="remove" title="Удалить">x</span><span class="text">Поле №' + field_length + '</span> - ' + $(this).text() + '</h3>';
      field += '<div class="field-content">';
      field += '<input type="hidden" name="fields[' + field_num + '][type]" value="' + this.value + '">';
      field += '<span>Заголовок:</span> <input type="text" name="fields[' + field_num + '][label]" value="">';
      
      switch(this.value) {
        case 'text':
        case 'textarea':
          break;
          
        case 'select':
          field += '<span>Укажите пункты списка (каждый с новой строки): </span><textarea name="fields[' + field_num + '][option_list]"></textarea>';
          break;
          
        case 'checkbox':
        case 'radio':
          field += '<span>Атрибут тега name:</span> <input type="text" name="fields[' + field_num + '][name]" value="">';
          field += '<span>Значение в письме - если выбрано:</span> <input type="text" name="fields[' + field_num + '][text_selected]" value="">';
          field += '<span>Значение в письме - если не выбрано:</span> <input type="text" name="fields[' + field_num + '][text_not_selected]" value="">';
          field += '<span>Начальное положение:</span>';
            field += '<input type="radio" name="fields[' + field_num + '][default_checked]" checked value="1"> Выбран';
            field += '<input type="radio" name="fields[' + field_num + '][default_checked]" value="0"> Не выбран <br>';
          break;
          case 'recaptcha':
          field += '<br><span>Ключ:</span> <input type="text" name="fields[' + field_num + '][key]" value="" required>';
          field += '<span>Секретный ключ:</span> <input type="text" name="fields[' + field_num + '][secret_key]" value="" required>';
          field += '<input type="hidden" name="fields[' + field_num + '][validation]" value="recaptcha">';
          break;
          case 'captcha':
          field += '<span>Ширина картинки (px)</span> <input type="text" name="fields[' + field_num + '][captcha_width]" value="" >';
          field += '<span>Высота картинки (px)</span> <input type="text" name="fields[' + field_num + '][captcha_height]" value="">';
          field += '<input type="hidden" name="fields[' + field_num + '][validation]" value="captcha">';
      }
      
      if (this.value != 'submit' && this.value != 'select') {
        field += '<input type="hidden" name="fields[' + field_num + '][required]" value="0">';
        field += '<span>Обязательно для заполнения:</span><input type="checkbox" name="fields[' + field_num + '][required]" value="1">';
        
        field += '<div class="validation-block">';
          if (this.value == 'text' || this.value == 'textarea') {
            field += '<span>Метод валидации:</span>';
            field +=  '<select name="fields[' + field_num + '][validation]">';
            <?php foreach ($validation_methods as $validation_method => $name) { ?>
            field +=    '<option value="<?php echo $validation_method; ?>"><?php echo $name; ?></option>';
            <?php } ?>
            field +=  '</select>';
          }
          field +=  '<span>Сообщение об ошибке:</span> <input type="text" name="fields[' + field_num + '][error_message]" value="">';
        field +=  '</div>';
      }
      field += '</div>'; // END .field-content 
      $(fields_list).append('<div>' + field + '</div>');
      
      field_num++;
    });
    
    $('#form_selected_fields').on('click', 'h3 .remove', function() {
      $(this).parent().parent().remove();
      
      $('#form_selected_fields h3').each(function(i, elem) {
        $(this).find('span.text').html('Поле №' + (i+1));
      });
    });
    
    $('#form_selected_fields').on('click', 'h3 .text', function() {
      var field_content = $(this).parent().next();
      if ($(field_content).is(':visible')) {
        $(field_content).hide();
      } else {
        $(field_content).show();
      }
    });

    function moveUp(element) {
        var index = $('#form_selected_fields>div').get().indexOf(element);

        if (index > 0) {
            $(element).detach();
            $($('#form_selected_fields>div').get(index-1)).before(element);
        }
    }

    function moveDown(element) {
        var index = $('#form_selected_fields>div').get().indexOf(element);
        var cnt = $('#form_selected_fields>div').get().length;

        if (index < cnt-1) {
            $(element).detach();
            $($('#form_selected_fields>div').get(index)).after(element);
        }
    }    
  </script>
  <?php
  if(isset($plugin_id)) { ?>
  <h4>Для вставки формы на сайт используйте следующий код: { plugin:feedback=<?=$plugin_id;?> } без пробелов.</h4>
  <?php } ?>
</div>

<style type="text/css">
  .validation-block {display: none;}
  input[type="checkbox"]:checked + .validation-block {display: block;}
  #form_selected_fields div h3{position:relative;}
  #form_selected_fields .remove {float: right;}
  #form_selected_fields .arrows {color: #107710; cursor: pointer;}
</style>
<script>
  //добавление site-email и site-email2 по чекбоксам
   function addDefaultEmails(){
     var emails = [];//тут будут адреса сайта по умолчанию(помеченые галочкой)
     var insertedEmails = typeof $('#mail-to').val() != 'undefined'?$('#mail-to').val().split(','):false;//адреса которые добавлены в поле вручную
     insertedEmails.splice(insertedEmails.indexOf(' '), 1);//удаляем пустой
     $('.check-email').each(function(){
        if($(this).is(':checked')){
          if(emails.indexOf($(this).val()) == -1)emails.push($(this).val());//если выбран и нет в списке добавляем
          if(insertedEmails.indexOf($(this).val()) != -1)insertedEmails.splice(insertedEmails.indexOf($(this).val()), 1);//если уже введен удаляем
        }else{
          //удаляем при снятии галочки
          if(emails.indexOf($(this).val()) != -1)emails.splice(emails.indexOf($(this).val()), 1);
          if(insertedEmails.indexOf($(this).val()) != -1)insertedEmails.splice(insertedEmails.indexOf($(this).val()), 1);
        }
     });
     emailsResult = emails.concat(insertedEmails);//получаем то что было введено вручную и то что отмечено галочкой
     $('#mail-to').val((emailsResult.length>1?emailsResult.join(','):(emailsResult.length==1?emailsResult[0]:'')));
   }
   addDefaultEmails();
</script>
