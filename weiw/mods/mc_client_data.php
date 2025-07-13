<?php return function ()
	{
		try
		{
			// 获取当前用户
			$user = mc_user_authentication::getUser();
			if (!$user) {
				throw new Exception('没有登录');
			}

			$client = new class()
			{
				private $clients;
				private $client;

				public function __construct()
				{
					$this->clients = config::loadConfig('client');
					$this->client = reset($this->clients);
				}

				public function isClientEmpty()
				{
					if ($this->client) {
						return false;
					}

					return true;
				}

				public function getClient($key)
				{
					if (isset($this->client[$key])) {
						return $this->client[$key];
					}

					return false;
				}

				public function getAuthServerUrl()
				{
					$config = config::loadConfig('config');

					if ($config['authServerUrl']) {
						return $config['authServerUrl'];
					}

					return http::get_current_url('weiw/index_auth.php');
				}

				public function getAuthPath()
				{
					return rawurldecode(basename($this->getClient('authUrl')));
				}

				public function getJvm()
				{
					return array_filter(preg_split('!\r\n|\n|\r!', $this->getClient('jvm')));
				}
				
				public function getServer()
				{
					$servers = array();
					$serverLines = array_filter(preg_split('!\r\n|\n|\r!', $this->getClient('server')));

					foreach($serverLines as $serverLine)
					{
						$serverComponents = array_filter(explode(':', $serverLine));

						$servers[] = [
							'address' => $serverComponents [0] ?? '127.0.0.1',
							'port'    => $serverComponents [1] ?? '25565',
							'name'    => $serverComponents [2] ?? '我的世界服务器',
						];
					}

					return $servers;
				}
			};


			if ($client->isClientEmpty()) {
				return false;
			}


			// 获取用户数据
			$userData = $user->toArray();
			// 定义目录路径
			$file_handler = new file_handler("{$_SERVER['DOCUMENT_ROOT']}/files/{$client->getClient('name')}");


			$clientData = Array();
			$clientData['username']    = $userData['name'];
			$clientData['uuid']        = $userData['uuid'];
			$clientData['accessToken'] = $userData['accessToken'];

			$clientData['id']             = $client->getClient('id');
			$clientData['name']           = $client->getClient('name');
			$clientData['version']        = $client->getClient('version');
			$clientData['extensionType']  = $client->getClient('extensionType');
			$clientData['extensionValue'] = $client->getClient('extensionValue');
			$clientData['jvm']            = $client->getJvm();
			$clientData['server']         = $client->getServer();
			$clientData['authPath']       = $client->getAuthPath();
			$clientData['authServerUrl']  = $client->getAuthServerUrl();

			$clientData['mods'] = Array();
			$clientData['downloads'] = Array([
				'url'  => $client->getClient('authUrl'),
				'path' => $client->getAuthPath(),
				'time' => 0,
			]);


			foreach(preg_split('!\r\n|\n|\r!', $client->getClient('downloads')) as $download)
			{
				if ($download && preg_match('!(?:\[(.+)\])?(https?://.+)!i', $download, $file))
				{
					if ($file[1])
					{
						$filePath = $file[1] . '/' . rawurldecode(basename($file[2]));
						$fileTime = 0;
					}
					else
					{
						$filePath = 'mods/' . rawurldecode(basename($file[2]));
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