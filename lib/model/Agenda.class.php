<?php
interface Agenda {
	/**
	 * @return Array of AgendaItem objects
	 */
	public function getItems();
	public function getTitle();
	public function setTitle($title);
	/**
	 * @param String $id
	 * @return AgendaItem
	 */
	public function getItemById($id);
	public function deleteItemById($id);
	public function hasItemWithId($id);
	
	/**
	 * Insert the item with the given ID at the given position in the
	 * list, moving other items accordingly.
	 * moveItemToPosition($itemId, $pos) results in
	 * getItems()[$pos]->getId() == $itemId;
	 * @param unknown $itemId
	 * @param unknown $pos 0-based position in the item list
	 */
	public function moveItemToPosition($itemId, $pos);
	
	public function addNewSlide();
	public function addNewVideo();
	

}