<?php
interface FontFace {
	public function getFamily();
	public function setFamily($family);
	public function getSize();
	public function setSize($size);
	public function isBold();
	public function setBold($bold);
	public function isItalic();
	public function setItalic($italic);
	public function isUnderline();
	public function setUnderline($underline);
	public function isOverstrike();
	public function setOverstrike($overstrike);
}