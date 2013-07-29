<?php
require_once dirname(__FILE__).'/AgendaItem.class.php';

interface AgendaPicture extends AgendaItem {
	public function getImageFilename();
	public function setImageFilename($imageFilename);
	public function getImageText();
	public function setImageText($imageText);
}