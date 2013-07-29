<?php
require_once dirname(__FILE__).'/ViewFilePicker.class.php';
require_once dirname(__FILE__).'/ViewPictureFilePickerRpc.class.php';

/**
 * Show a modal dialog to select from a list of files
 * @author tobias
 *
 */
class ViewPictureFilePicker extends ViewFilePicker {

	public function getHTML() {
		return "";
	}
	
	public function getCSS() {
		return "";
	}
	
	public function getJavaScript() {
		ob_start();
		require_once dirname(__FILE__).'/ViewPictureFilePicker.js';
		$return = ob_get_contents();
		ob_end_clean();
		return $return;
	}
	
	public function getRpcClass() {
		return new ViewPictureFilePickerRpc(
				$this->model, $this->directory);
	}

}
