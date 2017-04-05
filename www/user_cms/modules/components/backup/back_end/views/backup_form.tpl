<div id="content">
    <?php if ($initial_status == 'FINISHED') { ?>
        <h1>Создать резервную копию</h1>
        <?php if (isset($error)) echo '<div class="notice error"><p>'.$error.'</p></div>'; ?>
        <form method="POST">
            <input type="radio" name="is_full" value="1" checked> Полный бэкап <br>
            <input type="radio" name="is_full" value="0"> Без папки uploads <br>
            <input type="submit" name="start" value="Создать">
        </form>
    <?php } else { ?>
        <h1>Создание резервной копии</h1>
        <div id="progress">0%</div>
        <p id="status">Получение статуса процесса...</p>

        <script>
            var STATUS_URL = '<?=$status_url?>'
            var updateProcess = setInterval(updateStatus, 250)
            updateStatus()

            function updateStatus() {
                var xhr = new XMLHttpRequest
                xhr.open('GET', STATUS_URL, true)
                xhr.onload = function() {
                    if (this.responseText == 'PREPARING_LIST_FILES') {
                        document.getElementById('status').innerHTML = 'Подготовка списка файлов...'
                        document.getElementById('progress').style.display = 'none'
                    } else if (this.responseText == 'COMPRESSING') {
                        document.getElementById('status').innerHTML = 'Выполняется сжатие архива...'
                        document.getElementById('progress').style.display = 'none'
                    } else if (this.responseText == 'FINISHED') {
                        document.getElementById('status').innerHTML = 'Резервная копия готова. <a href="/admin/backup">К списку копий.</a>'
                        document.getElementById('progress').style.display = 'none'
                        clearInterval(updateProcess);
                    } else if (this.responseText != '') {
                        document.getElementById('status').innerHTML = 'Упаковка файлов в архив...'
                        document.getElementById('progress').style.display = ''
                        document.getElementById('progress').textContent = this.responseText + '%'
                        document.getElementById('progress').style.backgroundImage = 'linear-gradient(to right, #36b536 0%, #36b536 '+this.responseText+'%, #F5F0E7 '+this.responseText+'%, #F5F0E7 100%)'
                    }
                }
                xhr.send()
            }
        </script>

        <style>
            #progress {
                background-color: #F5F0E7;
                border: 1px solid #D7D0C0;
                border-radius: 8px;
                color: #454545;
                padding: 10px;
                width: 400px;
                margin-bottom: 5px;
                text-align: center;
            }
        </style>
    <?php } ?>
</div>