<?php
require_once dirname(__FILE__).'/../model/PpmModelRoot.class.php';
require_once dirname(__FILE__).'/JsonAgenda.class.php';
require_once dirname(__FILE__).'/JsonAgendaPicture.class.php';
require_once dirname(__FILE__).'/JsonAgendaMovie.class.php';
require_once dirname(__FILE__).'/../model/ModelException.class.php';

/**
 * This is a model for testing, which fills itself with
 * dummy data on construction.
 */
class JsonModelRoot implements PpmModelRoot {
	
	private $agendaDirectory;
	const SHOW_FILE_FILTER = '/\.show\.json/';
	
	private $jsonDataLoaded = FALSE;
	
	/**
	 * @var Array associative title => Agenda object
	 */
	private $agendas = array();
	
	
	public function __construct($agendaDirectory) {
		$this->agendaDirectory = $agendaDirectory;
	}
	
	public function getAgendas() {
		$this->loadData();
		$agendaArray = array();
		
		foreach ($this->agendas as $id => $crntAgenda) {
			$agendaArray[$id] = $crntAgenda;
		}
		
		return $agendaArray;
	}
	
	public function getAgendaById($id) {
		$this->loadData();
		if(!array_key_exists($id, $this->agendas)) {
			throw new ModelException("Unknown Agenda: ".$id);
		}
		return $this->agendas[$id];
	}
	
	protected function loadData() {
		if(!$this->jsonDataLoaded)
		{
			$fileList = array();
			$handler = opendir($this->agendaDirectory);
			while ($file = readdir($handler)) {
				if (preg_match(self::SHOW_FILE_FILTER, $file)) {
					$fileList[] = $file;
				}
			}
			closedir($handler);
			
			sort($fileList, SORT_LOCALE_STRING);
			foreach ($fileList as $file) {
				$filePath = $this->agendaDirectory . '/' . $file;
				$agendaObj = new JsonAgenda($filePath);
				$this->agendas[$agendaObj->getId()] = $agendaObj;
			}
			
			$this->jsonDataLoaded = true;
		}
	}
} 