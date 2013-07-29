<?php
require_once dirname(__FILE__).'/ViewFilePickerRpc.class.php';
require_once dirname(__FILE__).'/../../imgproc/ImagePurpose.class.php';

class ViewMovieFilePickerRpc extends ViewFilePickerRpc {
	public function getMovies() {
		$fileList = array();
		$imageInfo = array();
		
		$handler = opendir($this->directory);
		while ($file = readdir($handler)) {
			if (strtolower(substr($file, -4)) == ".mp4" ){
				$fileList[] = $file;
			}
		}
		
		closedir($handler);
		
		sort($fileList, SORT_LOCALE_STRING);
		foreach ($fileList as $file) {
			$imageInfo[] = array(
					'thumbnail' => BASEURL.'img/Video_sidebar.png',
					'title' => $file
			);
		}

		return $imageInfo;
	}
}
