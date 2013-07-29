<?php
require_once dirname(__FILE__).'/../View.class.php';
require_once dirname(__FILE__).'/ViewFilePickerRpc.class.php';
require_once dirname(__FILE__).'/../../model/PpmModelRoot.class.php';


/**
 * Show a modal dialog to select from a list of files
 * @author tobias
 *
 */
class ViewFilePicker implements View {
	protected $model;
	protected $directory;
	
	public function __construct(PpmModelRoot $model) {
		$this->model = $model;
		$this->directory = DATA_DIR;
	}
	
	public function getHTML() {
		ob_start();
		require_once dirname(__FILE__).'/ViewFilePicker.tpl.php';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
	
	public function getCSS() {
		require dirname(__FILE__).'/ViewFilePicker.css';
	}
	
	public function getJavaScript() {
		ob_start();
		require_once dirname(__FILE__).'/ViewFilePicker.js';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
	
	public function getRpcClass() {
		return new ViewFilePickerRpc(
				$this->model, $this->directory);
	}
}