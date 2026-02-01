<?php


class Client_manager
{
	private $rootdir;
	
	public function __construct()
	{
		$this->rootdir  = dirname(dirname(__MKHDIR__));
		$this->rootdir .= DIRECTORY_SEPARATOR;
		$this->rootdir .= 'clients';
		
		if (!is_dir($this->rootdir)) {
			mkdir($this->rootdir, 0777, true);
		}
	}
	
	public function saveClient(Client $client): bool
	{
		$manifestPath = $this->buildManifestPath($client->getName());
		$dirPath = dirname($manifestPath);
		
		if (!file_exists($dirPath)) {
			if (!mkdir($dirPath, 0777, true)) {
				return false;
			}
		}
		
		$json = json_encode($client->getManifest(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		return file_put_contents($manifestPath, $json);
	}
	
	public function isValidName(string $clientname): bool
	{
		// 检查名字长度
		if ($clientname === '' || strlen($clientname) > 100) {
			return false;
		}
		
		// 检查特殊目录名 . 和 ..
		if ($clientname === '.' || $clientname === '..') {
			return false;
		}
		
		// 非法字符（包括控制字符）
		if (preg_match('#[\\\\\/:\*\?"<>\|\x00-\x1F]#', $clientname)) {
			return false;
		}
		
		// 结尾空格或点（包括制表符）
		if (preg_match('#[ .\t]$#', $clientname)) {
			return false;
		}
		
		// 保留名（包括 COM0/LPT0，忽略扩展名）
		$name = strtoupper(pathinfo($clientname, PATHINFO_FILENAME));
		if (preg_match('#^(CON|PRN|AUX|NUL|COM[0-9]|LPT[0-9])$#', $name)) {
			return false;
		}
		
		return true;
	}
	
	public function isClient(string $name): bool
	{
		$manifestPath  = $this->buildManifestPath($name);
		
		if (!file_exists($manifestPath))
		{
			return false;
		}
		
		if (!is_file($manifestPath))
		{
			return false;
		}
		
		return true;
	}
	
	public function getClient(string $name): false|client
	{
		if (!$this->isClient($name))
		{
			return false;
		}
		
		$manifestPath  = $this->buildManifestPath($name);
		$jsonStr = file_get_contents($manifestPath);
		$manifest = json_decode($jsonStr, true);
		
		if (json_last_error() === JSON_ERROR_NONE)
		{
			return new Client($name, $manifest);
		}
		else
		{
			return false;
		}
	}
	
	public function getAllClient(mc_user $user): array
	{
		$manifests = [];
		$list = array_map('realpath', glob($this->rootdir . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR));
		
		foreach($list as $clientPath)
		{
			$client = $this->getClient(basename($clientPath));
			if (!$client) {
				continue;
			}
			
			$manifest = $client->buildClientData($user, $clientPath);
			if ($manifest) {
				$manifests[] = $manifest;
			}
		}
		
		usort($manifests, function($a, $b) {
			$weightA = $a['weight'] ?? 0;
			$weightB = $b['weight'] ?? 0;
			
			if (!is_numeric($weightA)) {
				$weightA = 0;
			}
			
			if (!is_numeric($weightB)) {
				$weightB = 0;
			}
			
			return $weightB - $weightA;
		});
		
		return $manifests;
	}
	
	private function buildManifestPath(string $name): string
	{
		$manifestPath  = $this->rootdir;
		$manifestPath .= DIRECTORY_SEPARATOR;
		$manifestPath .= $name;
		$manifestPath .= DIRECTORY_SEPARATOR;
		$manifestPath .= 'manifest.json';
		
		return $manifestPath;
	}
}