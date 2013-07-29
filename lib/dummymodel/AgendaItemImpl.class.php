<?php
require_once dirname(__FILE__).'/../model/AgendaItem.class.php';

abstract class AgendaItemImpl implements AgendaItem {
	private $title;

	
	public function __construct($title, $imageFilename) {
		$this->title = $title;
		$this->imageFilename = $imageFilename;
	}
	
	public function getTitle() {
		return $this->title;
	}

}