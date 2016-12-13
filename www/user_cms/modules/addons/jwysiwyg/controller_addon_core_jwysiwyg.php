<?php
class controller_addon_core_jwysiwyg extends addon {
	function action_index() {


    $this->page['head']  = '<!-- START jodit editor  -->' . "\n\t";
    $this->page['head'] .= $this->add_css_file(SITE_URL . '/user_cms/modules/addons/jwysiwyg/jodit.min.css'). "\n\t";
    $this->page['head'] .= $this->add_js_file(SITE_URL . '/user_cms/modules/addons/jwysiwyg/jodit.min.js'). "\n\t";
    $this->page['head'] .= $this->add_js(

    "$(document).ready(function() { 
		new Jodit('.wysiwyg', {
		        uploader: {
		            url: '" . SITE_URL . "/user_cms/modules/addons/jwysiwyg/connector.php?action=upload'
		        },
		        filebrowser: {
		            ajax: {
		                url: '" . SITE_URL . "/user_cms/modules/addons/jwysiwyg/connector.php'
		            },
		        },
		        language: 'ru'   ,
		        minHeight: 350
		    });

	 });"

    ) 

    . "\n\t";
    


    $this->page['head'] .= '<!-- END jodit editor -->' . "\n\t";


		
		return $this->page;
	}

} 