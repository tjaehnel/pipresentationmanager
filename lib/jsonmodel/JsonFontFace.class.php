<?php
require_once dirname(__FILE__).'/../model/FontFace.class.php';

class JsonFontFace implements FontFace {
	
	private $family;
	private $size;
	private $bold;
	private $italic;
	private $underline;
	private $overstrike;
	
	public function __construct() {
		$this->createEmpty();
	}
	
	protected function createEmpty() {
		$this->family = "";
		$this->size = "";
		$this->bold = "";
		$this->italic = "";
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
	public function isBold() {
		return $this->bold;
	}
	public function setBold($bold) {
		$this->bold = $bold;
	}
	public function isItalic() {
		return $this->italic;
	}
	public function setItalic($italic) {
		$this->italic = $italic;
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