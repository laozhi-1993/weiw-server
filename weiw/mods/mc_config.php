<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			
			return [
				'config' => config::loadConfig('config'),
				'rsa' => config::loadConfig('rsa'),
				'items' => config::loadConfig('items')
			];
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};