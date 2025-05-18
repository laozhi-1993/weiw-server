<?php return function ()
{
	try
	{
		// 获取当前用户
		$user = mc_user_authentication::getUser();
		if (!$user) {
			throw new Exception('没有登录');
		}

		// 获取客户端配置
		$client = config::loadConfig('client');
		$client = reset($client);

		if (!$client) {
			return false;
		}

		// 获取用户数据
		$userData = $user->toArray();

		// 定义目录路径
		$file_handler = new file_handler("{$_SERVER['DOCUMENT_ROOT']}/files/{$client['name']}");

		if (!$file_handler->isExists()) {
			mkdir($file_handler->getFullPath(), 0777, true);
		}

		$clientData = Array();
		$clientData['username']       = $userData['name'];
		$clientData['uuid']           = $userData['uuid'];
		$clientData['accessToken']    = $userData['accessToken'];

		$clientData['id']             = $client['id'];
		$clientData['name']           = $client['name'];
		$clientData['version']        = $client['version'];
		$clientData['extensionType']  = $client['extensionType'];
		$clientData['extensionValue'] = $client['extensionValue'];
		$clientData['address']        = $client['address'];
		$clientData['authModule']     = $client['authModule'];
		$clientData['jvm']            = $client['jvm'];

		$clientData['mods']           = [];
		$clientData['downloads']      = [];



		foreach(preg_split('!\r\n|\n|\r!', $client['downloads']) as $download)
		{
			if ($download && preg_match('!(?:\[(.+)\])?(https?://.+)!i', $download, $file))
			{
				if ($file[1])
				{
					$filePath = $file[1] . '/' . urldecode(basename($file[2]));
					$fileTime = 0;
				}
				else
				{
					$filePath = 'mods/' . urldecode(basename($file[2]));
					$fileTime = 0;
				}

				$clientData['downloads'][] = [
					'url'  => $file[2],
					'path' => $filePath,
					'time' => $fileTime,
				];
			}
		}

		foreach ($file_handler->getFilesRecursively() as $file)
		{
			$clientData['downloads'][] = [
				'url'  => $file[1],
				'path' => $file[2],
				'time' => $file[0],
			];
		}

		foreach($clientData['downloads'] as $fileDownload)
		{
			if (preg_match('!^mods/.*jar$!i', $fileDownload['path'] ?? ''))
			{
				$clientData['mods'][] = basename($fileDownload['path']);
			}
		}


		return $clientData;
	}
	catch (Exception $Exception)
	{
		return ['error' => $Exception->getMessage()];
	}
};