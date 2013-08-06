<?php
require_once dirname(__FILE__).'/../ViewRpc.class.php';

class ViewShowItemListRpc extends ViewRpc {
	
	public function getItemsForShow( $showId ) {
		$items = array();
		foreach ($this->model->getAgendaById($showId)->getItems()
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
}
