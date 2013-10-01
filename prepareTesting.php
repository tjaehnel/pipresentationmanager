<?php
$command = $_GET['command'];
try {
switch ($command) {
	case "init":
		doInit();
		echo '<p id="success">Successfully initialized test</p>';
		break;
	case "cleanup":
		doCleanup();
		echo '<p id="success">Successfully cleaned up test</p>';
		break;
	default:
		throw new Exception("Invalid command");
}
} catch(Exception $e) {
	header($_SERVER['SERVER_PROTOCOL'].' Internal Server Error');
	header($e->getMessage());
	echo $e->getMessage();
	
}

function doInit() {
	if(file_exists('test'))
		doCleanup();
	if(file_exists('test'))
		throw new Exception("Test directory exists - clean up first");
	//exec("cp -r testenvironment test", $dummy, $res);
	$res = recurse_copy('testenvironment', 'test');
	if(!$res)
		throw new Exception("Unable to copy directory");
}

function doCleanup() {
	exec("rm -rf test", $dummy, $res);
}

function recurse_copy($src,$dst) {
	$dir = opendir($src);
	@mkdir($dst);
	while(false !== ( $file = readdir($dir)) ) {
		if (( $file != '.' ) && ( $file != '..' )) {
			if ( is_dir($src . '/' . $file) ) {
				if(!recurse_copy($src . '/' . $file,$dst . '/' . $file))
					return false;
			}
			else {
				if(!copy($src . '/' . $file,$dst . '/' . $file))
					return false;
			}
		}
	}
	closedir($dir);
	return true;
}