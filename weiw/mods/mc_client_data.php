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
		$rootDir = file_handler::getRootDir();
		$clientDir = $rootDir . DIRECTORY_SEPARATOR . $client['name'];

		if (!file_exists($clientDir)) {
			mkdir($clientDir, 0777, true);
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

		foreach (file_handler::getFilesRecursively($clientDir, $clientDir) as $file)
		{
			$fileTime = filemtime($clientDir . DIRECTORY_SEPARATOR . $file);
			$filePath = str_replace('\\', '/', $file);
			$fileUrl  = http::get_current_url("files/{$client['name']}/{$filePath}");

			$fileDownloads[$filePath] = [
				'url'  => $fileUrl,
				'path' => $filePath,
				'time' => $fileTime,
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