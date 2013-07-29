<?php
require_once dirname(__FILE__).'/../model/Agenda.class.php';

class JsonAgenda implements Agenda //, JsonSerializable
{
	private $jsonFilename;
	private $jsonDataLoaded = FALSE;
	
	private $id;
	private $title;
	/**
	 * @var Array associative title => AgendaItem object
	 */
	private $items = array();
	
	public function __construct($jsonFilename) {
		$this->jsonFilename = $jsonFilename;
	}
	public function getId() {
		$this->loadData();
		return $this->id;
	}
	public function getTitle() {
		$this->loadData();
		return $this->title;
	}
	public function setTitle($title) {
		$this->loadData();
		$this->title = $title;
		$this->saveData();
	}
	public function getItems() {
		$this->loadData();
		$itemArray = array();
		foreach ($this->items as $id => $crntItem) {
			$itemArray[$id] = $crntItem;
		}
		return $itemArray;
	}
	public function getItemById($id) {
		$this->loadData();
		if(!array_key_exists($id, $this->items))
		{
			throw new ModelException("Unknown Agenda Item: ".$title);
		}
		return $this->items[$id];
	}
	
	public function deleteItemById($id) {
		$this->loadData();
		if($this->hasItemWithId($id))
		{
			unset($this->items[$id]);
		}
		$this->saveData();
	}
	
	public function moveItemToPosition($itemId, $pos) {
		$this->loadData();
		if(!$this->hasItemWithId($itemId)) {
			throw new ModelException("Unknown Item with ID: ".$itemId);
		}
		$itemToMove = $this->getItemById($itemId);
		$this->deleteItemById($itemId);
		$this->insertItemAtPosition($itemToMove, $pos);
		$this->saveData();
	}
	
	protected function insertItemAtPosition($itemObj, $pos) {
		$i = 0;
		$newItems = array();
		foreach ($this->items as $crntId => $crntItem) {
			if($i == $pos) {
				$newItems[$itemObj->getId()] = $itemObj;
				$i++;
			}
			$newItems[$crntId] = $crntItem;
			$i++;
		}
		if($i <= $pos) { // if $pos points behind the last one
			$newItems[$itemObj->getId()] = $itemObj;
		}
		$this->items = $newItems;
		$this->saveData();
	}
	
	public function hasItemWithId($id) {
		$this->loadData();
		return array_key_exists($id, $this->items);
	}
	
	public function addNewSlide() {
		$newSlide = new JsonAgendaPicture($this);
		$this->items[$newSlide->getId()] = $newSlide;
		$this->saveData();
		return $newSlide;
	}
	
	public function addNewVideo() {
		$newVideo = new JsonAgendaMovie($this);
		$this->items[$newVideo->getId()] = $newVideo;
		$this->saveData();
		return $newVideo;
	}
	
	
	protected function loadData() {
		if(!$this->jsonDataLoaded)
		{
			$itemData = $this->loadJsonDecodedData();
			$this->applyJsonDecodedData($itemData);
			$this->jsonDataLoaded = true;
		}
	}
	
	protected function loadJsonDecodedData() {
		$jsonData = file_get_contents($this->jsonFilename);
		if($jsonData === false)
		{
			throw new ModelException("Unable to open show at: ".$this->jsonFilename);
		}
			
		return json_decode($jsonData, true);
	}
	
	protected function applyJsonDecodedData($showData) {
		$this->id = $showData['id'];
		$this->title = $showData['title'];
		$itemArray = $showData['items'];
		$this->items = array();
		foreach ($itemArray as $crntItem) {
			// TODO: There might be a more generic way to instantiate the classes
			$itemObj = null;
			switch ($crntItem['class'])
			{
				case 'JsonAgendaPicture':
					$itemObj = new JsonAgendaPicture($this, $crntItem);
					break;
				case 'JsonAgendaMovie':
					$itemObj = new JsonAgendaMovie($this, $crntItem);
					break;
				default:
					throw new ModelException("Unknown item class: " . $crntItem['class']);
			}
			$this->items[$itemObj->getId()] = $itemObj;
		}
	}
	
	public function saveData() {
		$jsonData = '';
		if(version_compare(PHP_VERSION, '5.4.0') >= 0) {
			$jsonData = json_encode($this->jsonSerialize(), JSON_PRETTY_PRINT);
		} else {
			$jsonData = json_encode($this->jsonSerialize());
		}
		if($jsonData === FALSE) {
			throw new ModelException("Unable to save show");
		}
		$ret = file_put_contents($this->jsonFilename, $jsonData);
		if($ret === FALSE) {
			throw new ModelException("Unable to write to file " . $this->jsonFilename);
		}
	}
	
	/**
	 * @see JsonSerializable::jsonSerialize()
	 * Since the JsonSerializable interface is not available in
	 * PHP < 5.4 this class does not 'implement' it but only provides
	 * the method of this interface
	 */
	public function jsonSerialize() {
		$showData = array();
		$showData['id'] = $this->id;
		$showData['title'] = $this->title;
		$showData['items'] = array();
		foreach ($this->items as $crntItem) {
			$itemData = $crntItem->jsonSerialize();
			$itemData['class'] = get_class($crntItem); 
			$showData['items'][] = $itemData;
		}
		return $showData;
	}
}