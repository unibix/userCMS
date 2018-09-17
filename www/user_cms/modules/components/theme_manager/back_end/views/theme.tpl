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
<form method="post" action="">
  <textarea class="code-editor" id="code_editor" style="min-heigth: 900px;" rows="50" name="theme_content"><?php echo $theme_content; ?></textarea>
  <input type="submit" name="submit_theme" value="Сохранить изменения">
</form>
</div>