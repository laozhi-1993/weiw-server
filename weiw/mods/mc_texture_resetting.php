<?php return function ()
	{
		try
		{
			if(!$user = mc_user_authentication::getUser())
			{
				throw new Exception('没有登录');
			}
			
			
			$userManager = new mc_user_manager();
			$user->setTexture('', 'steve');
			$user->setTexture('', 'cape');
			$user->saveToJson($userManager->getUserDir());
			
			throw new Exception('ok');
		}
		catch(Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};