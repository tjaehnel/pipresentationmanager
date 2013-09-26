<?php
require_once dirname(__FILE__).'/../model/FontFace.class.php';

class JsonFontFace implements FontFace {
	private $agendaObj;
	
	private $family;
	private $size;
	private $weight;
	private $slant;
	private $underline;
	private $overstrike;
	
	public function __construct($agendaObj, $itemData = null) {
		$this->agendaObj = $agendaObj;
		if($itemData == null) {
			$this->createEmpty();
		} else {
			$this->applyJsonDecodedData($itemData);
		}
	}
	
	protected function createEmpty() {
		$this->family = "";
		$this->size = "";
		$this->weight = "";
		$this->slant = "";
		$this->underline = "";
		$this->overstrike = "";
	}
	
	protected function applyJsonDecodedData($itemData) {
		$this->family = $itemData['family'];
		$this->size = $itemData['size'];
		$this->weight = $itemData['weight'];
		$this->slant = $itemData['slant'];
		$this->underline = $itemData['underline'];
		$this->overstrike = $itemData['overstrike'];
	}
	
	/**
	 * @see JsonSerializable::jsonSerialize()
	 * Since the JsonSerializable interface is not available in
	 * PHP < 5.4 this class does not 'implement' it but only provides
	 * the method of this interface
	 */
	public function jsonSerialize() {
		$itemData['family'] = $this->family;
		$itemData['size'] = $this->size;
		$itemData['weight'] = $this->weight;
		$itemData['slant'] = $this->slant;
		$itemData['underline'] = $this->underline;
		$itemData['overstrike'] = $this->overstrike;
		return $itemData;
	}
	
	public function getFamily() {
		return $this->family;
	}
	public function setFamily($family) {
		$this->family = $family;
		$this->agendaObj->saveData();
	}
	public function getSize() {
		return $this->size;
	}
	public function setSize($size) {
		$this->size = $size;
		$this->agendaObj->saveData();
	}
	public function getWeight() {
		return $this->weight;
	}
	public function setWeight($weight) {
		$this->weight = $weight;
		$this->agendaObj->saveData();
	}
	public function getSlant() {
		return $this->slant;
	}
	public function setSlant($slant) {
		$this->slant = $slant;
		$this->agendaObj->saveData();
	}
	public function isUnderline() {
		return $this->underline;
	}
	public function setUnderline($underline) {
		$this->underline = $underline;
		$this->agendaObj->saveData();
	}
	public function isOverstrike() {
		return $this->overstrike;
	}
	public function setOverstrike($overstrike) {
		$this->overstrike = $overstrike;
		$this->agendaObj->saveData();
	}
}