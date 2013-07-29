<?php
require_once dirname(__FILE__).'/ViewEditorRpc.class.php';

class ViewMovieEditorRpc extends ViewEditorRpc {
	public function getItemById($agendaId, $itemId)
	{
		$item = $this->model->getAgendaById($agendaId)->getItemById($itemId);

		if(!($item instanceof AgendaMovie))
		{
			throw new ViewException("Item '" . $itemTitle . "' is not a Movie");
		}
		
		$title = $item->getTitle();
		$movieFilename = $item->getMovieFilename();

		$itemData = array (
				'id' => $itemId,
				'title' => $title,
				'movieFilename' => $movieFilename
		);
		
		return $itemData;
	}
	
	public function saveItem($agendaId, $itemData)
	{
		$itemId = $itemData['id'];
		$item = $this->model->getAgendaById($agendaId)->getItemById($itemId);
		if(!($item instanceof AgendaMovie))
		{
			throw new ViewException("Item '" . $itemTitle . "' is not a Movie");
		}
	
		$item->setMovieFilename($itemData['movieFilename']);
	
		parent::saveItem($agendaId, $itemData);
	}
}
