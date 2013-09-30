<?php
require_once dirname(__FILE__).'/../model/XYPosition.class.php';

class JsonXYPosition implements XYPosition {
	
	private $family;
	private $x;
	private $y;
	
	public function __construct() {
		$this->createEmpty();
	}
	
	protected function createEmpty() {
		$this->x = 0;
		$this->y = 0;
	}
	
	public function getX() {
		return $this->x;
	}
	public function setX($x) {
		$this->x = $x;
	}
	public function getY() {
		return $this->y;
	}
	public function setY($y) {
		$this->y = $y;
	}
}