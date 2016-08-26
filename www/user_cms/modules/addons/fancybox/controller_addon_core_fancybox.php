<?php


class controller_addon_core_fancybox extends addon  {

	function action_index() {

		$this->page['head']  = "\t\t<!-- START fancybox -->\n";
		
		$this->page['head'] .= $this->add_js_file (SITE_URL . '/user_cms/modules/addons/fancybox/source/jquery.fancybox.pack.js?v=2.1.5') ;
		
		$this->page['head'] .= $this->add_css_file(SITE_URL . '/user_cms/modules/addons/fancybox/source/jquery.fancybox.css?v=2.1.5') ;
		
		$this->page['head'] .= $this->add_js("\t\t" . '$(document).ready(function(){$(".fancybox").fancybox({openEffect:"elastic",openSpeed:450,closeEffect:"elastic",closeSpeed:250,nextClick:!0,helpers:{title:{type:"over"}}})});' ) ;

		$this->page['head']  .= "\t\t<!-- END fancybox -->\n";
		return $this->page;
	}

	
	function action_delete() {
		$this->page['html'] = 'Удаление запрещено';
		return $this->page;
	}

}