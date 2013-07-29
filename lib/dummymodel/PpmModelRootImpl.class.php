<?php
require_once dirname(__FILE__).'/../model/PpmModelRoot.class.php';
require_once dirname(__FILE__).'/AgendaImpl.class.php';
require_once dirname(__FILE__).'/AgendaPictureImpl.class.php';
require_once dirname(__FILE__).'/AgendaMovieImpl.class.php';
require_once dirname(__FILE__).'/../model/ModelException.class.php';

/**
 * This is a model for testing, which fills itself with
 * dummy data on construction.
 */
class PpmModelRootImpl implements PpmModelRoot {
	
	/**
	 * @var Array associative title => Agenda object
	 */
	private $agendas = array();
	
	public function __construct() {
		$agendaname = "agenda1";
		$agenda = new AgendaImpl("agenda1");
		$agenda->addItem(new AgendaPictureImpl("A simple item", "IMG_001.jpg"));
		$agenda->addItem(new AgendaMovieImpl("Another item"));
		$this->agendas[$agendaname] = $agenda;
		
		$agendaname = "agenda3";
		$agenda = new AgendaImpl("agenda3");
		$agenda->addItem(new AgendaPictureImpl("A simple item", "IMG_001.jpg"));
		$agenda->addItem(new AgendaPictureImpl("Something else", "IMG_003.jpg"));
		$agenda->addItem(new AgendaMovieImpl("Another item"));
		$this->agendas[$agendaname] = $agenda;
	}
	
	public function getAgendas() {
		$agendaArray = array();
		foreach ($this->agendas as $crntAgenda) {
			$agendaArray[] = $crntAgenda;
		}
		return $agendaArray;
	}
	
	public function getAgendaByTitle($title) {
		if(!array_key_exists($title, $this->agendas)) {
			throw new ModelException("Unknown Agenda: ".$title);
		}
		return $this->agendas[$title];
	}
} 