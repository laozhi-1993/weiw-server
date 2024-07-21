<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");
	
	
	$auth = new mc_auth();
	$auth->handleAuthenticationRequest();