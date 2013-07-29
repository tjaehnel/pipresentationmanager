<?php
interface View {
	/**
	 * @return String the HTML pieces of the View 
	 */
	public function getHTML();
	/**
	 * @return String the CSS pieces of the View
	 */
	public function getCSS();
	/**
	 * @return String the JavaScript pieces of the View 
	 */
	public function getJavaScript();
	/**
	 * @return ViewRpc containing all the methods for the RPC interface
	 */
	public function getRpcClass();
}