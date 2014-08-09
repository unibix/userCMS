<?php 
/*
* main component's model
*/

class model_component_core_sitemap {

	public $dbh;
	
	function __construct($dbh){
		$this->dbh = $dbh;
	}
	
	public function get_pages($parent_id = 0, $parent_url = '/', $level = 0){
		static $retval = array();
		
		$sql = "SELECT * FROM main 
					WHERE parent_id = '" . (int)$parent_id . "' AND url != 'sitemap2.xml' 
					ORDER BY id ASC";

		$results = $this->dbh->query($sql);

		foreach($results as $result){
			if ($result['url'] != '/') {
				$retval[] = array(
					'name' => $result['name'],
					'url'  => SITE_URL . $parent_url . $result['url'],
					'lvl'  => $level
				);

				$this->get_pages($result['id'], $parent_url . $result['url'] . '/', $level + 1);
			} else {
				$retval[] = array(
					'name' => 'Главная страница',
					'url'  => SITE_URL,
					'lvl'  => $level
				);
			}
		}
		
		return $retval;
	}

	/*public function get_urls(){
		$sql = "SELECT url FROM main m ";
		$sql .= " WHERE m.parent_id = '0' ";
		$sql .= " ORDER BY m.id DESC";
		$results = $this->dbh->query($sql);
		//core::print_r($results);
		
		$urls[] = '/';
		foreach($results as $value){
			if($value['url'] != '/' AND $value['url'] != 'sitemap.xml') {
				$urls[] = '/' . $value['url'];
			}
		}
		return $urls;
	}*/
}