<div id="content">
  <h1 class="page_name">Создание бэкапа</h1>
  <form method="POST" action="">
    <label>Выберите тип резервной копии:</label><br>
    <input checked type="radio" name="type" value="full">полная <br>
    <input type="radio" name="type" value="no_uploads">без содержимого папки uploads <br>
    <input type="submit" name="create_backup" value="Создать">
  </form>
  
<?php if (isset($_SESSION['backup_name'])) { ?>  
  <div style="overflow:hidden; position:relative; width:200px; height:20px; border:1px solid #999999; background:#CCCCCC; border-radius:6px;">
	<div style="position:relative; text-align:center; z-index:5; margin:0 auto; font-size:14px; color:black;">
		<span id="innernumber"><?php echo $_SESSION['last_backup_file']; ?></span>/<span id="outernumber"><?php echo $_SESSION['number_backup_files']; ?></span>
	</div>
	<div id="greenline" style="position:absolute; z-index:3; top:0px; left:0px; width:0px; height:20px; background:#1A9E1A;"></div>
  </div>
  <div style="min-width:200px; height:20px; text-align:left; color:red;">*не закрывайте вкладку в браузере</div>

<?php } ?>
</div>
<?php if (isset($_SESSION['backup_name'])) { ?>
<script>
function postXmlHttp(url, params){
	var http = new XMLHttpRequest();
	http.open("POST", url, true);

	http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	http.setRequestHeader("Content-length", params.length);
	http.setRequestHeader("Connection", "close");

	http.onreadystatechange = function() {//Call a function when the state changes.
		if(http.readyState == 4 && http.status == 200) {
			console.log(http.responseText);
			if (http.responseText==1) {
				document.getElementById("innernumber").innerHTML = parseInt(document.getElementById("innernumber").innerHTML) + 1;
				document.getElementById("greenline").style.width = (200 * parseInt(document.getElementById("innernumber").innerHTML) / parseInt(document.getElementById("outernumber").innerHTML))  + "px";
				console.log(parseInt(document.getElementById("innernumber").innerHTML));
				console.log(http.responseText);
				postXmlHttp(url, params);
			} else if (http.responseText==0){
				window.location = "<?php echo SITE_URL . '/admin/backup'; ?>";
			} else {
				//error
			}
		}
	}
	http.send(params);
}

$( document ).ready(function() {
    postXmlHttp("<?php echo SITE_URL . '/admin/backup/ajax_create_backup'; ?>", '');
});
</script>
<?php } ?>