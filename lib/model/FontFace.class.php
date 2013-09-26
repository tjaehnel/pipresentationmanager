<?php
interface FontFace {
	public function getFamily();
	public function setFamily($family);
	public function getSize();
	public function setSize($size);
	public function getWeight();
	public function setWeight($weight);
	public function getSlant();
	public function setSlant($slant);
	public function isUnderline();
	public function setUnderline($underline);
	public function isOverstrike();
	public function setOverstrike($overstrike);
}