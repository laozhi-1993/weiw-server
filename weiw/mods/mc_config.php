<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			
			return [
				'config' => config::loadConfig('config'),
				'rcon' => config::loadConfig('rcon'),
				'rsa' => config::loadConfig('rsa'),
				'items' => config::loadConfig('items'),
				'client' => config::loadConfig('client')
			];
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};