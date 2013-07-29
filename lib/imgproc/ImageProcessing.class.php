<?php
require_once dirname(__FILE__).'/ImagePurpose.class.php';
require_once dirname(__FILE__).'/ImgNotExistsException.class.php';

/**
 * Perform image processing specific to the PiPresents Manager
 * using the GD library.
 * 
 * NOTE: Currently only JPEG images are supported.
 * 
 * @author tobias
 *
 */
abstract class ImageProcessing {

	protected $inputFilename;
	protected $cacheFilename;
	protected $gdImage;
	
	public function __construct($filename, $inputDir, $cacheDir) {
		$this->inputFilename = $inputDir . '/' . $filename;
		$this->cacheFilename = $cacheDir . '/'
				. $this->getCacheSubdir() . '/' . $filename;
	}
	
	protected abstract function getCacheSubdir();
	
	public function getProcessedImage() {		
		if(!file_exists($this->inputFilename))
		{
			throw new ImgNotExistsException("Input file '".$this->inputFilename."' does not exist");
		}
		
		if(!file_exists($this->cacheFilename))
		{
			$this->generateAndCacheImage();
		}
		elseif(filectime($this->inputFilename) >= filectime($this->cacheFilename))
		{
			$this->generateAndCacheImage();
		}
		return file_get_contents($this->cacheFilename);
	}
	
	protected function generateAndCacheImage() {
		$this->gdImage = imagecreatefromjpeg($this->inputFilename);
		$this->performImageProcessing();
		self::createParentDirectoryIfNotExists($this->cacheFilename);
		imagejpeg($this->gdImage, $this->cacheFilename, $this->getTargetJPEGQuality());
		imagedestroy($this->gdImage);
	}
	
	protected static function createParentDirectoryIfNotExists($filename) {
		$dir = dirname($filename);
		mkdir($dir, 0777, true);
	}
	
	/**
	 * Perform the actual implementation specific modifications
	 * of the picture. Use $this->gdImage as in- and output 
	 */
	protected abstract function performImageProcessing();
	protected abstract function getTargetJPEGQuality();
	
	protected static function getGdImageScaledTo($image, $width, $height) {
		$crntWidth = imagesx($image);
		$crntHeight = imagesy($image);

		list($cutoutX, $cutoutY, $cutoutWidth, $cutoutHeight) =
			self::calculateCutoutDimensions($crntWidth, $crntHeight, $width, $height);
		
		$dstImage = imagecreatetruecolor($width, $height);
		imagecopyresampled($dstImage, $image, 0, 0, $cutoutX, $cutoutY,
			$width, $height, $cutoutWidth, $cutoutHeight);
		
		return $dstImage;
	}
	
	/**
	 * Calculate the largest section inside an image of size
	 * $crntWidth x $crntHeight that preserves the
	 * aspect ratio implied by $desiredWidth x $desiredHeight
	 * Largest section means, that EITHER the width OR the height is
	 * tailored to fit the aspect ratio.
	 * The cut out area always remains centered 
	 * 
	 * @return array dimensions of area to cut out ($pos_x, $pos_y, $width, $height)
	 */
	protected static function calculateCutoutDimensions($crntWidth, $crntHeight, $desiredWidth, $desiredHeight)
	{
		$aspectRatio = (float)$desiredWidth / (float)$desiredHeight;
		
		// try fitting height first
		$cutoutHeight = $crntHeight;
		$cutoutWidth = (float)$crntHeight * $aspectRatio;		
		// if the image is too small in width, try fitting width
		if ($cutoutWidth > $crntWidth)
		{
			$cutoutWidth = $crntWidth;
			$cutoutHeight = (float)$crntWidth / $aspectRatio;
		}
		
		$cutoutX = ($crntWidth - $cutoutWidth) / 2;
		$cutoutY = ($crntHeight - $cutoutHeight) / 2;
		
		return array($cutoutX, $cutoutY, $cutoutWidth, $cutoutHeight);
	}
}
