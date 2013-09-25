<?php 
require_once PPMDIR.'/viewRegistration.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>PiPresents Manager</title>
<link type="text/css" href="css.php" rel="Stylesheet" />
<link type="text/css" href="<?=BASEURL?>css/ui-ppm/jquery-ui-1.10.3.custom.css" rel="Stylesheet" />
<link type="text/css" href="<?=BASEURL?>css/jquery.multiselect.css" rel="Stylesheet" />
<script type="text/javascript" src="<?=BASEURL?>js/Math.uuid.js"></script>
<script type="text/javascript" src="<?=BASEURL?>js/jquery.js"></script>
<script type="text/javascript" src="<?=BASEURL?>js/jquery-ui.custom.min.js"></script>
<script type="text/javascript" src="<?=BASEURL?>js/jquery.multiselect.min.js"></script>
<script type="text/javascript" src="<?=BASEURL?>js/jsonRPC2php-stm.client.js"></script>
<script type="text/javascript" src="<?=BASEURL?>js/simpleTaskManager.js"></script>
<script type="text/javascript" src="js.php"></script>
</head>
<body>

<?php foreach ($viewRegistration as $crntView) {
	echo $crntView->getHTML();
}?>

</body>
</html>
