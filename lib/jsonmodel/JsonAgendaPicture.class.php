<?php
require_once dirname(__FILE__).'/JsonAgendaItem.class.php';
require_once dirname(__FILE__).'/JsonFontFace.class.php';
require_once dirname(__FILE__).'/JsonXYPosition.class.php';
require_once dirname(__FILE__).'/../model/AgendaPicture.class.php';
require_once dirname(__FILE__).'/../imgproc/ImageCreator.class.php';

class JsonAgendaPicture extends JsonAgendaItem implements AgendaPicture {
	private $imageFilename;
	private $imageText;
	private $imageTextFontFace;
	private $imageTextColor;
	private $imageTextPosition;
	private $imageTextConfigAvailable;
	
	private $textConfigLoaded;
	
	public function __construct($agendaObj, $itemData = null) {
		parent::__construct($agendaObj, $itemData);
		$this->imageTextFontFace = null;
		$this->imageTextColor = "";
		$this->imageTextPosition = null;
		$this->imageTextConfigAvailable = false;
		$this->textConfigLoaded = false;
	}
	
	protected function createEmpty() {
		parent::createEmpty();
		$this->imageFilename = "";
		$this->imageText = "";
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
	
	public function getImageTextFontFace() {
		$this->loadImgConfiguration();
		return $this->imageTextFontFace;
	}

 	public function setImageTextFontFace($imageTextFontFace) {
 		throw ModelException("Attribute 'Font Face' is read-only");
	}
	
	public function getImageTextColor() {
		$this->loadImgConfiguration();
		return $this->imageTextColor;
	}
	
	public function setImageTextColor($color) {
 		throw ModelException("Attribute 'Text Color' is read-only");
	}
	
	public function getImageTextPosition() {
		$this->loadImgConfiguration();
		return $this->imageTextPosition;
	}
	
	public function setImageTextPosition($position) {
 		throw ModelException("Attribute 'Text Position' is read-only");
	}
	
	public function isImageTextConfigAvailable() {
		$this->loadImgConfiguration();
		return $this->imageTextConfigAvailable;
	}
	
	protected function loadImgConfiguration() {
		if($this->textConfigLoaded) {
			return;
		}
		$this->textConfigLoaded = true;
		
		$imgConfig = ImageCreator::getInstance()
			->getImageConfiguration($this->getImageFilename());
		
		if($imgConfig == null) {
			return;
		}
		
		$textConfig = $imgConfig->text;
		if($textConfig) {
			$this->imageTextConfigAvailable = true;
			$this->imageTextColor = $textConfig->color;
			$this->imageTextFontFace = new JsonFontFace();
			$this->imageTextFontFace->setFamily($textConfig->font);
			$this->imageTextFontFace->setSize($textConfig->size);
			$this->imageTextFontFace->setWeight($textConfig->weight);
			$this->imageTextFontFace->setSlant($textConfig->slant);
			$this->imageTextFontFace->setUnderline($textConfig->underline);
			$this->imageTextFontFace->setOverstrike($textConfig->overstrike);
			$this->imageTextPosition = new JsonXYPosition();
			$this->imageTextPosition->setX($textConfig->posX);
			$this->imageTextPosition->setY($textConfig->posY);
		}
	}
}
