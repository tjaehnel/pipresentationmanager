<?php
require_once dirname(__FILE__).'/../model/Agenda.class.php';
require_once dirname(__FILE__).'/../model/AgendaItem.class.php';

abstract class JsonAgendaItem implements AgendaItem //, JsonSerializable
{
	private $title;
	private $id;
	protected $agendaObj;

	public function __construct($agendaObj, $itemData = null) {
		$this->agendaObj = $agendaObj;
		if($itemData == null) {
			$this->createEmpty();
		} else {
			$this->applyJsonDecodedData($itemData);
		}
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setTitle($title) {
		$this->title = $title;
		$this->agendaObj->saveData();
	}

	protected function createEmpty() {
		$this->id = uniqid();
		$this->title = "";
	}
	
	protected function applyJsonDecodedData($itemData) {
		$this->id = $itemData['id'];
		$this->title = $itemData['title'];
	}
	
	/**
	 * @see JsonSerializable::jsonSerialize()
	 * Since the JsonSerializable interface is not available in
	 * PHP < 5.4 this class does not 'implement' it but only provides
	 * the method of this interface
	 */
	public function jsonSerialize() {
		$itemData = array();
		$itemData['id'] = $this->id;
		$itemData['title'] = $this->title;
		return $itemData;
	}
}
