<?
/**
 * Do not modify the default.config.php file, instead, override the settings in the config.php file
 */

$config = [
    'datetimeFormat' => 'm/d/Y g:i A',
    'quality' => 90,
    'defaultPermission' => 0775,

    'sources' => [
        'default' => [],
    ],

    'createThumb' => false,
    'thumbFolderName' => '_thumbs',
    'excludeDirectoryNames' => ['.tmb', '.quarantine'],
    'maxFileSize' => '8mb',

    'allowCrossOrigin' => false,
    'allowReplaceSourceFile' => true,

    'baseurl' => '/uploads/',
    'root' => realpath(realpath(dirname(dirname(dirname(dirname(dirname(__FILE__))))).DIRECTORY_SEPARATOR.'..').DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR). DIRECTORY_SEPARATOR,
    'extensions' => ['jpg', 'png', 'gif', 'jpeg', 'xls', 'xlsx', 'pdf', 'doc', 'docx', 'odt', 'zip', 'txt', 'ppt', 'pptx'],
    'imageExtensions' => ['jpg', 'png', 'gif', 'jpeg'],

	'debug' => JODIT_DEBUG,
	'accessControl' => []
];


$config['roleSessionVar'] = 'JoditUserRole';

$config['accessControl'][] = array(
	'role'                => '*',

	'extensions'          => '*',
	'path'                => '/',

	'FILES'               => true,
	'FILE_MOVE'           => true,
	'FILE_UPLOAD'         => true,
	'FILE_UPLOAD_REMOTE'  => true,
	'FILE_REMOVE'         => true,
	'FILE_RENAME'         => true,

	'FOLDERS'             => true,
	'FOLDER_MOVE'         => true,
	'FOLDER_REMOVE'       => true,
	'FOLDER_RENAME'       => true,

	'IMAGE_RESIZE'        => true,
	'IMAGE_CROP'          => true,
);

$config['accessControl'][] = array(
	'role'                => '*',

	'extensions'          => 'exe,bat,com,sh,swf',

	'FILE_MOVE'           => false,
	'FILE_UPLOAD'         => false,
	'FILE_UPLOAD_REMOTE'  => false,
	'FILE_RENAME'         => false,
);

return $config;