ViewMovieEditor.prototype = new ViewEditor();
ViewMovieEditor.prototype.constructor = ViewMovieEditor;
ViewMovieEditor.prototype.parent = ViewEditor.prototype;

// class declaration and constructor
function ViewMovieEditor(sidebar, rpc) {
	var me = this;
	this.init(sidebar, rpc);

	this.$videoFilename = this.$htmlPart.find('#videoFilename');
	this.moviePickDialog = new ViewMovieFilePicker(rpc);
	
	$("#selectVideoLink").click(function (eventObject) {
		eventObject.preventDefault();
		me.moviePickDialog.setSelectedFile("");
		me.moviePickDialog.show(function(selectedFile) {
			me.setMovieTitle(selectedFile);
		});
	});
}

ViewMovieEditor.prototype.getHtmlPart = function() {
	return $('#movieEditor');
}

ViewMovieEditor.prototype.getRpcProxy = function() {
	return rpc.ViewMovieEditorRpc;
}

ViewMovieEditor.prototype.setMovieTitle = function (title) {
	this.itemData.movieFilename = title;
	this.$videoFilename.empty();
	this.$videoFilename.append(title);
}


ViewMovieEditor.prototype.fillEditor = function () {
	this.parent.fillEditor.call(this);

	this.setMovieTitle(this.itemData.movieFilename);
}
