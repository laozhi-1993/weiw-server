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
		$file_handler = new file_handler($client['name'], "{$_SERVER['DOCUMENT_ROOT']}/files");

		if (!$file_handler->isExists()) {
			mkdir($file_handler->getFullPath(), 0777, true);
		}

		$fileDownloads                = Array();
		$clientData                   = Array();

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



		if (preg_match_all('!\[(.+)\](https?://[^\s]+)!i', $client['downloads'], $downloads, PREG_SET_ORDER))
		{
			foreach($downloads as $download)
			{
				$filePath = $download[1] . '/' . urldecode(basename($download[2]));
				$fileTime = 0;

				$fileDownloads[$filePath] = [
					'url'  => $download[2],
					'path' => $filePath,
					'time' => $fileTime,
				];
			}
		}

		foreach ($file_handler->getFilesRecursively() as $file)
		{
			$fileDownloads[$file[2]] = [
				'url'  => $file[1],
				'path' => $file[2],
				'time' => $file[0],
			];
		}

		foreach($fileDownloads as $fileDownload)
		{
			if (preg_match('!^mods/.*jar$!i', $fileDownload['path'] ?? ''))
			{
				$clientData['mods'][] = basename($fileDownload['path']);
			}

			$clientData['downloads'][] = $fileDownload;
		}


		return $clientData;
	}
	catch (Exception $Exception)
	{
		return ['error' => $Exception->getMessage()];
	}
};