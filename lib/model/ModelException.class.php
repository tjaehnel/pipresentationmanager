<?php
class ModelException extends Exception {
	public function __construct($message, $code=null, $previous=null) {
		parent::__construct($message, $code, $previous);
	}
}