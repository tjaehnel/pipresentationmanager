<?php
require_once dirname(__FILE__).'/../ViewRpc.class.php';

class ViewFilePickerRpc extends ViewRpc {
	protected $model;
	protected $directory;
	
	public function __construct($model, $directory) {
		$this->model = $model;
		$this->directory = $directory;
	}
	
}
