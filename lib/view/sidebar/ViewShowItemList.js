function ViewShowItemList(rpc) {
	this.rpc = rpc;
	this.pictureEditor = new ViewPictureEditor(this, rpc);
	this.movieEditor = new ViewMovieEditor(this, rpc);
	this.$agendaitems = $("#agendaitems");
	
	
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
	
	this.showId = "";
	this.viewData;
}

ViewShowItemList.prototype.displayShow = function(showId) {
	var me = this;
	this.showId = showId;
	this.rpc.PpmRpc.getItemsForAgenda(id, function(jsonRpcObj) {
		console.log(jsonRpcObj);
		me.viewData = jsonRpcObj.result;
		me.buildItemList();
	}, function(error) {
		alert(error.message + ": " + error.data.fullMessage);
	});
}

ViewShowItemList.prototype.buildItemList = function() {
	var me = this;
	var items = this.viewData;
	this.$agendaitems.empty();
	for (var i = 0; i < items.length; i++) {
		var itemType = items[i].type;
		if(itemType == 'Picture')
		{
			this.addSlide(items[i].id, items[i].title, items[i].sidebarImage);
		}
		else if(itemType == 'Movie')
		{
			this.addVideo(items[i].id, items[i].title);
		}
	}
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

ViewShowItemList.prototype.addVideo = function(id, title) {
	var me = this;
	$newItem = $('#sidebarvideotemplate').clone();
	$newItem.show();
	$newItem.hover(
			function() { $(this).find('.sidebardelete').show() },
			function() { $(this).find('.sidebardelete').hide() }
	);
	
	$itemImage = $newItem.find('.sidebarimage');
	$itemImage.attr('src', "<?=BASEURL?>img/Video_sidebar.png");
	$itemTitle =  $newItem.find('.sidebartitle');
	$itemTitle.html(title);
	$itemDelete = $newItem.find('.sidebardelete')
	
	$itemlink = $("<li></li>");
	$itemlink.attr("value", id);
	
	bindfct = function() { // hack to preserve the correct itemdata
		var itemlink = $itemlink;
		var itemDelete = $itemDelete;
		var itemId = id;
		var itemTitle = title;
		itemlink.bind("click", function(event) {
			me.movieEditor.editItem(me.selectedAgenda, itemId);
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
