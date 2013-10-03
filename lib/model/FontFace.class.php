<?php
interface FontFace {
	public function getFamily();
	public function setFamily($family);
	public function getSize();
	public function setSize($size);
	public function getBold();
	public function isBold($bold);
	public function getItalic();
	public function isItalic($italic);
	public function isUnderline();
	public function setUnderline($underline);
	public function isOverstrike();
	public function setOverstrike($overstrike);
}