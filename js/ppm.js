$( document ).ready(function() {
	rpc = new jsonrpcphp('rpc.php', function() {
		var agendaSidebar = new ViewAgendaSideBar(rpc);
		agendaSidebar.initView();
		agendaSidebar.reloadAgendaList();
	});
});

function ViewAgendaSideBar(rpc) {
	this.rpc = rpc;
	this.showItemList = new ViewShowItemList(rpc);
	
	this.pictureEditor = new ViewPictureEditor(this, rpc);
	this.movieEditor = new ViewMovieEditor(this, rpc);
	this.$agendaselect = $( "#agendaselect" );
	this.$agendaitems = $("#agendaitems");
	this.selectedAgenda = "";
	this.$addslidebtn = $("#addslidebtn").button();
	this.$addvideobtn = $("#addvideobtn").button();
	this.$saveshowbtn = $("#saveshowbtn").button();
	this.$publishshowbtn = $("#publishshowbtn").button();
	this.$deleteConfirmDialog = $("#confirmitemdeletedialog").dialog({
		resizable: false,
		height:140,
		modal: true,
		autoOpen: false
	});
}

ViewAgendaSideBar.prototype.initView = function() {
	var me = this;
	this.$agendaselect.multiselect({
		multiple: false,
		header: false,
		noneSelectedText: "Select Agenda",
		selectedList: 1
	});
	this.$agendaselect.bind("multiselectclick", function(event, ui){
		me.selectAgenda(ui.value);
	});
	this.$agendaitems.sortable();
	this.$agendaitems.disableSelection();
	
	this.$addslidebtn.click(function(event) {
		event.preventDefault();
		me.addSlide("newS" + Math.uuid(), "New Slide", "<?=BASEURL?>img/noimage.png");
	});
	this.$addvideobtn.click(function(event) {
		event.preventDefault();
		me.addVideo("newV" + Math.uuid(), "New Video");
	});
	this.$saveshowbtn.click(function(event) {
		event.preventDefault();
		me.saveShow();
	});
	this.$publishshowbtn.click(function(event) {
		event.preventDefault();
		me.publishShow();
	});
}

ViewAgendaSideBar.prototype.selectAgenda = function(id) {
	this.showItemList.displayShow(id);
}

ViewAgendaSideBar.prototype.markItemSelected = function($item) {
	$('#agendaitems li').removeClass('selected');
	$item.addClass('selected');
}

ViewAgendaSideBar.prototype.reloadAgendaList = function() {
	var me = this;
	this.rpc.PpmRpc.getAllAgendas('', function(jsonRpcObj) {
		console.log(jsonRpcObj);
		me.buildAgendaList(jsonRpcObj.result);
	});
}

ViewAgendaSideBar.prototype.buildAgendaList = function(agendas) {
	this.$agendaselect.empty();
	$itemOption = $('<option></option');
	$itemOption.html('- Select Show -');
	this.$agendaselect.append($itemOption);
	for (var i = 0; i < agendas.length; i++) {
		var crntAgenda = agendas[i];
		$itemOption = $('<option></option>');
		$itemOption.val(crntAgenda.id);
		$itemOption.html(crntAgenda.title);
		this.$agendaselect.append($itemOption);
	}
	// refresh
	this.$agendaselect.multiselect({
		multiple: false
	});
}

ViewAgendaSideBar.prototype.addSlide = function(id, title, imgFilename) {
	var me = this;
	$newItem = $('#sidebarslidetemplate').clone();
	$newItem.show();
	$newItem.hover(
			function() { $(this).find('.sidebardelete').show() },
			function() { $(this).find('.sidebardelete').hide() }
	);
	
	$itemImage = $newItem.find('.sidebarimage');
	$itemImage.attr('src', imgFilename);
	$itemTitle = $newItem.find('.sidebartitle');
	$itemTitle.html(title);
	$itemDelete = $newItem.find('.sidebardelete');
	
	$itemlink = $("<li></li>");
	$itemlink.attr("value", id);
	
	bindfct = function() { // hack to preserve the correct itemdata
		var itemlink = $itemlink;
		var itemDelete = $itemDelete;
		var itemTitle = title;
		var itemId = id;
		itemlink.bind("click", function(event) {
			me.pictureEditor.editItem(me.selectedAgenda, itemId);
			me.markItemSelected(itemlink);
		});
		itemDelete.bind("click", function(event) {
			me.$deleteConfirmDialog.find(".itemtitle").html(itemTitle);
			me.$deleteConfirmDialog.dialog({
				buttons: {
					"Yes": function() {
						me.deleteItem(id);
						$( this ).dialog( "close" );
					},
					"No": function() {
						$( this ).dialog( "close" );						
					}
				}
			});
			me.$deleteConfirmDialog.dialog("open");
		});
	}
	bindfct();
	
	$itemlink.append($newItem);
	this.$agendaitems.append($itemlink);
}

ViewAgendaSideBar.prototype.deleteItem = function(id) {
	$thisitem = this.$agendaitems.find('[value="' + id + '"]');
	$thisitem.hide( "scale", { percent: 0 }, 1000, function() {
		$(this).remove();		
	});
}

ViewAgendaSideBar.prototype.saveShow = function() {
	var me = this;
	$itemPoints = this.$agendaitems.find('li');
	itemList = new Array();
	$itemPoints.each(function() {
		id = $(this).attr("value");
		type = "";
		if(id.match("^newS") == "newS") {
			id="";
			type="Picture";
		} else if(id.match("^newV") == "newV") {
			id="";
			type="Movie";
		}
		crntItem = new Object();
		crntItem.id = id;
		crntItem.type = type;
		itemList.push(crntItem);
	});
	
	this.rpc.PpmRpc.saveShow(Array(this.selectedAgenda, itemList),
			function(jsonRpcObj) {
		console.log(jsonRpcObj);
		alert('Show saved');
		me.selectAgenda(me.selectedAgenda); // reload
	}, function(error) {
		alert(error.message + ": " + error.data.fullMessage);
	});
}

ViewAgendaSideBar.prototype.publishShow = function() {
	var me = this;
	this.rpc.PpmRpc.publishShow(this.selectedAgenda, function(jsonRpcObj) {
		console.log(jsonRpcObj);
		alert('Successfully published show');
		me.selectAgenda(me.selectedAgenda); // reload
	}, function(error) {
		alert(error.message + ": " + error.data.fullMessage);
	});
}
