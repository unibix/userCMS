<?php
class controller_addon_core_jodit extends addon {
	function action_index() {
    $this->page['head']  = '<!-- START jodit editor  -->' . "\n\t";
    $this->page['head'] .= $this->add_css_file(SITE_URL . '/user_cms/modules/addons/jodit/jodit.min.css'). "\n\t";
    $this->page['head'] .= $this->add_js_file(SITE_URL . '/user_cms/modules/addons/jodit/jodit.min.js'). "\n\t";
    $this->page['head'] .= $this->add_js(
    "$(document).ready(function() {
		if($('textarea').is('.wysiwyg')){
			new Jodit('.wysiwyg', {
		        uploader: {
		            url: '" . SITE_URL . "/user_cms/modules/addons/jodit/connector/index.php?action=fileUpload'
		        },
		        filebrowser: {
		            ajax: {
		                url: '" . SITE_URL . "/user_cms/modules/addons/jodit/connector/index.php',
		            }
		        },
		        minHeight: 350
		    });
		}
	 });"

    ) 

    . "\n\t";
   
    $this->page['head'] .= '<!-- END jodit editor -->' . "\n\t";
		return $this->page;
	}

} 