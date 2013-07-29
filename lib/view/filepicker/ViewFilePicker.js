function ViewFilePicker(rpc) {
	this.init();
}

ViewFilePicker.prototype.init = function(rpc) {
	this.rpc = rpc;
	this.$dialog = $("#filepickerdialog");
	this.$dialog.dialog({
		modal: true,
		autoOpen: false,
		height: 500,
		width: 800,
		buttons: {
			Cancel: function() {
				$( this ).dialog("close");
			}
		}
	});
	this.$filepickeritems = $("#filepickeritems");
	this.selectedFile = "";
	this.selectEvent = null;
}

ViewFilePicker.prototype.setSelectedFile = function(filename) {
	this.selectedFile = filename;
}
ViewFilePicker.prototype.getSelectedFile = function() {
	return this.selectedFile;
}

ViewFilePicker.prototype.show = function(selectEvent) {
	this.selectEvent = selectEvent;
	this.$filepickeritems.empty();
	this.populateFileList();
	this.$dialog.dialog("open");
}

ViewFilePicker.prototype.populateFileList = function() {
	return;
}

ViewFilePicker.prototype.buildItemList = function(items) {
	var me = this;
	this.$filepickeritems.empty();
	for (var i = 0; i < items.length; i++) {
		$itemTitle = $('<span></span>');
		$itemTitle.html(items[i].title);
		$itemImage = $('<img/>');
		$itemImage.attr('src', items[i].thumbnail);
		$itemlink = $("<li></li>");
		$itemlink.append($itemImage, $itemTitle);
		bindfct = function() { // hack to preserve the correct itemdata
			var itemlink = $itemlink;
			var itemTitle = items[i].title;
			itemlink.bind("click", function(event) {
				event.preventDefault();
				me.selectedFile = itemTitle;
				me.$dialog.dialog("close");
				me.selectEvent(me.selectedFile);
			});			
		}
		bindfct();
		this.$filepickeritems.append($itemlink);
	}
}
