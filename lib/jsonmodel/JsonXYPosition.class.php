<?php
require_once dirname(__FILE__).'/../model/XYPosition.class.php';

class JsonXYPosition extends XYPosition {
	private $agendaObj;
	
	private $family;
	private $x;
	private $y;
	
	public function __construct($agendaObj, $itemData = null) {
		$this->agendaObj = $agendaObj;
		if($itemData == null) {
			$this->createEmpty();
		} else {
			$this->applyJsonDecodedData($itemData);
		}
	}
	
	protected function createEmpty() {
		$this->x = 0;
		$this->y = 0;
	}
	
	protected function applyJsonDecodedData($itemData) {
		$this->x = $itemData['x'];
		$this->y = $itemData['y'];
	}
	
	/**
	 * @see JsonSerializable::jsonSerialize()
	 * Since the JsonSerializable interface is not available in
	 * PHP < 5.4 this class does not 'implement' it but only provides
	 * the method of this interface
	 */
	public function jsonSerialize() {
		$itemData['x'] = $this->x;
		$itemData['y'] = $this->y;
		return $itemData;
	}
	
	public function getX() {
		return $this->x;
	}
	public function setX($x) {
		$this->x = $x;
		$this->agendaObj->saveData();
	}
	public function getY() {
		return $this->y;
	}
	public function setY($y) {
		$this->y = $y;
		$this->agendaObj->saveData();
	}
}