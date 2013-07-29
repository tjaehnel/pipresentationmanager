<?php
require_once dirname(__FILE__).'/../model/Agenda.class.php';

class AgendaImpl implements Agenda {
	private $title;
	/**
	 * @var Array associative title => AgendaItem object
	 */
	private $items = array();
	
	public function __construct($title) {
		$this->title = $title;
	}
	public function getTitle() {
		return $this->title;
	}
	public function getItems() {
		$itemArray = array();
		foreach ($this->items as $crntItem) {
			$itemArray[] = $crntItem;
		}
		return $itemArray;
	}
	public function getItemByTitle($title) {
		if(!array_key_exists($title, $this->items)) {
			throw new ModelException("Unknown Agenda Item: " + $title);
		}
		return $this->items[$title];
	}
	
	public function addItem(AgendaItem $item) {
		$this->items[$item->getTitle()] = $item;
	}
	
}