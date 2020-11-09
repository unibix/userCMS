<style>
	#wrap {width:960px; padding:30px; margin:0 auto; position: relative;}
	input[name="new_name"]{height:18px;}
	a.back{color:blue; font-style: italic;}
	table, tr, td, th{border:1px solid black; border-collapse: collapse;padding:10px;}
	textarea{overflow: scroll; border-radius: 2px; box-shadow: 0px 0px 10px 0px grey; padding:10px;}
	.main-table{clear: both; width: 100%;}
	.add-file { display: flex; align-items: center; }
	.add-file input { margin: 0 !important; padding: 12px !important; }
	.add-file, .editor{margin:20px 5px;}
	.errors{padding:5px 10px; background: #ff4444; border-radius: 2px; box-shadow: 0px 0px 10px 0px rgba(184,0,15,0.7);}
	.success{padding:20px; background: #00C851; border-radius: 2px; box-shadow: 0px 0px 10px 0px rgba(0,150,23,0.7);}
	.arch_button{margin: 5px 0; float:right;}
	.archivate{margin: 5px 0; }
	#naming-archive{border:1px solid black; border-radius: 2px; position: absolute; top:50%; left:50%; transform: translate(-50%, -50%); padding:20px; background: #ffbb33; box-shadow: 0px 0px 14px 2px rgba(0,0,0,0.75);}
	#naming-archive button {margin-right: 5px;}
	table a:hover{text-decoration: underline;}
	.archiving-buttons{padding:20px; background: yellow; border: 1px solid black; position: fixed; top:5px; right: 20%; border-radius: 2px;}
	#content table td { padding: 0px; }
	#content table td, #content table th, #content table a { font-size: 12px; text-decoration: none;}
</style>
<div id="content">
<h1>Менеджер файлов</h1>
<?=$breadcrumbs;?>
<?php if (count($errors) > 0){?>
	<div class="errors">
		<?php foreach($errors as $error){?>
		<p><?=$error;?></p>
		<?php } ?>
	</div>
<?php } ?>
<?php if(isset($success) && $success){?>
	<div class="success"><?=$success;?></div>
<?php } ?>
<?php if(isset($_GET['edit_item']) && !empty($_GET['edit_item'])){ ?>
<hr>
<form method="POST" class="editor">
	<h4>Редактор тектовых файлов</h4>
	<p><?=$_GET['edit_item']?></p>
	<textarea class="code-editor" id="code_editor" cols="100" rows="20" name="text"><?=$file_content;?></textarea>
	<br><br><input type="submit" value="Сохранить" name="save_changes">
	<input onclick="return confirm('Закрыть редактор?Несохраненные данные будут потеряны');" type="submit" value="Закрыть" name="discard_changes">
</form>
<hr>
<?php } ?>
<form method="POST" enctype="multipart/form-data" class="add-file">
	<input type="file" multiple name="files[]">
	<input type="submit" value="Загрузить файлы в текущую папку" name="upload">
</form>
<p id="breadcrumbs_generated"><?=str_replace(['. /', './'], '', str_replace(['\\', '/'], ' / ', $this->model->win_to_utf($path) ));?></p>
<table class="main-table">
	<tr>
		<th class="text-center p-1" align="center"><input type="checkbox" id="all_check"></th>
		<th>Имя файла или папки</th>
		<th>Размер</th>
		<th>Действия</th>
	</tr>
	<form method="POST">
	<?php foreach ($dir as $key => $item) {?>
		<?php if($item != '.' || $path != ROOT_DIR){?>
		<tr>
		<td class="text-center p-1" align="center"><?php if($item != '.') { ?> <input type="checkbox" name="files_to_archiving[<?=$key;?>]" value="<?=$item;?>" <?=isset($_POST['files_to_archiving'][$key])?'checked':'';?>> <?php } ?></td>
			<td>
				<?php if(isset($_GET['rename_item']) && $_GET['rename_item'] == $item && !isset($_POST['cancel'])){?>
					<form>
						<input type="text" name="new_name" value="<?=$item;?>" autofocus="atofocus">
						<input type="hidden" name="old_name" value="<?=$item;?>">
						<input type="submit" value="x" title="Отмениь" name="cancel">
						<input type="submit" value="&#10003;" title="Применить" name="rename">
					</form>
				<?php }else if(in_array(strtolower(pathinfo($path . '/' . $item, PATHINFO_EXTENSION)), $image_extensions)){?>
				<a href="<?=$url.'/'.$this->model->win_to_utf($item);?>" target="_blank">&#x1f5b9;<?=$item;?></a>
				<?php }else{?>
				<?php if(!isset($_GET['for_arch'])){?>
				<a href="?name=<?=$item;?>" <?=$item=='.'?'class="back"':'';?> >
				<?php }?>
					
					<?=is_dir($path . '/' . $this->model->win_to_utf($item, true))&&$this->model->win_to_utf($item)!='.'?'&#x1f4c1;':
					(is_file($path . '/' . $this->model->win_to_utf($item, true))?'&#x1f5b9;':'');?>
					<?=$item=='.'?'&#x21e6; назад':$item;?>
					<?php if(!isset($_GET['for_arch'])){?>
					</a>
					<?php }?>
				<?php } ?>
			</td>
			<td>
				<?php if($item != '.'){?>
				<?=is_file($path . '/' . $this->model->win_to_utf($item, true))?$this->model->out_size(filesize($path . '/' . $this->model->win_to_utf($item, true))):'___';
				}?>	
			</td>
			<td>
				<?php if($item != '.'){?>
					<?php if(is_file($path . '/' . $this->model->win_to_utf($item, true))){?>
						<a href="<?=str_replace(ROOT_DIR, SITE_URL, $path) . '/' . $item;?>" download>Скачать</a> | 
					<?php } ?>
					<a href="<?=$get_query?'?'.$get_query.'&rename_item='.$item:'?rename_item='.$item;?>">Переименовать </a> 
					| <a onclick="return confirm('Вы уверены?');" href="<?=$get_query?'?'.$get_query.'&delete='.$item:'?delete='.$item;?>">Удалить</a> 
					<?php if(in_array(strtolower(pathinfo($path . '/' . $item, PATHINFO_EXTENSION)), $text_extensions)){?> 
					| <a href="<?=$get_query?'?'.$get_query.'&edit_item='.$item:'?edit_item='.$item;?>">Редактировать</a>  
					<?php } ?>
					<?php if(strtolower(pathinfo($path . '/' . $item, PATHINFO_EXTENSION)) == 'zip'){?> 
					| <a href="<?=$get_query?'?'.$get_query.'&unpack='.$item:'?unpack='.$item;?>">Разархивировать</a> 
					<?php } ?>
				<?php } ?>
			</td>
		</tr>
	<?php } 
		}?>
</table>
<label for="select_action">Действия</label>
<select class="w-50 mt-3" id="select_action">
	<option value="">Выберите</option>
	<option value="archivate">Архивировать</option>
	<option value="delete">Удалить</option>
	<option value="download">Скачать</option>
</select>
<input id="do_submit" class="archivate py-1 px-2" type="submit" value="Применить" name="">
</form>
</div>
</div>

<script>
	let do_submit_btn = document.getElementById('do_submit');
	let select_action = document.getElementById('select_action');

	if(do_submit_btn) {
		do_submit_btn.classList.add('d-none');
	}

	if(select_action) {
		select_action.addEventListener('change', function() {
			do_submit_btn.setAttribute('name', this.value);
			do_submit_btn.onclick = function() {};
			let action = ((this.value === 'delete') ? 'удаление' : 'архивацию');

			if(this.value == '') {
				do_submit_btn.classList.add('d-none');
			} else {
				do_submit_btn.classList.remove('d-none');
			}

			if(this.value === 'delete' || this.value === 'archivate') {
				do_submit_btn.onclick = function() {
					if(!confirm('Точно выполнить ' + action + '?')) {
						return false;
					}
				};
			} else {
				do_submit_btn.onclick = function() {};
			}

		});
	}


	let all_check = document.getElementById('all_check');
	if(all_check) {
		all_check.addEventListener('change', function() {
			let input_elems = document.querySelectorAll('input[type="checkbox"]');
			if(this.checked) {
				input_elems.forEach(function(item, index) {
					if(index) {
						item.checked = true;
					}
				});
			} else {
				input_elems.forEach(function(item, index) {
					if(index) {
						item.checked = false;
					}
				});
			}
		});
	}
	
	let breadcrumbs_generated = document.getElementById('breadcrumbs_generated');
	let root_dir = '<?=$root_dir?>' + '\\';

	if(breadcrumbs_generated) {
		let path = breadcrumbs_generated.innerHTML;
		let parts = path.split('/');
		let new_path = '';
		parts.forEach(function(item, index) {
			item = item.trim();
			new_path += item + '\\';
		});

		new_path = new_path.slice(root_dir.length);

		let new_parts = new_path.split('\\');
		let new_html = '<a href="/userCMS/www/admin/files_manager?change=1&name=.">Корневой каталог</a>';
		new_parts.forEach(function(item, index) {
			if(item && item != '.') {
				let item_html = '<a href="/userCMS/www/admin/files_manager?change=1&name=' + item + '">' + item + '</a>';
				new_html += ' / ' + item_html;
			}
		});
		breadcrumbs_generated.innerHTML = new_html;
	}
</script>