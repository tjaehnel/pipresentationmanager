<?php
$command = $_GET['command'];
try {
switch ($command) {
	case "init":
		if(file_exists('test'))
			throw new Exception("Test directory exists - clean up first");
		system("cp -r testenvironment test", $res);
		if($res != 0)
			throw new Exception("Unable to copy directory");
		echo "Successfully initialized test";
		break;
	case "cleanup":
		system("rm -rf test", $res);
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