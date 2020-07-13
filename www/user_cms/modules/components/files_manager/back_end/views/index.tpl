<style>
	#wrap {width:960px; padding:30px; margin:0 auto; position: relative;}
	input[name="new_name"]{height:18px;}
	a.back{color:blue; font-style: italic;}
	table, tr, td, th{border:1px solid black; border-collapse: collapse;padding:10px;}
	textarea{overflow: scroll; border-radius: 2px; box-shadow: 0px 0px 10px 0px grey; padding:10px;}
	.main-table{clear: both; width: 100%;}
	.add-file, .editor{margin:20px 5px;}
	.errors{padding:5px 10px; background: #ff4444; border-radius: 2px; box-shadow: 0px 0px 10px 0px rgba(184,0,15,0.7);}
	.success{padding:20px; background: #00C851; border-radius: 2px; box-shadow: 0px 0px 10px 0px rgba(0,150,23,0.7);}
	.arch_button{margin: 5px 0; float:right;}
	.archivate{margin: 5px 0; }
	#naming-archive{border:1px solid black; border-radius: 2px; position: absolute; top:50%; left:50%; transform: translate(-50%, -50%); padding:20px; background: #ffbb33; box-shadow: 0px 0px 14px 2px rgba(0,0,0,0.75);}
	#naming-archive button {margin-right: 5px;}
	table a:hover{text-decoration: underline;}
	.archiving-buttons{padding:20px; background: yellow; border: 1px solid black; position: fixed; top:5px; right: 20%; border-radius: 2px;}
</style>
<div class="content component file">

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
	<input type="file" name="file">
	<input type="submit" value="Загрузить файл в текущую папку" name="upload">
</form>
<p><?=str_replace(['. /', './'], '', str_replace(['\\', '/'], ' / ', $this->model->win_to_utf($path) ));?></p>

<button class="arch_button"><a href="?for_arch=1">Выбрать файлы для архивации</a></button>

<table class="main-table">
	<tr>
		<th>Имя файла или папки</th>
		<th>Размер</th>
		<th>Действия</th>
	</tr>
	<form method="POST">
	<?php foreach ($dir as $key => $item) {?>
		<?php if($item != '.' || $path != ROOT_DIR){?>
		<tr>
			<td>
				<?php if(isset($_GET['rename_item']) && $_GET['rename_item'] == $item && !isset($_POST['cancel'])){?>
					<form>
						<input type="text" name="new_name" value="<?=$item;?>" autofocus="atofocus">
						<input type="hidden" name="old_name" value="<?=$item;?>">
						<input type="submit" value="x" title="Отмениь" name="cancel">
						<input type="submit" value="&#10003;" title="Применить" name="rename">
					</form>
				<?php }else if(in_array(strtolower(pathinfo($path . '/' . $item, PATHINFO_EXTENSION)), $image_extensions)){?>
				<?php if(isset($_GET['for_arch']) && $item != '.' && is_file($path . '/' . $this->model->win_to_utf($item, true))){?>
					<input type="checkbox" name="files_to_archiving[<?=$key;?>]" value="<?=$item;?>" <?=isset($_POST['files_to_archiving'][$key])?'checked':'';?>>
					<?php } ?>
				<a href="<?=$url.'/'.$this->model->win_to_utf($item);?>" target="_blank">&#x1f5b9;<?=$item;?></a>
				<?php }else{?>
				<?php if(!isset($_GET['for_arch'])){?>
				<a href="?name=<?=$item;?>" <?=$item=='.'?'class="back"':'';?> >
				<?php }?>
					<?php if(isset($_GET['for_arch']) && $item != '.' && is_file($path . '/' . $this->model->win_to_utf($item, true))){?>
					<input type="checkbox" name="files_to_archiving[<?=$key;?>]" value="<?=$item;?>" <?=isset($_POST['files_to_archiving'][$key])?'checked':'';?>>
					<?php } ?>
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
<?php if(isset($_GET['for_arch'])){ ?>
<div class="archiving-buttons">
	<button class="archivate"><a href="<?=SITE_URL  . '/admin/' . $this->url['our_component_name'] . '?cancel_arch=1';?>">Отмена</a></button>
	<input class="archivate" type="submit" value="Создать архив" name="archivate" >
</div>
<?php } ?>
</form>
</div>
</div>
