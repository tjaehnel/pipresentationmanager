<?php
class TestRpc {
	public function ping($msg) {
		return "pong: " . $msg;
	}
}