<?php
require_once dirname(__FILE__).'/../model/FontFace.class.php';

class JsonFontFace implements FontFace {
	
	private $family;
	private $size;
	private $weight;
	private $slant;
	private $underline;
	private $overstrike;
	
	public function __construct() {
		$this->createEmpty();
	}
	
	protected function createEmpty() {
		$this->family = "";
		$this->size = "";
		$this->weight = "";
		$this->slant = "";
		$this->underline = "";
		$this->overstrike = "";
	}
	
	public function getFamily() {
		return $this->family;
	}
	public function setFamily($family) {
		$this->family = $family;
	}
	public function getSize() {
		return $this->size;
	}
	public function setSize($size) {
		$this->size = $size;
	}
	public function getWeight() {
		return $this->weight;
	}
	public function setWeight($weight) {
		$this->weight = $weight;
	}
	public function getSlant() {
		return $this->slant;
	}
	public function setSlant($slant) {
		$this->slant = $slant;
	}
	public function isUnderline() {
		return $this->underline;
	}
	public function setUnderline($underline) {
		$this->underline = $underline;
	}
	public function isOverstrike() {
		return $this->overstrike;
	}
	public function setOverstrike($overstrike) {
		$this->overstrike = $overstrike;
	}
}