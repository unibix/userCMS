<?php 
$data = array(
	'name' => '301 редирект',
	'type' => 'addon',
	'version' => '1.0',
	'dir'     => 'redirect_301',
	'description' => '
Пример: 
/old_url.html|/ne_url.html
/catalog|/katalog
/contacts.html|/kontakty.html'
);

if($this->model->install_module($data)) {
	$this->data['message'] = 'Аддон Redirect 301 успешно установлен';
} else {
	$this->data['errors'] = 'В ходе установки произошла ошибка';
}
 ?>