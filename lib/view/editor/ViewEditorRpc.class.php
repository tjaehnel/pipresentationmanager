<?php
require_once dirname(__FILE__).'/../ViewRpc.class.php';

abstract class ViewEditorRpc extends ViewRpc {
	public function saveItem($agendaId, $itemData)
	{
		$itemId = $itemData['id'];
		$item = $this->getShowItem($agendaId, $itemId);
		$item->setTitle($itemData['title']);
	}
	
	protected function getShowItem($agendaId, $itemId)
	{
		return $this->model->getAgendaById($agendaId)->getItemById($itemId);
	}
	
}
