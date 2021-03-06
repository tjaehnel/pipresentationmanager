// class declaration and constructor
function ViewEditor() { }

ViewPictureEditor.prototype.constructor = function(sidebar, rpc) {
	this.init(sidebar, rpc);
};

ViewEditor.prototype.init = function(sidebar, rpc) {
	var me = this;
	this.sidebar = sidebar;
	this.rpc = rpc;
	
	this.itemData = null;
	this.showId = "";
	
	this.rpcProxy = this.getRpcProxy();
	
	this.$containerHtmlPart = $('#itemsettings');
	this.$htmlPart = this.getHtmlPart();
	this.$title = this.$htmlPart.find('.title');
	this.$titletext = this.$htmlPart.find('.titletext');
	this.$title.bind("click", function() { me.activateTitleEdit() });
	
	this.$titleEdit = $('<input></input>');
	this.$titleEdit.attr('type', 'text');
	this.$titleEdit.focusout(function() { me.deactivateTitleEdit() });
	this.$titleEdit.bind("keypress", function(eventObject) {
		if(eventObject.keyCode == 13) {
			eventObject.preventDefault();
			me.deactivateTitleEdit();
		}
	});	

	this.$titleEditActivate = this.$htmlPart.find('.titleEditActivate');
	this.$titleEditActivate.bind("click", function() { me.activateTitleEdit() });
	this.$titleEditDeactivate = this.$htmlPart.find('.titleEditDeactivate');
	this.$titleEditDeactivate.bind("click", function() { me.deactivateTitleEdit() });
	
	this.$htmlPart.find('.submitbutton').click(function (eventObject) {
		eventObject.preventDefault();
		me.saveData();
	});
}

ViewEditor.prototype.getHtmlPart = function() {
	return null;
}

ViewEditor.prototype.getRpcProxy = function() {
	return rpc.ViewEditorRpc;
}

ViewEditor.prototype.editItem = function (showId, itemId) {
	var me = this;
	this.showId = showId;
	this.rpcProxy.getItemById([showId, itemId],
			function(jsonRpcObj){
		console.log(jsonRpcObj);
		me.prepareEditor(jsonRpcObj.result);
	}, function(error){
		alert(error.message + ": " + error.data.fullMessage);
	});
}

ViewEditor.prototype.prepareEditor = function (itemData) {
	this.itemData = itemData;
	this.fillEditor();
	this.activateEditor();
}

ViewEditor.prototype.fillEditor = function() {
	this.$titletext.empty();
	this.$titletext.append(this.itemData.title);
	this.$titleEditActivate.show();
}

ViewEditor.prototype.activateTitleEdit = function() {
	var me = this;
	this.$titleEdit.val(this.itemData.title);
	this.$titletext.hide();
	this.$titletext.after(this.$titleEdit);

	this.$titleEditActivate.hide();
	this.$titleEditDeactivate.show();

	this.$titleEdit.show();
	this.$titleEdit.focus();
}

ViewEditor.prototype.deactivateTitleEdit = function() {
	this.itemData.title = this.$titleEdit.val();
	this.$titletext.empty();
	this.$titletext.append(this.itemData.title);

	this.$titleEdit.hide();
	this.$titletext.show();
	
	this.$titleEditDeactivate.hide();
	this.$titleEditActivate.show();
}

ViewEditor.prototype.activateEditor = function() {
	this.$containerHtmlPart.find("> *").hide();
	this.$containerHtmlPart.append(this.$htmlPart);
	this.$htmlPart.show();
}

ViewEditor.prototype.saveData = function() {
	var me = this;

	$.blockUI({ message: "Updating item '" + me.itemData.title + "'..." });
	this.rpcProxy.saveItem([this.showId, this.itemData],
			function(jsonRpcObj){
		$.unblockUI();
		console.log(jsonRpcObj);
		//alert("updated");
		$.jGrowl("'" + me.itemData.title + "' updated",
				{ life: NOTIFY_STAY_ALIVE });
		me.sidebar.refreshItemList();
	}, function(error){
		alert(error.message + ": " + error.data.fullMessage);
	});
}
