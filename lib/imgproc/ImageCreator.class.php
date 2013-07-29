<?php
require_once dirname(__FILE__).'/ImagePurpose.class.php';
require_once dirname(__FILE__).'/HdImageProcessing.class.php';
require_once dirname(__FILE__).'/SidebarImageProcessing.class.php';
require_once dirname(__FILE__).'/PreviewImageProcessing.class.php';
require_once dirname(__FILE__).'/UnknownPurposeException.class.php';

/**
 * This class essentially retrieves the data
 * of the given image specific for a particular purpose.
 * If necessary, it performs some image processing on the
 * original picture before.
 * 
 * Singleton class
 * 
 * @author tobias
 *
 */
class ImageCreator {
	
	private static $instance = NULL;
	
	const DATA_DIR = 'data';
	const CACHE_DIR = 'cache';
	
	/**
	 * @param String $filename
	 * @param ImagePurpose $purpose
	 * @return String Image data, ready to send to the browser
	 */
	public function getImageForPurpose($filename, $purpose,
			$datadir = self::DATA_DIR, $cachedir = self::CACHE_DIR)
	{
		$imgProc = NULL;
		switch ($purpose)
		{
			case ImagePurpose::HD:
				$imgProc = new HdImageProcessing($filename, $datadir, $cachedir);
				break;
			case ImagePurpose::Sidebar:
				$imgProc = new SidebarImageProcessing($filename, $datadir, $cachedir);
				break;
			case ImagePurpose::Preview:
				$imgProc = new PreviewImageProcessing($filename, $datadir, $cachedir);
				break;
			default:
				throw new UnknownPurposeException("No implementation for image purpose: ".$purpose);
		}
		$imgString = $imgProc->getProcessedImage();
		return $imgString;
	}
	
	public static function getInstance() {
		if(!self::$instance)
		{
			self::$instance = new ImageCreator();
		}
		return self::$instance;
	}
}