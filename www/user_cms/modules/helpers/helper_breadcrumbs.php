<?php 
class helper_breadcrumbs {
	private $data = array();
	
	public function add($name, $href = '/') {
		if(is_array($name) && is_array($href)){
			foreach ($name as $key => $value) {
				$this->add($value, $href[$key]);
			}
		}else{
			$this->data[] = array(
				'name' => $name,
				'href' => $href
			);
		}
	}
	
	public function render() {
		$html = 
		'<nav aria-label="breadcrumb">
			<ol class="breadcrumb">';
				foreach ($this->data as $key => $value) {
					if (($key+1) == count($this->data)) {
						$html .= '<li class="breadcrumb-item active" aria-current="page">' . $value['name'] . '</li>';
					}else{
						$html .= '<li class="breadcrumb-item"><a href="' . $value['href'] . '">' . $value['name'] . '</a></li>';
					}
				}
		$html .= 	
			'</ol>
		</nav>';
		return $html;
	}

	public function make_breadcrumbs($name, $href = '/'){
		$this->add($name, $href);
		return $this->render();
	}
}
