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
	
	public function ping($msg) {
		return "pong: " . $msg;
	}
	
}