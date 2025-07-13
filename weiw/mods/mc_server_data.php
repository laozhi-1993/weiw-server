<?php return function ()
	{
		try
		{
			$serverData = Array();
			$serverData['downloads'] = [];
			$serverData['mods'] = [];

			// 获取客户端配置
			if (isset($_GET['id']))
			{
				$clients = config::loadConfig('client');
				$client  = $clients[$_GET['id']] ?? false;
			}
			else
			{
				$clients = config::loadConfig('client');
				$client  = reset($clients);
			}

			if (!$client)
			{
				return $serverData;
			}

			// 定义目录路径
			$file_handler = new file_handler("{$_SERVER['DOCUMENT_ROOT']}/files/{$client['name']}/mods");


			foreach(preg_split('!\r\n|\n|\r!', $client['downloads']) as $download)
			{
				if ($download && preg_match('!(?:\[(.+)\])?(https?://.+)!i', $download, $file))
				{
					$file[1] || $serverData['downloads'][] = [
						'url' => $file[2],
						'path' => 'mods/' . rawurldecode(basename($file[2])),
					];
				}
			}

			foreach ($file_handler->getDirectoryListing() as $file)
			{
				if (strpos($file['name'], '[c]') !== 0)
				{
					$serverData['downloads'][] = [
						'url' => $file['url'],
						'path' => 'mods/' . $file['name'],
					];
				}
			}

			foreach($serverData['downloads'] as $fileDownload)
			{
				if (preg_match('!^mods/.*jar$!i', $fileDownload['path'] ?? ''))
				{
					$serverData['mods'][] = basename($fileDownload['path']);
				}
			}

			return $serverData;
		}
		catch (Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};