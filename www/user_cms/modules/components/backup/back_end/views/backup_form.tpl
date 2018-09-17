<style>
    #progress {
        background-color: #F5F0E7;
        border: 1px solid #A49980;
        border-radius: 8px;
        color: #454545;
        padding: 10px;
        width: 400px;
        margin-bottom: 5px;
        text-align: center;
    }
</style>

<div id="content">
    <h1>Создание резервной копии</h1>
    <?=$breadcrumbs;?>
    <div id="error" class="notice error" style="display:none"></div>
    <div id="success" class="notice success" style="display:none">Бэкап создан! <a href="<?=SITE_URL?>/admin/backup">Список резервных копий</a></div>

    <div id="form"" style="display:none">
        <input id="isFull" type="radio" name="isFull" value="1" checked> Полный бэкап<br>
        <input type="radio" name="isFull" value="0"> Без папки uploads <br>
        <input type="button" onclick="createBackupClick()" value="Создать">
    </div>

    <div id="progress" style="display:none">0%</div>
    <p id="action" style="display:none"></p>
</div>


<script>

var backup = new backupProcess()


function createBackupClick()
{
    if (document.getElementById('isFull').checked) backup.start('type=full')
    else backup.start('type=no-uploads')
    document.getElementById('error').style.display = 'none'
    document.getElementById('success').style.display = 'none'
    document.getElementById('form').style.display = 'none'
    document.getElementById('progress').style.display = 'block'
}


function backupProcess()
{
    var isInit = true,
        proc = {}

    function displayProcess()
    {
        if (proc.status == 'terminated') {
            if (!isInit) {
                if ('error' in proc) {
                    document.getElementById('error').style.display = 'block'
                    document.getElementById('error').innerHTML = '<p>'+proc.error+'</p>'
                } else {
                    document.getElementById('success').style.display = 'block'
                }
            } else {
                document.getElementById('error').style.display = 'none'
                document.getElementById('success').style.display = 'none'
            }
            document.getElementById('form').style.display = 'block'
            document.getElementById('progress').style.display = 'none'
        } else {
            document.getElementById('success').style.display = 'none'
            document.getElementById('error').style.display = 'none'
            document.getElementById('form').style.display = 'none'
            document.getElementById('progress').style.display = 'block'
            document.getElementById('progress').textContent = proc.progress + '%'
            if (proc.progress > 50) {
                document.getElementById('progress').style.color = 'white';
            } else {
                document.getElementById('progress').style.color = '';
            }
            document.getElementById('progress').style.backgroundImage = 
            'linear-gradient(to right, #107710 0%, #107710 '+proc.progress+'%, #F5F0E7 '+proc.progress+'%, #F5F0E7 100%)'
        }

        if (proc.status == 'executing') {
            document.getElementById('action').textContent = proc.action
            document.getElementById('action').style.display = 'block'
        } else {
            document.getElementById('action').style.display = 'none'
        }
        isInit = false
    }

    function fatalError(error)
    {
        document.getElementById('form').style.display = 'block'
        document.getElementById('error').style.display = 'block'
        document.getElementById('error').innerHTML = '<p>'+error+'</p>'
        getProcessStatusRecursive = false
    }

    var maxExecutionTime = <?=ini_get('max_execution_time')?>,
        getProcessStatusUrl = '<?=str_replace('\\', '/', $get_process_status_url)?>',
        getProcessStatusRecursive = true,
        badJsonCounter = 0

    function getProcessStatus() {
        var xhr = new XMLHttpRequest
        xhr.open('GET', getProcessStatusUrl+'?nocache='+Math.random(), true)
        xhr.onload = function() {
            console.log(xhr.responseText)
            if (xhr.responseText != '') {
                try {
                    proc = JSON.parse(xhr.responseText)
                    jsonIsCorrect = true
                    badJsonCounter = 0
                } catch(e) {
                    jsonIsCorrect = false
                    badJsonCounter++
                }
                if (jsonIsCorrect) {
                    if (proc.status == 'executing' && Date.now()/1000 - proc.timestamp > maxExecutionTime*2) {
                        fatalError('Похоже, что предыдущий процесс был прерван. Начните заново.')
                    } else {
                        displayProcess()
                    }
                    if (proc.status == 'terminated') getProcessStatusRecursive = false
                    if (proc.status == 'paused') doBackupProcess()
                } else if (badJsonCounter > 10) {
                    fatalError('Cтатус процесса имеет неверный формат.')
                }
            }
            if (getProcessStatusRecursive) setTimeout(getProcessStatus, 200)
        }
        xhr.onerror = fatalError.bind(null, 'Невозможно получить статус процесса.')
        xhr.send()
    }

    var doBackupUrl = '<?=str_replace('\\', '/', $do_backup_url)?>'
    function doBackupProcess(getParams)
    {
        getParams = getParams ? '?'+getParams : ''
        var xhr = new XMLHttpRequest
        xhr.open('GET', doBackupUrl+getParams, true)
        xhr.onload = function() {
            if (xhr.responseText != '') fatalError(xhr.responseText)
        }
        xhr.onerror = fatalError.bind(null, 'Невозможно запустить процесс.')
        xhr.send()
    }

    this.start = function(getParams) {
        doBackupProcess(getParams)
        getProcessStatusRecursive = true
        setTimeout(getProcessStatus, 200)
    }

    getProcessStatus()
}
</script>