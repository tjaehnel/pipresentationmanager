$( document ).ready(function() {
	rpc = new jsonrpcphp('rpc.php', function() {
		var showSidebar = new ViewShowList(rpc);
		showSidebar.initView();
		showSidebar.reloadShowList();
	});
});