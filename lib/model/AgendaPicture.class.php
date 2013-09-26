<?php
require_once dirname(__FILE__).'/AgendaItem.class.php';

interface AgendaPicture extends AgendaItem {
	public function getImageFilename();
	public function setImageFilename($imageFilename);
	public function getImageText();
	public function setImageText($imageText);
	public function getImageTextColor();
	public function setImageTextColor($color);
	/**
	 * @return FontFace instance
	 */
	public function getImageTextFontFace();
	/**
	 * @param fontFace FontFace instance
	 */
	public function setImageTextFontFace($fontFace);
}
