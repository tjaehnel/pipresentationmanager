ViewPictureFilePicker.prototype = new ViewFilePicker();
ViewPictureFilePicker.prototype.constructor = ViewPictureFilePicker;
ViewPictureFilePicker.prototype.parent = ViewFilePicker.prototype;

function ViewPictureFilePicker(rpc) {
	this.init(rpc);
}

ViewPictureFilePicker.prototype.populateFileList = function() {
	var me = this;
	this.rpc.ViewPictureFilePickerRpc.getImages('', function(jsonRpcObj) {
		console.log(jsonRpcObj);
		me.buildItemList(jsonRpcObj.result);
	}, function(error) {
		alert(error.message + ": " + error.data.fullMessage);
	});
}