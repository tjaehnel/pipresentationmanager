<?php
require_once dirname(__FILE__).'/AgendaItem.class.php';

interface AgendaMovie extends AgendaItem {
	public function getMovieFilename();
	public function setMovieFilename($movieFilename);
}