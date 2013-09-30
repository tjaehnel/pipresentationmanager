<?php
require_once dirname(__FILE__).'/viewRegistration.php';
require_once dirname(__FILE__).'/imgproc/ImageCreator.class.php';
require_once dirname(__FILE__).'/imgproc/ImgNotExistsException.class.php';
require_once dirname(__FILE__).'/imgproc/ImgProcException.class.php';
require_once dirname(__FILE__).'/jsonRPC2Server.php';
require_once dirname(__FILE__).'/../ppmrpc.class.php';

class WebInterface {
	private function __construct() {}
	
	public static function sendJavaScript() {
		global $viewRegistration;
		header("Content-Type: text/javascript");
		foreach ($viewRegistration as $crntView) {
			echo $crntView->getJavaScript();
			echo "\n";
		}
	}
	
	public static function sendCSS() {
		global $viewRegistration;
		header("Content-Type: text/css");
		echo '@CHARSET "UTF-8";'."\n";
		foreach ($viewRegistration as $crntView) {
			echo $crntView->getCSS()."\n";
		}
	}
	
	public static function sendImg() {
		if(!isset($_GET['filename']) || $_GET['filename'] == "")
		{
			header('content-type: image/jpeg');
			$imgdata = ImageCreator::getInstance()->getImageForPurpose(
					'notfound.jpg', $purpose, dirname(__FILE__).'/../img');
			echo $imgdata;
			exit();
		}
		$filename = htmlentities($_GET['filename']);
		
		if(isset($_GET['config']))
		{
			self::sendImgConfigData($filename);
		}
		else 
		{
			if(!isset($_GET['purpose']) || !is_numeric($_GET['purpose']))
			{
				header($_SERVER['SERVER_PROTOCOL'].' Internal Server Error');
				header('X-Error_message: Invalid script parameters');
				exit(1);
			}
			$purpose = htmlentities($_GET['purpose']);
			
			self::sendImgData($filename, $purpose);
		}		
	}

	protected static function sendImgConfigData($filename) {
		$imgConfig = ImageCreator::getInstance()
			->getImageConfiguration($filename, DATA_DIR);
		$jsonImgConfig = json_encode($imgConfig);
		header('content-type: application/json');
		echo $jsonImgConfig;
	}
	
	protected static function sendImgData($filename, $purpose) {
		try {
			$imgdata = ImageCreator::getInstance()->getImageForPurpose(
					$filename, $purpose, DATA_DIR, CACHE_DIR);
			header('content-type: image/jpeg');
			echo $imgdata;
		} catch (ImgNotExistsException $e) {
			header('content-type: image/jpeg');
			$imgdata = ImageCreator::getInstance()->getImageForPurpose(
					'notfound.jpg', $purpose, dirname(__FILE__).'/../img');
			echo $imgdata;
		} catch (ImgProcException $e) {
			header($_SERVER['SERVER_PROTOCOL'].' Internal Server Error');
			header('X-Error_message: ' . $e->getMessage());
		}
	}
	
	public static function handleRpc() {
		global $model, $viewRegistration;
		$jsonRpc = new jsonRPCServer();
		
		foreach ($viewRegistration as $crntView) {
			$rpcClass = $crntView->getRpcClass();
			if($rpcClass) {
				$jsonRpc->registerClass($rpcClass);
			}
		}
		
		$jsonRpc->handle() or die('no request');
	}
}
