ViewPictureEditor.prototype = new ViewEditor();
ViewPictureEditor.prototype.constructor = ViewPictureEditor;
ViewPictureEditor.prototype.parent = ViewEditor.prototype;

// class declaration and constructor
function ViewPictureEditor(sidebar, rpc) {
	var me = this;
	this.init(sidebar, rpc);
		
	this.$previewImage = this.$htmlPart.find('.previewImage');
	this.$imageTextEditor = this.$htmlPart.find('.imageText');
	this.picturePickDialog = new ViewPictureFilePicker(rpc);
	
	$("#selectPictureLink").click(function (eventObject) {
		eventObject.preventDefault();
		me.picturePickDialog.setSelectedFile("");
		me.picturePickDialog.show(function(selectedFile) {
			me.setPreviewImage(selectedFile);
			me.determineAndSetTextEditorVisibility();
		});
	});
	this.$imageTextEditor.bind('input propertychange', function() {
		me.itemData.imageText = me.$imageTextEditor.val();
	});
}

ViewPictureEditor.prototype.getHtmlPart = function() {
	return $('#pictureEditor');
}

ViewPictureEditor.prototype.getRpcProxy = function() {
	return rpc.ViewPictureEditorRpc;
}

ViewPictureEditor.prototype.setPreviewImage = function(filename) {
	var me = this;
	this.itemData.imageFilename = filename;
	this.rpcProxy.getPreviewImageByFilename(
			filename, function(jsonRpcObj) {
		console.log(jsonRpcObj);
		me.$previewImage.attr("src", jsonRpcObj.result);
	}, function(error){
		alert(error.message + ": " + error.data.fullMessage);
	});
}

ViewPictureEditor.prototype.determineAndSetTextEditorVisibility = function() {
	var me = this;
	$.blockUI({ message: "Fetching image configuration...'" });
	this.rpcProxy.imageHasTextConfiguration(this.itemData.imageFilename,
			function(jsonRpcObj){
		console.log(jsonRpcObj);
		if(jsonRpcObj.result.hasTextConfiguration == true) {
			me.$imageTextEditor.show();
		} else {
			me.$imageTextEditor.hide();
		}
		$.unblockUI();
	}, function(error){
		me.$imageTextEditor.hide();
		alert(error.message + ": " + error.data.fullMessage);
		$.unblockUI();
	});
}

ViewPictureEditor.prototype.fillEditor = function () {
	this.parent.fillEditor.call(this);

	this.$previewImage.attr('src', this.itemData.previewImage);
	
	this.$imageTextEditor.val(this.itemData.imageText);
	if(this.itemData.imageTextConfigAvailable) {
		this.$imageTextEditor.show();
	} else {
		this.$imageTextEditor.hide();
	}
	
}

