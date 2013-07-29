<?php
require_once dirname(__FILE__).'/ImageProcessing.class.php';

class PreviewImageProcessing extends ImageProcessing {
	const TARGET_WIDTH = 450;
	const TARGET_HEIGHT = 253;
	const TARGET_QUALITY = 90;
	const CACHE_SUBDIR = 'preview';
	
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