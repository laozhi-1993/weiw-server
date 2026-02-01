<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$requiredParams = [
				'name',
				'version',
				'extension-type',
				'extension-value',
				'weight',
				'server',
				'jvm',
				'game',
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
			
			if (!in_array($_POST['extension-type'], ['fabric', 'forge', 'neoforge'], true)) {
				$_POST['extension-type'] = 'none';
			}
			
			
			$client = new client($_POST['name']);
			$client->setVersion($_POST['version']);
			$client->setExtensionType($_POST['extension-type']);
			$client->setExtensionValue($_POST['extension-value']);
			$client->setWeight($_POST['weight']);
			$client->setServer($_POST['server']);
			$client->setJvm($_POST['jvm']);
			$client->setGame($_POST['game']);
			$client->setDownloads($_POST['downloads']);
			
			
			if ($clientManager->isClient($_POST['name']))
			{
				$clientManager->saveClient($client);
				return ['message' => 'save'];
			}
			else
			{
				$clientManager->saveClient($client);
				return ['message' => 'add'];
			}
		}
		catch (Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};