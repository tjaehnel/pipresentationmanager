function ViewShowItemList(rpc) {
	this.rpc = rpc;
	this.pictureEditor = new ViewPictureEditor(this, rpc);
	this.movieEditor = new ViewMovieEditor(this, rpc);
	
	this.$containerHtmlPart = $("#agenda");
	this.$htmlPart = $("#agendaitemscontainer");
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
	this.viewData = null;
	
	this.rpcProxy = this.rpc.ViewShowItemListRpc;
}

ViewShowItemList.prototype.initView = function() {
	var me = this;
	this.$showItems.sortable();
	this.$showItems.disableSelection();
	
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


ViewShowItemList.prototype.refreshItemList = function() {
	this.displayShow(this.showId);
}

ViewShowItemList.prototype.displayShow = function(showId) {
	var me = this;
	this.showId = showId;
	this.rpcProxy.getItemsForShow(this.showId, function(jsonRpcObj) {
		console.log(jsonRpcObj);
		me.viewData = jsonRpcObj.result;
		me.buildItemList();
	}, function(error) {
		alert(error.message + ": " + error.data.fullMessage);
	});
	this.activateView();
}

ViewShowItemList.prototype.activateView = function() {
	this.$containerHtmlPart.append(this.$htmlPart);
	this.$htmlPart.show();
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


ViewShowItemList.prototype.deleteItem = function(id) {
	$thisitem = this.$showItems.find('[value="' + id + '"]');
	$thisitem.hide( "scale", { percent: 0 }, 1000, function() {
		$(this).remove();		
	});
}

ViewShowItemList.prototype.markItemSelected = function($item) {
	$('#agendaitems li').removeClass('selected');
	$item.addClass('selected');
}


ViewShowItemList.prototype.saveShow = function() {
	var me = this;
	$itemPoints = this.$showItems.find('li');
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
	
	this.rpcProxy.saveShow(Array(this.showId, itemList),
			function(jsonRpcObj) {
		console.log(jsonRpcObj);
		alert('Show saved');
		me.refreshItemList();
	}, function(error) {
		alert(error.message + ": " + error.data.fullMessage);
	});
}

ViewShowItemList.prototype.publishShow = function() {
	var me = this;
	this.rpcProxy.publishShow(this.showId, function(jsonRpcObj) {
		console.log(jsonRpcObj);
		alert('Successfully published show');
		me.refreshItemList();
	}, function(error) {
		alert(error.message + ": " + error.data.fullMessage);
	});
}
