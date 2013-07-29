<?php
require_once dirname(__FILE__).'/../model/PpmModelRoot.class.php';

class ViewRpc {
	protected $model;

	public function __construct(PpmModelRoot $model) {
		$this->model = $model;
	}
}
