<?php
require_once dirname(__FILE__).'/JsonAgendaItem.class.php';
require_once dirname(__FILE__).'/../model/AgendaPicture.class.php';

class JsonAgendaPicture extends JsonAgendaItem implements AgendaPicture {
	private $imageFilename;
	private $imageText;
	
	public function __construct($agendaObj, $itemData = null) {
		parent::__construct($agendaObj, $itemData);
	}
	
	protected function createEmpty() {
		parent::createEmpty();
		$this->imageFilename = "";
	}
	
	protected function applyJsonDecodedData($itemData) {
		parent::applyJsonDecodedData($itemData);
		$this->imageFilename = $itemData['imageFilename'];
		$this->imageText = $itemData['imageText'];
	}
	
	/**
	 * @see JsonSerializable::jsonSerialize()
	 * Since the JsonSerializable interface is not available in
	 * PHP < 5.4 this class does not 'implement' it but only provides
	 * the method of this interface
	 */
	public function jsonSerialize() {
		$itemData = parent::jsonSerialize();
		$itemData['imageFilename'] = $this->imageFilename;
		$itemData['imageText'] = $this->imageText;
		return $itemData;
	}
	
	public function getImageFilename() {
		return $this->imageFilename;
	}
	
	public function setImageFilename($imageFilename) {
		$this->imageFilename = $imageFilename;
		$this->agendaObj->saveData();
	}
	
	public function getImageText() {
		return $this->imageText;
	}
	
	public function setImageText($imageText) {
		$this->imageText = $imageText;
		$this->agendaObj->saveData();
	}
}
