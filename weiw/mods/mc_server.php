<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			
			return config::loadConfig('config');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};