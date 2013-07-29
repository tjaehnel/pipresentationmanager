<?php
require_once dirname(__FILE__).'/ViewEditor.class.php';
require_once dirname(__FILE__).'/ViewMovieEditorRpc.class.php';

class ViewMovieEditor extends ViewEditor {

	public function getEditorId() {
		return "movieEditor";
	}
	
	public function getHTML() {
		return $this->getEditorHtml();
	}
	
	public function getFormHtml() {
		ob_start();
		require dirname(__FILE__).'/ViewMovieEditor.tpl.php';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
	
	public function getJavaScript() {
		ob_start();
		require dirname(__FILE__).'/ViewMovieEditor.js';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;		
	}
	
	public function getCSS() {
		ob_start();
		require dirname(__FILE__).'/ViewMovieEditor.css';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
	
	public function getRpcClass() {
		return new ViewMovieEditorRpc($this->model);
	}
}
