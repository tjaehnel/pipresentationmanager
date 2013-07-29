<?php
require_once dirname(__FILE__).'/ImageProcessing.class.php';

class HdImageProcessing extends ImageProcessing {
	const TARGET_WIDTH = 1920;
	const TARGET_HEIGHT = 1080;
	const TARGET_QUALITY = 90;
	const CACHE_SUBDIR = 'hd';
	
	protected function getCacheSubdir() {
		return self::CACHE_SUBDIR;
	}

	protected function getTargetJPEGQuality() {
		return self::TARGET_QUALITY;
	}
	
	protected function performImageProcessing() {
		$scaledImage = self::getGdImageScaledTo($this->gdImage,
				self::TARGET_WIDTH,
				self::TARGET_HEIGHT);
		
		imagedestroy($this->gdImage);
		$this->gdImage = $scaledImage;
	}
}