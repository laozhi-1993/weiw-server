<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");
	
	
	$config = config::ini('config');
	$Yggdrasil = explode('/',$config['Yggdrasil']);
	$Yggdrasil = explode(':',$Yggdrasil[2]);
	$auth = new mc_auth();
	$auth ->skinDomains[] = $Yggdrasil[0];
	$auth ->serverName    = $config['serverName'];