<?php
interface AgendaItem {
	public function getId();
	public function getTitle();
	public function setTitle($title);
}