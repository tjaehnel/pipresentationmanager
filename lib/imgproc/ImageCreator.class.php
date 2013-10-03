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
	const CONFIG_EXTENSION = '.json';
	
	/**
	 * Return the given image prepared for the given purpose
	 * @param String $filename plain filename without path
	 * @param ImagePurpose $purpose @see ImagePurpose
	 * @param String $datadir Location of source images (optional)
	 * @param String $cachedir Cache for processed images
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
	
	/**
	 * Return the configuration for the given image,
	 * read from a configuration file located next to it.
	 * Returns null if there is none.
	 * @param String $filename plain filename without path
	 * @param String $datadir Location of source images (optional)
	 * @return Array JSON decoded configuration data, or null
	 */
	public function getImageConfiguration($filename, $datadir = self::DATA_DIR)
	{
		$configFilename = self::getConfigFilenameFromImage($filename);
		
		$jsonData = file_get_contents(self::DATA_DIR.'/'.$configFilename);
		if($jsonData === false)
		{
			return null;
		}
		
		$decodedConfig = json_decode($jsonData, true);
		return $decodedConfig;
	}
	
	protected static function getConfigFilenameFromImage($imageFilename) {
		$dotPosition = strrpos($imageFilename, '.');
		$configFilename = substr($imageFilename, 0, $dotPosition);
		$configFilename .= self::CONFIG_EXTENSION;
		return $configFilename;
	}
	
	public static function getInstance() {
		if(!self::$instance)
		{
			self::$instance = new ImageCreator();
		}
		return self::$instance;
	}
}