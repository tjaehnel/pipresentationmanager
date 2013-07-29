<?php
/**
 * @author Tobias Jaehnel
 * Root of the model representing the state of
 * the system 
 * 
 */
interface PpmModelRoot {
	/**
	 * @return Array of Agendas (id => object)
	 */
	public function getAgendas();
	/**
	 * @param String $id
	 * @return Agenda
	 */
	public function getAgendaById($id);
}