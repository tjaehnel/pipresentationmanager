function ViewShowItemList(rpc) {
	this.rpc = rpc;
	this.pictureEditor = new ViewPictureEditor(this, rpc);
	this.movieEditor = new ViewMovieEditor(this, rpc);
	this.$showItems = $("#agendaitems");
	
	
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

ViewShowItemList.prototype.refreshItemList = function() {
	this.displayShow(this.showId);
}

ViewShowItemList.prototype.displayShow = function(showId) {
	var me = this;
	this.showId = showId;
	this.rpc.PpmRpc.getItemsForAgenda(this.showId, function(jsonRpcObj) {
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
	this.$showItems.empty();
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

ViewShowItemList.prototype.addSlide = function(id, title, imgFilename) {
	$template = $('#sidebarslidetemplate');
	this.addItem(
			$template, id, title,
			imgFilename, this.pictureEditor
	);	
}

ViewShowItemList.prototype.addVideo = function(id, title) {
	$template = $('#sidebarvideotemplate');
	this.addItem(
			$template, id, title,
			"<?=BASEURL?>img/Video_sidebar.png", this.movieEditor
	);
}

ViewShowItemList.prototype.addItem =
			function($template, itemId, itemTitle, imgUrl, editorInstance) {
	$newItem = $template.clone();
	
	$itemImage = $newItem.find('.sidebarimage');
	$itemImage.attr('src', imgUrl);
	$itemTitle =  $newItem.find('.sidebartitle');
	$itemTitle.html(itemTitle);
	$itemDeleteBtn = $newItem.find('.sidebardelete')
	
	$itemlink = $("<li></li>");
	$itemlink.attr("value", itemId);
	
	this.createHoverAction($newItem);
	this.createEditAction(itemId, $itemlink, editorInstance);
	this.createDeleteAction(itemId, itemTitle, $itemDeleteBtn);

	$itemlink.append($newItem);
	this.$showItems.append($itemlink);
	
	$newItem.show();
}

ViewShowItemList.prototype.createHoverAction = function($newItem) {
	$newItem.hover(
			function() { $(this).find('.sidebardelete').show() },
			function() { $(this).find('.sidebardelete').hide() }
	);
}

ViewShowItemList.prototype.createEditAction =
			function(itemId, $itemlink, editorInstance) {
	var me = this;
	$itemlink.bind("click", function(event) {
		editorInstance.editItem(me.showId, itemId);
		me.markItemSelected($itemlink);
	});
}

ViewShowItemList.prototype.createDeleteAction =
			function(itemId, itemTitle, $itemDeleteBtn) {
	var me = this;
	$itemDeleteBtn.bind("click", function(event) {
		me.$deleteConfirmDialog.find(".itemtitle").html(itemTitle);
		me.$deleteConfirmDialog.dialog({
			buttons: {
				"Yes": function() {
					me.deleteItem(itemId);
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


ViewShowItemList.prototype.markItemSelected = function($item) {
	$('#agendaitems li').removeClass('selected');
	$item.addClass('selected');
}
