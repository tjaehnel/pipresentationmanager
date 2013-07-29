<?php
// local directory where all backgrounds and movies are stored
define('DATA_DIR', dirname(__FILE__).'/data');
// local directory where resized images are cached
define('CACHE_DIR', dirname(__FILE__).'/cache');
// local directory for the storage of the shows
// (before publishing - not the PiPresents one)
define('JSON_DIR', dirname(__FILE__).'/json');
// local directory the PiPresents content
// gets published to
define('PUBLISH_DIR', dirname(__FILE__).'/publish');
// local directory containing the PPM libs
define('PPMDIR', dirname(__FILE__).'/lib');

// URL containing the root of the web gui
define('BASEURL', '');

// create global model instance
require_once PPMDIR.'/jsonmodel/JsonModelRoot.class.php';
$model = new JsonModelRoot(JSON_DIR);