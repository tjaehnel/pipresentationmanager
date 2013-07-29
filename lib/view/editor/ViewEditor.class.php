<?php
require_once dirname(__FILE__).'/../View.class.php';
require_once dirname(__FILE__).'/../../model/PpmModelRoot.class.php';

class ViewEditor implements View {
	
	protected $model;
	
	public function __construct(PpmModelRoot $model) {
		$this->model = $model;
	}
	public function getHTML() {
		return "";
	}
	public function getEditorHtml() {
		ob_start();
		require dirname(__FILE__).'/ViewEditor.tpl.php';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
	
	public function getJavaScript() {
		ob_start();
		require dirname(__FILE__).'/ViewEditor.js';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
	
	public function getCSS() {
		ob_start();
		require dirname(__FILE__).'/ViewEditor.css';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
	
	public function getEditorId() {
		"";
	}
	
	public function getFormHtml() {
		return "";
	}
	
	public function getRpcClass() {
		return null;
	}
}