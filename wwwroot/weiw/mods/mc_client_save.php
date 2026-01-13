<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$requiredParams = [
				'name',
				'weight',
				'server',
				'jvm',
				'downloads',
			];
			
			foreach ($requiredParams as $param) {
				if (!isset($_POST[$param])) {
					throw new Exception("缺少参数 $param");
				}
			}
			
			$clientManager = new client_manager();
			if (!$clientManager->isValidName($_POST['name']))
			{
				throw new Exception('非法的客户端名字');
			}
			
			if (!$clientManager->isClient($_POST['name']))
			{
				throw new Exception('客户端不存在');
			}
			
			$client = $clientManager->getClient($_POST['name']);
			if (!$client)
			{
				throw new Exception('读取客户端数据失败');
			}
			
			
			$client->setManifest('weight',          $_POST['weight']);
			$client->setManifest('server',          $_POST['server']);
			$client->setManifest('jvm',             $_POST['jvm']);
			$client->setManifest('downloads',       $_POST['downloads']);
			
			
			if (!$clientManager->saveClient($client))
			{
				throw new Exception('保存失败');
			}
			
			return ['message' => 'ok'];
		}
		catch (Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};