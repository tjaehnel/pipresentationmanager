<?php
//require_once dirname(__FILE__).'/lib/dummymodel/PpmModelRootImpl.class.php';
//require_once dirname(__FILE__).'/lib/jsonmodel/JsonModelRoot.class.php';
require_once dirname(__FILE__).'/lib/imgproc/ImagePurpose.class.php';
require_once dirname(__FILE__).'/lib/pipresentsexporter/PiPresentsExporter.class.php';

class PpmRpc {
	
	private $model;
	
	public function __construct($model) {
		$this->model = $model;
	}
	
	public function getAllAgendas() {
		$agendas = array();
		foreach ($this->model->getAgendas() as $crntAgenda) {
			$agendaArray = array();
			$agendaArray['id'] = $crntAgenda->getId();
			$agendaArray['title'] = $crntAgenda->getTitle();
			$agendas[] = $agendaArray;
		}
		
		// add a bad one, to tests error reporting
		$agendaArray = array();
		$agendaArray['id'] = '1234';
		$agendaArray['title'] = "Bad Agenda";
		$agendas[] = $agendaArray;
		
		return $agendas;
	}
	
	public function getItemsForAgenda( $agendaId ) {
		$items = array();
		foreach ($this->model->getAgendaById($agendaId)->getItems()
				as $crntItem) {
			$itemId = $crntItem->getId();
			$sidebarImage = "";
			$type = "";
			if($crntItem instanceof AgendaPicture)
			{
				$type = 'Picture';
				//$sidebarImage = 'img.php?filename='.$crntItem->getImageFilename()
				//			.'&purpose='.ImagePurpose::Sidebar;
				$sidebarImage = 'img.php?filename='.$crntItem->getImageFilename()
							.'&purpose='.ImagePurpose::Sidebar;
			}
			else if ($crntItem instanceof AgendaMovie) {
				$type = 'Movie';
				$sidebarImage = BASEURL.'img/Video_sidebar.png';
			}
			$items[] = array(
					'id' => $itemId,
					'type' => $type,
					'title' => $crntItem->getTitle(),
					'sidebarImage' => $sidebarImage
			);
		}
		return $items;
	}
	
	/**
	 * set a new show order 
	 * @param unknown $showId
	 * @param unknown $items Associative array of items containing at least 'id' and 'type'
	 */
	public function saveShow( $showId, $items )
	{
		$oldShow = $this->model->getAgendaById($showId);
		$this->removeDeletedItems($oldShow, $items);
		$this->addNewItems($oldShow, $items);
		$this->reorderItems($oldShow, $items);
	}
	
	protected function removeDeletedItems($oldShow, $newShowItems)
	{
		$oldShowItems = $oldShow->getItems();
		foreach ($oldShowItems as $oldShowItem) {
			$found = false;
			foreach ($newShowItems as $newShowItem) {
				if($oldShowItem->getId() == $newShowItem['id']) {
					$found = true;
				}
			}
			if(!$found) {
				$oldShow->deleteItemById($oldShowItem->getId());
			}
		}
	}
	
	protected function addNewItems($oldShow, $newShowItems)
	{
		foreach ($newShowItems as $crntItem) {
			if($crntItem['id'] == "") {
				if($crntItem['type'] == 'Picture') {
					$newSlide = $oldShow->addNewSlide();
					$newSlide->setTitle("New Slide");
				} else {
					$newSlide = $oldShow->addNewVideo();
					$newSlide->setTitle("New Video");
				}
			}
		}
	}
	
	protected function reorderItems($oldShow, $newShowItems)
	{
		for ($i = 0; $i < count($newShowItems); $i++) {
			$crntItemId = $newShowItems[$i]['id'];
			if($crntItemId == "") {
				continue;
			}
			$oldShow->moveItemToPosition($crntItemId, $i);
		}
	}
	
	public function publishShow( $showId )
	{
		$thisShow = $this->model->getAgendaById( $showId );
		$exporter = new PiPresentsExporter(
				$thisShow, PUBLISH_DIR . '/' . $showId, DATA_DIR);
		$exporter->performExport();
	}
	
	public function ping($msg) {
		return "pong: " . $msg;
	}
}