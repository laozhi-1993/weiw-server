<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$requiredParams = [
				'version',
				'extension-type',
				'extension-value',
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
			
			if ($clientManager->isClient($_POST['name']))
			{
				throw new Exception('客户端已存在');
			}
			
			if (!in_array($_POST['extension-type'], ['fabric', 'forge', 'neoforge'], true)) {
				$_POST['extension-type'] = 'none';
			}
			
			
			$client = new client($_POST['name']);
			$client->setManifest('version',        $_POST['version']);
			$client->setManifest('extensionType',  $_POST['extension-type']);
			$client->setManifest('extensionValue', $_POST['extension-value']);
			$client->setManifest('weight',         $_POST['weight']);
			$client->setManifest('server',         $_POST['server']);
			$client->setManifest('jvm',            $_POST['jvm']);
			$client->setManifest('downloads',      $_POST['downloads']);
			
			
			if (!$clientManager->saveClient($client))
			{
				throw new Exception('创建客户端失败');
			}
			
			return ['message' => 'ok'];
		}
		catch (Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};