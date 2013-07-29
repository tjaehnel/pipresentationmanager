<?php
require_once dirname(__FILE__).'/ImgProcException.class.php';

class UnknownPurposeException extends ImgProcException {
	public function __construct($message, $code=null, $previous=null) {
		parent::__construct($message, $code, $previous);
	}
}