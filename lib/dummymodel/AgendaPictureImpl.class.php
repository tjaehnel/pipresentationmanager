<?php
require_once dirname(__FILE__).'/AgendaImpl.class.php';
require_once dirname(__FILE__).'/../model/AgendaPicture.class.php';

class AgendaPictureImpl extends AgendaImpl implements AgendaPicture {
	private $imageFilename;
	
	public function __construct($title, $imageFilename) {
		parent::__construct($title);
		$this->imageFilename = $imageFilename;
	}
	
	public function getImageFilename() {
		return $this->imageFilename;
	}
}
