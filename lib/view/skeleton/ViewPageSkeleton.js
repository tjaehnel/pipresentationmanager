var NOTIFY_STAY_ALIVE = 2000;

$( document ).ready(function() {
	stm = new SimpleTaskManager();
	rpc = new jsonrpcphp('rpc.php', stm, function() {
		var showSidebar = new ViewShowList(rpc);
		showSidebar.initView();
		showSidebar.reloadShowList();
	});
});