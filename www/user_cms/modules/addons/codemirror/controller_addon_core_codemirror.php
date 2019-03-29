<?php


class controller_addon_core_codemirror extends addon  {

	public function action_index() {

		$this->page['head']  = "\t\t<!-- START codemirror -->\n";
		
		$this->page['head'] .= $this->add_css_file(SITE_URL . '/user_cms/modules/addons/codemirror/source/codemirror.css?v=5.40.2') ;
		$this->page['head'] .= $this->add_js_file (SITE_URL . '/user_cms/modules/addons/codemirror/source/codemirror.js?v=5.40.2') ;
		$this->page['head'] .= $this->add_css_file('https://codemirror.net/theme/blackboard.css') ;
		$this->page['head'] .= $this->add_js_file ('https://codemirror.net/mode/xml/xml.js') ;
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
