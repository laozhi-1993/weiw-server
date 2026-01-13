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
				throw new Exception('非法的客户端名字');
			}
			
			if (!$clientManager->isClient($name))
			{
				throw new Exception('客户端不存在');
			}
			
			$client = $clientManager->getClient($name);
			if (!$client)
			{
				throw new Exception('读取客户端数据失败');
			}
			
			
			return ['name' => $name, ...$client->getManifest()];
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};