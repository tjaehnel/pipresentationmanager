<?php
/**
 * Emulated enum representing the different kinds of
 * generated images. 
 * @author tobias
 *
 */
final class ImagePurpose {
	private function __construct() {}
	const HD = 1;
	const Sidebar = 2;
	const Preview = 3;
}