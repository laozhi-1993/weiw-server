<?php return function ()
	{
		try
		{
			if(!$user = mc_user_authentication::getUser())
			{
				throw new Exception('没有登录');
			}
			
			
			$user->setTexture('', 'steve');
			$userManager = new mc_user_manager();
			$userManager->saveToFile($user);
			
			return ['success' => 'ok'];
		}
		catch(Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};