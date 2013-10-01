<?php
$command = $_GET['command'];
try {
switch ($command) {
	case "init":
		if(file_exists('test'))
			throw new Exception("Test directory exists - clean up first");
		//exec("cp -r testenvironment test", $dummy, $res);
		$res = recurse_copy('testenvironment', 'test');
		if(!$res)
			throw new Exception("Unable to copy directory");
		echo "Successfully initialized test";
		break;
	case "cleanup":
		exec("rm -rf test", $dummy, $res);
		if($res != 0)
			throw new Exception("Unable to remove directory");
		echo "Successfully cleaned up test";
		break;
	default:
		throw new Exception("Invalid command");
}
} catch(Exception $e) {
	header($_SERVER['SERVER_PROTOCOL'].' Internal Server Error');
	header($e->getMessage());
	echo $e->getMessage();
	
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