<?php
require_once dirname(__FILE__).'/ViewEditorRpc.class.php';
require_once dirname(__FILE__).'/../ViewException.class.php';
require_once dirname(__FILE__).'/../../imgproc/ImageCreator.class.php';


class ViewPictureEditorRpc extends ViewEditorRpc {
	public function getItemById($agendaId, $itemId)
	{
		$item = $this->model->getAgendaById($agendaId)->getItemById($itemId);
		
		if(!($item instanceof AgendaPicture))
		{
			throw new ViewException("Item '" . $itemTitle . "' is not a Slide");
		}
		
		$title = $item->getTitle();
		$imageFilename = $item->getImageFilename();
		$previewImage = $this->getPreviewImageByFilename($item->getImageFilename());
		$imageText = $item->getImageText();
		$imageTextConfigAvailable = $item->isImageTextConfigAvailable();
		
		$itemData = array (
				'id' => $itemId,
				'title' => $title,
				'imageFilename' => $imageFilename,
				'previewImage' => $previewImage,
				'imageText' => $imageText,
				'imageTextConfigAvailable' => $imageTextConfigAvailable
		);
		
		return $itemData;
	}
	
	public function getPreviewImageByFilename($filename)
	{
		$previewImage = 'img.php?filename='.$filename
			.'&purpose='.ImagePurpose::Preview;
		return $previewImage;
	}
	
	public function imageHasTextConfiguration($filename)
	{
		$imgCfg = ImageCreator::getInstance()->getImageConfiguration($filename);
		if($imgCfg) {
			return array('hasTextConfiguration' => true);
		} else {
			// workaround because it seems RPC methods must not return "false" 
			return array('hasTextConfiguration' => false);
		}
	}
	
	public function saveItem($agendaId, $itemData)
	{
		$itemId = $itemData['id'];
		$item = $this->model->getAgendaById($agendaId)->getItemById($itemId);
		if(!($item instanceof AgendaPicture))
		{
			throw new ViewException("Item '" . $itemTitle . "' is not a Slide");
		}
		
		$item->setImageFilename($itemData['imageFilename']);
		$item->setImageText($itemData['imageText']);
		
		parent::saveItem($agendaId, $itemData);
	}
}