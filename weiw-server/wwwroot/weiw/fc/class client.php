<?php


class Client
{
	private $config;
	private $manifest;
	private $name;
	
	public function __construct(string $name, array $manifest=[])
	{
		$this->config   = config::loadConfig('config');
		$this->name     = $name;
		$this->manifest = $manifest;
	}
	
	
	public function getAuthServerUrl()
	{
		if (isset($this->config['authServerUrl']) && $this->config['authServerUrl']) {
			return $this->config['authServerUrl'];
		}

		return http::get_current_url('weiw/index_auth.php');
	}

	public function getAuthDownloadUrl()
	{
		if (isset($this->config['authDownloadUrl'])) {
			return $this->config['authDownloadUrl'];
		}

		return '';
	}
	
	public function getAuthPath()
	{
		if (isset($this->config['authDownloadUrl'])) {
			return rawurldecode(basename($this->config['authDownloadUrl']));
		}

		return '';
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getManifest($key = null)
	{
		if ($key === null) {
			return $this->manifest;
		}
		
		if (isset($this->manifest[$key])) {
			return $this->manifest[$key];
		}
		
		return false;
	}
	
	
	public function setVersion($value)
	{
		$this->manifest['version'] = $value;
	}
	
	public function setExtensionType($value)
	{
		$this->manifest['extensionType'] = $value;
	}
	
	public function setExtensionValue($value)
	{
		$this->manifest['extensionValue'] = $value;
	}
	
	public function setWeight($value)
	{
		if (is_numeric($value)) {
			$this->manifest['weight'] = $value;
		} else {
			$this->manifest['weight'] = 0;
		}
	}
	
	public function setServer($value)
	{
		$servers = array();
		$serverLines = array_filter(preg_split('!\r\n|\n|\r!', $value));
		
		foreach($serverLines as $serverLine)
		{
			$serverComponents = array_filter(explode(':', $serverLine, 3));
			
			$servers[] = [
				'address' => $serverComponents [0] ?? '127.0.0.1',
				'port'    => $serverComponents [1] ?? '25565',
				'name'    => $serverComponents [2] ?? '我的世界服务器',
			];
		}
		
		$this->manifest['server'] = $servers;
	}
	
	public function setJvm($value)
	{
		$this->manifest['jvm'] = preg_split('!\r\n|\n|\r!', $value);
	}
	
	public function setGame($value)
	{
		$this->manifest['game'] = preg_split('!\r\n|\n|\r!', $value);
	}
	
	public function setDownloads($value)
	{
		$this->manifest['downloads'] = $value;
	}
	
	
	public function isManifestEmpty()
	{
		if ($this->manifest) {
			return false;
		}
		
		return true;
	}
	
	public function buildClientData(mc_user $user, string $clientDirPath)
	{
		if ($this->isManifestEmpty()) {
			return false;
		}
		
		// 获取用户数据
		$userData = $user->toArray();
		// 定义目录路径
		$FileManager = new FileManager($clientDirPath, http::get_current_url('clients', $this->getName()));
		
		
		$clientData = Array();
		$clientData['username']    = $userData['name'];
		$clientData['uuid']        = $userData['uuid'];
		$clientData['accessToken'] = $userData['accessToken'];
		
		$clientData['name']          = $this->getName();
		$clientData['authPath']      = $this->getAuthPath();
		$clientData['authServerUrl'] = $this->getAuthServerUrl();
		
		$clientData['weight']         = $this->getManifest('weight');
		$clientData['version']        = $this->getManifest('version');
		$clientData['extensionType']  = $this->getManifest('extensionType');
		$clientData['extensionValue'] = $this->getManifest('extensionValue');
		$clientData['jvm']            = $this->getManifest('jvm');
		$clientData['game']           = $this->getManifest('game');
		$clientData['server']         = $this->getManifest('server');
		
		
		$clientData['mods'] = Array();
		$clientData['downloads'] = Array([
			'url'  => $this->getAuthDownloadUrl(),
			'path' => $this->getAuthPath(),
			'time' => 0,
		]);
		
		
		foreach(preg_split('!\r\n|\n|\r!', $this->getManifest('downloads')) as $download)
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
		
		foreach($FileManager->getAllFiles() as $file)
		{
			$clientData['downloads'][] = [
				'url'  => $file['url'],
				'path' => $file['path'],
				'time' => $file['time'],
			];
		}
		
		foreach($clientData['downloads'] as $fileDownload)
		{
			if (preg_match('!^mods/[^/]*$!i', $fileDownload['path'] ?? ''))
			{
				$clientData['mods'][] = basename($fileDownload['path']);
			}
		}
		
		
		return $clientData;
	}
}
