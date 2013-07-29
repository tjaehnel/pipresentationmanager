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
<script type="text/javascript" src="<?=BASEURL?>js/jsonRPC2php.client.js"></script>
<script type="text/javascript" src="js.php"></script>
</head>
<body>

<div id="pagecontent">
	<div id="header">
		<h1>Raspberry Pi Presentation Manager</h1>
	</div>
	<div id="agenda">
		<select name="agendaselect" id="agendaselect">
		</select>
		<div id="agendaitemscontainer">
			<ul id="agendaitems"></ul>
			<div id="showeditbuttons">
				<button id="addslidebtn">Add slide</button>
				<button id="addvideobtn">Add video</button><br/>
				<button id="saveshowbtn">Save show</button>
				<button id="publishshowbtn">Publish show</button>
			</div>
		</div>
	</div>
	<div id="itemsettings">
	</div>
</div>
<?php foreach ($viewRegistration as $crntView) {
	echo $crntView->getHTML();
}?>
<div id="sidebarslidetemplate" class="sidebartemplate">
	<img src="<?=BASEURL?>img/delete.png" class="sidebardelete">
	<img src="" class="sidebarimage">
	<span class="sidebartitle"></span>
</div>
<div id="sidebarvideotemplate" class="sidebartemplate">
	<img src="<?=BASEURL?>img/delete.png" class="sidebardelete">
	<img src="" class="sidebarimage">
	<span class="sidebartitle"></span>
</div>
<div id="confirmitemdeletedialog" title="Delete Item?">
<p>Do you want to delete <emph class="itemtitle"></emph></p>
</div>
</body>
</html>
