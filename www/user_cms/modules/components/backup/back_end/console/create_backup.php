<?php
if (php_sapi_name() != 'cli') die('Этот скрипт предназначен для вызова через консоль!');
$args = getopt('', array('file:', 'full'));
if (!isset($args['file'])) die ('Не указан путь к файлу бэкапа (параметр --file)');
define('BACKUP_FILE', $args['file']);
define('IS_FULL', isset($args['full']));
define('ROOT_DIR', getcwd());
define('OUTPUT', __DIR__.'/output.txt');

function setOutput($str) {
    file_put_contents(OUTPUT, $str);
}

function getList($dir) {
    $files = scandir($dir);
    $list = array();
    foreach ($files as $f) {
        if ($f == '.' || $f == '..') continue;

        if (
            ($dir == ROOT_DIR && $f == 'temp') ||
            ($dir == ROOT_DIR && $f == 'uploads' && !IS_FULL)
        ) {
            $f = $dir.'/'.$f;
            $list[] = $f;
            continue;
        }

        $f = $dir.'/'.$f;
        $list[] = $f;
        if (is_dir($f)) {
            $innerList = getList($f);
            foreach ($innerList as $innerFile) $list[] = $innerFile;
        }
    }
    return $list;
}

setOutput('PREPARING_LIST_FILES');
$list = getList(ROOT_DIR);
$count = count($list);

$zip = new ZipArchive();
$zip->open(BACKUP_FILE, ZipArchive::CREATE);

$progress = '0';
setOutput('0');
foreach ($list as $i => $name) {
    $zipName = str_replace(ROOT_DIR, '', $name);

    if (is_dir($list[$i])) {
        $zip->addEmptyDir($zipName);
    } elseif (pathinfo($name, PATHINFO_EXTENSION) == 'php_') {
        $zip->addFile($name, 'install.php');
    } else {
        $zip->addFile($name, $zipName);
    }

    $p = sprintf('%.1f', 100*$i/$count);
    if ($p != $progress) {
        $progress = $p;
        setOutput($progress);
    }
    usleep(10000);
}
setOutput('COMPRESSING');
$zip->close();
setOutput('FINISHED');