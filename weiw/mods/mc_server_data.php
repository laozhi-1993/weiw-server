<?php return function ()
{
	try
	{
		$serverData = Array();
		$serverData['mods'] = [];

		// 获取客户端配置
		$client = config::loadConfig('client');
		$client = reset($client);

		if (!$client) {
			return $serverData;
		}

		// 定义目录路径
		$file_handler = new file_handler("{$_SERVER['DOCUMENT_ROOT']}/files/{$client['name']}/mods");


		foreach(preg_split('!\r\n|\n|\r!', $client['downloads']) as $download)
		{
			if ($download && preg_match('!(?:\[(.+)\])?(https?://.+)!i', $download, $file))
			{
				$file[1] || $serverData['mods'][] = $file[2];
			}
		}

		foreach ($file_handler->getDirectoryListing() as $file)
		{
			if (strpos($file['name'], '[c]') !== 0)
			{
				$serverData['mods'][] = $file['url'];
			}
		}

		return $serverData;
	}
	catch (Exception $Exception)
	{
		return ['error' => $Exception->getMessage()];
	}
};