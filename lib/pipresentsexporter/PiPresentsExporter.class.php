<?php
require_once(dirname(__FILE__).'/../model/Agenda.class.php');
require_once(dirname(__FILE__).'/../model/AgendaItem.class.php');
require_once(dirname(__FILE__).'/../model/AgendaPicture.class.php');
require_once(dirname(__FILE__).'/../model/AgendaMovie.class.php');
require_once(dirname(__FILE__).'/../imgproc/ImageCreator.class.php');

require_once(dirname(__FILE__).'/ExportException.class.php');

class PiPresentsExporter {
	protected $show;
	protected $outputDirectory;
	protected $mediaDirectory;
	
	const MEDIALIST_FILENAME = 'media.json';
	const SHOWLIST_FILENAME = 'pp_showlist.json';
	
	public function __construct(Agenda $show, $outputDirectory, $mediaDirectory) {
		$this->show = $show;
		$this->outputDirectory = $outputDirectory;
		$this->mediaDirectory = $mediaDirectory;
	}

	public function performExport() {
		mkdir($this->outputDirectory, 0777, true);
		$this->exportShowList();
		$this->exportMediaList();
		$this->exportMediaFiles();
	}
	
	protected function exportShowList() {
		$showlist = array();
		$showlist["issue"] = "1.1";

		$show = array();
		$show["show-ref"] = "start";
		$show["start-show"] = "pimediashow";
		$show["title"] = "Mediashow";
		$show["type"] = "start";
		$showlist["shows"][] = $show;

		$show = array();
		$show["type"] = "mediashow";
		$show["trigger"] = "start";
		$show["transition"] = "cut";
		$show["omx-audio"] = "hdmi";
		$show["omx-other-options"] = "-t 1";
		$show["repeat"] = "interval";
		$show["repeat-interval"] = "0";
		$show["has-child"] = "no";
		$show["sequence"] = "ordered";
		$show["progress"] = "auto";
		$show["show-ref"] = "pimediashow";
		$show["show-text"] = "";
		$show["title"] = $this->show->getTitle();
		$show["medialist"] = self::MEDIALIST_FILENAME;
		$showlist["shows"][] = $show;
		
		$showlistfilename = $this->outputDirectory
							. '/' . self::SHOWLIST_FILENAME;
		$jsonData = self::generateJsonData($showlist);
		self::saveToFile($showlistfilename, $jsonData);
	}
	
	protected function exportMediaList() {
		$medialist = array();
		$medialist["issue"] = "1.1";
		$medialist["tracks"] = $this->generateTracks();
		
		$medialistfile = $this->outputDirectory
						. '/' . self::MEDIALIST_FILENAME;
		$jsonData = self::generateJsonData($medialist);		
		self::saveToFile($medialistfile, $jsonData);
	}
	
	protected function generateTracks() {
		$tracks = array();
		foreach ($this->show->getItems() as $crntItem) {
			$tracks[] = $this->generateTrack($crntItem);
		}
		return $tracks;
	}
	
	protected function generateTrack(AgendaItem $item) {
		if ($item instanceof AgendaPicture) {
			return $this->generateImageTrack($item);
		} else if ($item instanceof AgendaMovie) {
			return $this->generateVideoTrack($item);
		}
		return null;
	}
	
	protected function generateImageTrack(AgendaPicture $item) {
		$track = array();
		$track["type"] = "image";
		$track["duration"] = "4";
		$track["track-ref"] = "";
		$track["track-text"] = $item->getImageText();
		$track["track-text-x"] = "50";
		$track["track-text-y"] = "50";
		$track["track-text-colour"] = "white";
		$track["track-text-font"] = "helvetica 30 bold";
		$track["title"] = $item->getTitle();
		$track["transition"] = "cut";
		$track["location"] = $item->getImageFilename();
		return $track;
	}
	
	protected function generateVideoTrack(AgendaMovie $item) {
		$track = array();
		$track["type"] = "video";
		$track["title"] = $item->getTitle();
		$track["track-ref"] = "";
		$track["location"] = $item->getMovieFilename();
		return $track;
	}
	
	protected function exportMediaFiles() {
		$imageFileList = array();
		$videoFileList = array();
		foreach ($this->show->getItems() as $crntItem) {
			if ($crntItem instanceof AgendaPicture) {
				$this->exportImageFile($crntItem->getImageFilename());
				$imageFileList[] = $crntItem->getImageFilename();
			} else if ($crntItem instanceof AgendaMovie) {
				$this->exportVideoFile($crntItem->getMovieFilename());
				$videoFileList[] = $crntItem->getMovieFilename();
			}
		}

		$allNeededFiles = array_merge($imageFileList, $videoFileList,
				array(self::MEDIALIST_FILENAME, self::SHOWLIST_FILENAME));
		self::deleteFilesNotInList($this->outputDirectory, $allNeededFiles);
	}
	
	protected static function deleteFilesNotInList($directory, $fileList) {
		$handler = opendir($directory);
		while ($file = readdir($handler)) {
			if($file == "." || $file == "..") {
				continue;
			}
			if(!in_array($file, $fileList)) {
				unlink($directory . '/' . $file);
			}
		}
		closedir($handler);
	}
	
	protected function exportImageFile($filename) {
		$imgData = ImageCreator::getInstance()->getImageForPurpose(
			$filename, ImagePurpose::HD, $this->mediaDirectory);
		$outputFilename = $this->outputDirectory . '/' . $filename;
		self::saveToFile($outputFilename, $imgData);
	}
	
	protected function exportVideoFile($filename) {
		$inputFilename = $this->mediaDirectory . '/' . $filename;
		$outputFilename = $this->outputDirectory . '/' . $filename;
		
		$ret = copy($inputFilename, $outputFilename);
		if($ret === FALSE) {
			throw new ExportException("Unable to copy '.$filename.' to ".$outputFilename);
		}
	}
	
	protected static function generateJsonData($arrayData) {
		if(version_compare(PHP_VERSION, '5.4.0') >= 0) {
			$jsonData = json_encode($arrayData, JSON_PRETTY_PRINT);
		} else {
			$jsonData = json_encode($arrayData);
		}
		if($jsonData === FALSE) {
			throw new ExportException("Unable to generate JSON data");
		}
		return $jsonData;
	}
	
	protected static function saveToFile($filename, $data) {
		$ret = file_put_contents($filename, $data);
		if($ret === FALSE) {
			throw new ExportException("Unable to write to file ".$filename);
		}
	}
}
