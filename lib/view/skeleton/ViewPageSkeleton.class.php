<?php
require_once dirname(__FILE__).'/../View.class.php';
require_once dirname(__FILE__).'/../../model/PpmModelRoot.class.php';
class ViewPageSkeleton implements View {
	
	protected $model;
	
	public function __construct(PpmModelRoot $model) {
		$this->model = $model;
	}
	public function getHTML() {
		ob_start();
		require dirname(__FILE__).'/ViewPageSkeleton.tpl.php';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
	
	public function getJavaScript() {
		ob_start();
		require dirname(__FILE__).'/ViewPageSkeleton.js';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
	
	public function getCSS() {
		ob_start();
		require dirname(__FILE__).'/ViewPageSkeleton.css';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
		
	public function getRpcClass() {
		return null;
	}
}