<?php


class controller_addon_core_codemirror extends addon  {

	public function action_index() {

		$this->page['head']  = "\t\t<!-- START codemirror -->\n";
		
		$this->page['head'] .= $this->add_css_file(SITE_URL . '/user_cms/modules/addons/codemirror/source/codemirror.css?v=3.11') ;
		$this->page['head'] .= $this->add_js_file (SITE_URL . '/user_cms/modules/addons/codemirror/source/codemirror-compressed.js?v=3.11') ;

		$this->page['head'] .= $this->add_js('

			$(document).ready(function() {
				if ($("#code_editor").length) {
					var c_editor = CodeMirror.fromTextArea(document.getElementById("code_editor"), {
				        mode: "text/html",
				        theme: "blackboard",
				        lineNumbers: true
				    });
				}	
			});

		') ;

		$this->page['head']  .= "\t\t<!-- END codemirror -->\n";
		return $this->page;
	}

}