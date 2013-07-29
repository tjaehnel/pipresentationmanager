ViewMovieFilePicker.prototype = new ViewFilePicker();
ViewMovieFilePicker.prototype.constructor = ViewMovieFilePicker;
ViewMovieFilePicker.prototype.parent = ViewFilePicker.prototype;

function ViewMovieFilePicker(rpc) {
	this.init(rpc);
}

ViewMovieFilePicker.prototype.populateFileList = function() {
	var me = this;
	this.rpc.ViewMovieFilePickerRpc.getMovies('', function(jsonRpcObj) {
		console.log(jsonRpcObj);
		me.buildItemList(jsonRpcObj.result);
	}, function(error) {
		alert(error.message + ": " + error.data.fullMessage);
	});
}