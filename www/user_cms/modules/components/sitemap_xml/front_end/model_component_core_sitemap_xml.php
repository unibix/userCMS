<?php 
/*
* main component's model
*/

class model_component_core_sitemap_xml {

	public $dbh;
	
	function __construct($dbh){
		$this->dbh = $dbh;
	}
	
	public function get_urls(){
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
	}
}