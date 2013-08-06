<?php
require_once dirname(__FILE__).'/../ViewRpc.class.php';

class ViewShowListRpc extends ViewRpc {
	
	public function getAllShows() {
		$shows = array();
		foreach ($this->model->getAgendas() as $crntAgenda) {
			$agendaArray = array();
			$agendaArray['id'] = $crntAgenda->getId();
			$agendaArray['title'] = $crntAgenda->getTitle();
			$shows[] = $agendaArray;
		}
		
/*		// add a bad one, to tests error reporting
		$agendaArray = array();
		$agendaArray['id'] = '1234';
		$agendaArray['title'] = "Bad Agenda";
		$shows[] = $agendaArray; */
		
		return $shows;
	}
}
