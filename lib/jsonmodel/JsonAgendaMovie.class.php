<?php
require_once dirname(__FILE__).'/JsonAgendaItem.class.php';
require_once dirname(__FILE__).'/../model/AgendaMovie.class.php';

class JsonAgendaMovie extends JsonAgendaItem implements AgendaMovie {

	private $movieFilename;
	
	public function __construct($agendaObj, $itemData = null)
	{
		parent::__construct($agendaObj, $itemData);
	}
	
	public function getMovieFilename() {
		return $this->movieFilename;
	}
	
	public function setMovieFilename($movieFilename) {
		$this->movieFilename = $movieFilename;
	}
	
	protected function applyJsonDecodedData($itemData) {
		parent::applyJsonDecodedData($itemData);
		$this->movieFilename = $itemData['movieFilename'];
	}
	
	/**
	 * @see JsonSerializable::jsonSerialize()
	 * Since the JsonSerializable interface is not available in
	 * PHP < 5.4 this class does not 'implement' it but only provides
	 * the method of this interface
	 */
	public function jsonSerialize() {
		$itemData = parent::jsonSerialize();
		$itemData['movieFilename'] = $this->movieFilename;
		return $itemData;
	}
}