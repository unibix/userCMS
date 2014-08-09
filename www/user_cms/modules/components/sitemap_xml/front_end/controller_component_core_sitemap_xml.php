<?php 

class controller_component_core_sitemap_xml extends component {
	

	public function action_index() {
	
		$sitemap = simplexml_load_string('<?xml version="1.0" encoding="UTF-8" ?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

</urlset>
');

	$this->load_model('component', 'sitemap');

	$results = $this->model_component_sitemap->get_pages();
	foreach ($results as $result) {
	    $elem = $sitemap->addChild('url');
	    $elem->loc = $result['url'] ;
	}

		echo $sitemap->asXML();
		exit();
	}
}