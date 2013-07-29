<?php
require_once dirname(__FILE__).'/ViewEditor.class.php';
require_once dirname(__FILE__).'/ViewPictureEditorRpc.class.php';

class ViewPictureEditor extends ViewEditor {

	public function getEditorId() {
		return "pictureEditor";
	}
	
	public function getHTML() {
		return $this->getEditorHtml();
	}
	
	public function getFormHtml() {
		ob_start();
		require dirname(__FILE__).'/ViewPictureEditor.tpl.php';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
	
	public function getJavaScript() {
		ob_start();
		require dirname(__FILE__).'/ViewPictureEditor.js';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;		
	}
	
	public function getCSS() {
		ob_start();
		require dirname(__FILE__).'/ViewPictureEditor.css';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
	
	public function getRpcClass() {
		return new ViewPictureEditorRpc($this->model);
	}
}
