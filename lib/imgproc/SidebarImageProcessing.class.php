<?php
require_once dirname(__FILE__).'/ImageProcessing.class.php';

class SidebarImageProcessing extends ImageProcessing {
	const TARGET_WIDTH = 128;
	const TARGET_HEIGHT = 72;
	const TARGET_QUALITY = 70;
	const CACHE_SUBDIR = 'sidebar';
	
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