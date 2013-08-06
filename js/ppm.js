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
	
	this.showItemList.initView();
}

ViewAgendaSideBar.prototype.selectAgenda = function(id) {
	this.showItemList.displayShow(id);
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

