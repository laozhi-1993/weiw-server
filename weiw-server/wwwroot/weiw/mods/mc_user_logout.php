<?php return function ()
	{
		$user = mc_user_authentication::getUser();
		if($user)
		{
			mc_user_authentication::clearLoginToken($user);
		}
		
		http_response_code(401);
		exit;
	};