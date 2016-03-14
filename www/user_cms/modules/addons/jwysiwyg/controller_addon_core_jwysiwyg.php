<?php 
class controller_addon_core_jwysiwyg extends addon {
	public function action_index() {
		$this->page['head'] = "\t\t<!-- jWysiwyg START -->\n";
		$this->page['head'] .= $this->add_js_file(SITE_URL . '/user_cms/modules/addons/jwysiwyg/source/jquery.wysiwyg.js');
		// Дополнительные плагины
		$this->page['head'] .= $this->add_js_file(SITE_URL . '/user_cms/modules/addons/jwysiwyg/source/plugins/farbtastic/farbtastic.js');
		$this->page['head'] .= $this->add_css_file(SITE_URL . '/user_cms/modules/addons/jwysiwyg/source/plugins/farbtastic/farbtastic.css');
		$this->page['head'] .= $this->add_css_file(SITE_URL . '/user_cms/modules/addons/jwysiwyg/source/jquery.wysiwyg.css');
		$this->page['head'] .= $this->add_js_file(SITE_URL . '/user_cms/modules/addons/jwysiwyg/source/controls/wysiwyg.image.js');
		$this->page['head'] .= $this->add_js_file(SITE_URL . '/user_cms/modules/addons/jwysiwyg/source/controls/wysiwyg.colorpicker.js');
		$this->page['head'] .= $this->add_js_file(SITE_URL . '/user_cms/modules/addons/jwysiwyg/source/controls/wysiwyg.table.js');
		$this->page['head'] .= $this->add_js_file(SITE_URL . '/user_cms/modules/addons/jwysiwyg/source/controls/wysiwyg.cssWrap.js');
		$this->page['head'] .= $this->add_js_file(SITE_URL . '/user_cms/modules/addons/jwysiwyg/source/controls/wysiwyg.link.js');
		$this->page['head'] .= $this->add_js_file(SITE_URL . '/user_cms/modules/addons/jwysiwyg/source/controls/wysiwyg.msWordFormatPopup.js');
		// Файловый менеджер
		$this->page['head'] .= $this->add_js_file(SITE_URL . '/user_cms/modules/addons/jwysiwyg/source/plugins/wysiwyg.fileManager.js');
		$this->page['head'] .= $this->add_css_file(SITE_URL . '/user_cms/modules/addons/jwysiwyg/source/plugins/fileManager/wysiwyg.fileManager.css');
		
		$this->data['handler_url'] = SITE_URL . '/user_cms/modules/addons/jwysiwyg/source/handlers/file-manager.php';
		
		$this->page['head'] .= $this->load_view();
		
		$this->page['head'] .= "\t\t<!-- jWysiwyg END -->\n";
		
		return $this->page;
	}
	
	public function action_activate() {
		
	}
	
	public function action_deactivate() {
		
	}
	
	public function action_settings() {
		
	}
}