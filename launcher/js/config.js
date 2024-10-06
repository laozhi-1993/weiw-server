	function server()
	{
		url = {"mods":"mc_config_save","type":"config"};
		url['serverName']    = $("#serverName").val();
		url['domain']        = $("#domain").val();
		url['download']      = $("#download").val();
		url['authUrl']       = $("#authUrl").val();
		url['defaultMoney']  = $("#defaultMoney").val();
		url['checkinMoney']  = $("#checkinMoney").val();
		$.getJSON("/weiw/index.php",url,function (result){
			showMessage(result.error);
		});
	}
	function rcon()
	{
		url = {"mods":"mc_config_save","type":"rcon"};
		url['host']      = $("#host").val();
		url['post']      = $("#post").val();
		url['password']  = $("#password").val();
		url['time']      = $("#time").val();
		$.getJSON("/weiw/index.php",url,function (result){
			showMessage(result.error);
		});
	}
	function rsa()
	{
		url = {"mods":"mc_config_save","type":"rsa"};
		url['private'] = $("textarea[name='private']").val();
		url['public']  = $("textarea[name='public']").val();
		$.getJSON("/weiw/index.php",url,function (result){
			showMessage(result.error);
		});
	}
	function items()
	{
		url = {"mods":"mc_config_save","type":"items"};
		url['value'] = $("textarea[name='items']").val();
		$.getJSON("/weiw/index.php",url,function (result){
			showMessage(result.error);
		});
	}