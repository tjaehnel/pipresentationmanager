<?php
require_once dirname(__FILE__).'/JsonAgendaItem.class.php';
require_once dirname(__FILE__).'/JsonFontFace.class.php';
require_once dirname(__FILE__).'/JsonXYPosition.class.php';
require_once dirname(__FILE__).'/../model/AgendaPicture.class.php';

class JsonAgendaPicture extends JsonAgendaItem implements AgendaPicture {
	private $imageFilename;
	private $imageText;
	private $imageTextFontFace;
	private $imageTextColor;
	private $imageTextPosition;
	
	public function __construct($agendaObj, $itemData = null) {
		parent::__construct($agendaObj, $itemData);
	}
	
	protected function createEmpty() {
		parent::createEmpty();
		$this->imageFilename = "";
		$this->imageText = "";
		$this->imageTextFontFace = new JsonFontFace($this->agendaObj);
	}
	
	protected function applyJsonDecodedData($itemData) {
		parent::applyJsonDecodedData($itemData);
		$this->imageFilename = $itemData['imageFilename'];
		$this->imageText = $itemData['imageText'];
		$this->imageTextPosition = $itemData['imageTextPosition'];
		$this->imageTextFontFace = $itemData['imageTextFontFace'];
		$this->imageTextColor = $itemData['imageTextColor'];
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
		$itemData['imageTextPosition'] =
			$this->imageTextPosition->jsonSerialize();
		$itemData['imageTextFontFace'] = 
			$this->imageTextFontFace->jsonSerialize();
		$itemData['imageTextColor'] = $this->imageTextColor;
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
	
	public function getImageTextFontFace() {
		return $this->imageTextFontFace;
	}

 	public function setImageTextFontFace($imageTextFontFace) {
 		$this->imageTextFontFace = $imageTextFontFace;
 		$this->agendaObj->saveData();
	}
	
	public function getImageTextColor() {
		return $this->imageTextColor;
	}
	
	public function setImageTextColor($color) {
		$this->imageTextColor = $color;
		$this->agendaObj->saveData();
	}
	
	public function getImageTextPosition() {
		return $this->imageTextPosition;
	}
	
	public function setImageTextPosition($position) {
		$this->imageTextPosition = $position;
		$this->agendaObj->saveData();
	}
}
