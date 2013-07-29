<?php
require_once dirname(__FILE__).'/ViewFilePickerRpc.class.php';
require_once dirname(__FILE__).'/../../imgproc/ImagePurpose.class.php';

class ViewPictureFilePickerRpc extends ViewFilePickerRpc {
	public function getImages() {
		$fileList = array();
		$imageInfo = array();
		
		$handler = opendir($this->directory);
		while ($file = readdir($handler)) {
			if (strtolower(substr($file, -4)) == ".jpg"
					|| strtolower(substr($file, -5)) == ".jpeg" ) {
				$fileList[] = $file;
			}
		
		}
		closedir($handler);
		
		sort($fileList, SORT_LOCALE_STRING);
		foreach ($fileList as $file) {
			$imageInfo[] = array(
				'thumbnail' => 'img.php?filename='.$file
				.'&purpose='.ImagePurpose::Sidebar,
				'title' => $file
			);
		}

		
		return $imageInfo;
	}
}
