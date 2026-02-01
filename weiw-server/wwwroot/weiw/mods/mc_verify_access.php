<?php return function ()
	{
		if(!isset($_SERVER['HTTP_USER_AGENT']) or !stristr($_SERVER['HTTP_USER_AGENT'],'weiw-'))
		{
			http_response_code(403);
			exit;
		}
		
		if(!mc_user_authentication::getUser())
		{
			http_response_code(401);
			exit;
		}
	};