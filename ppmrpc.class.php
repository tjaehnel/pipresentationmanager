<?php
//require_once dirname(__FILE__).'/lib/dummymodel/PpmModelRootImpl.class.php';
//require_once dirname(__FILE__).'/lib/jsonmodel/JsonModelRoot.class.php';
require_once dirname(__FILE__).'/lib/imgproc/ImagePurpose.class.php';
require_once dirname(__FILE__).'/lib/pipresentsexporter/PiPresentsExporter.class.php';

class PpmRpc {
	
	private $model;
	
	public function __construct($model) {
		$this->model = $model;
	}

	
	public function ping($msg) {
		return "pong: " . $msg;
	}
	
}