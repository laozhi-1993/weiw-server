<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$name = $_GET['name'] ?? '';
			$clientManager = new client_manager();
			if (!$clientManager->isValidName($name))
			{
				return [];
			}
			
			if (!$clientManager->isClient($name))
			{
				return [];
			}
			
			$client = $clientManager->getClient($name);
			if (!$client)
			{
				return [];
			}
			
			
			return ['name' => $name, ...$client->getManifest()];
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};