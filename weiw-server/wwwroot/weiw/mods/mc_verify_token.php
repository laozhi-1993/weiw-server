<?php return function ()
	{
		$user = mc_user_authentication::getUser($_GET['token'] ?? '');
		if($user)
		{
			$user->setLoginTime();
			$userManager = new mc_user_manager();
			$userManager->saveToFile($user);
			
			mc_user_authentication::setLoginToken($user);
			header("Location: /launcher/");
			exit;
		}
		else
		{
			http_response_code(401);
			exit;
		}
	};