<?php 
class helper_breadcrumbs {
	private $data = array();
	public $separator = '&#8260;';
	
	public function add($name, $href = '/') {
		$this->data[] = array(
			'name' => $name,
			'href' => $href
		);
	}
	
	public function render() {
		$html = '';
		foreach ($this->data as $key => $value) {
			$html .= '<a href="' . $value['href'] . '">' . $value['name'] . '</a>';
			if (($key+1) < count($this->data)) {
				$html .= ' ' . $this->separator . ' ';
			}
		}
		return $html;
	}
}
