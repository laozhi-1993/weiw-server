<?php class mc_auth
{
    private $pathInfo;
    private $data;
	private $rootDir;
	private $texturesDir;
	private $texturesTempDir;
	private $implementationName;
	private $implementationVersion;
	private $skinDomains;
	private $serverName;
	private $authServerUrl;
	private $publicKey;
	private $privateKey;
    public function __construct()
	{
		$config = config::loadConfig('config');
		
		if(isset($_SERVER['PATH_INFO']))
		{
			$this->pathInfo = $_SERVER['PATH_INFO'];
		}
		else
		{
			$this->pathInfo = Null;
		}
		
		if ($config['authServerUrl'])
		{
			$this->authServerUrl = $config['authServerUrl'];
		}
		else
		{
			$this->authServerUrl = $this->resolveAuthUrl();
		}
		
		$this->data                  = json_decode(file_get_contents('php://input'), true);
		$this->rootDir               = __MKHDIR__;
		$this->texturesDir           = __MKHDIR__.'/user_textures/';
		$this->texturesTempDir       = __MKHDIR__.'/data/textures/';
		$this->implementationName    = 'weiw auth server';
		$this->implementationVersion = '1.1.2';
		$this->publicKey             = $config['public'];
		$this->privateKey            = $config['private'];
		
		$this->serverName = $config['name'];
		$this->skinDomains[] = parse_url($this->authServerUrl, PHP_URL_HOST);
		
		
		if (!is_dir($this->texturesTempDir))
		{
			mkdir($this->texturesTempDir, 0777, true);
		}
    }
	
	
	public function resolveAuthUrl()
	{
		$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
		$host = $_SERVER['HTTP_HOST'];
		return "{$protocol}://{$host}/weiw/index_auth.php";
	}
	
	
	public function encodeTextures($user)
	{
		// 材质信息属性
		$textures['timestamp'] = time() * 1000;
		$textures['profileId'] = $user->uuid;
		$textures['profileName'] = $user->name;
		
		
		if(strlen($user->CAPE['hash']) == 64)
		{
			$textures['textures']['CAPE']['url'] = "{$this->authServerUrl}/texture/{$user->CAPE['hash']}";
		}
		
		
		if(strlen($user->SKIN['hash']) == 64)
		{
			$textures['textures']['SKIN']['url'] = "{$this->authServerUrl}/texture/{$user->SKIN['hash']}";
			$textures['textures']['SKIN']['metadata']['model'] = $user->SKIN['model'];
		}
		
		
		if(isset($textures['textures']))
		{
			return Array (
				'name' => 'textures',
				'value' => base64_encode(json_encode($textures))
			);
		}
		else
		{
			return false;
		}
	}
	
	
	public function encodeRole($user, $unsigned=true)
	{
		// 角色信息的序列化
		$role['id'] = $user->uuid;
		$role['name'] = $user->name;
		$role['properties'] = Array();
		
		
		if($textures = $this->encodeTextures($user))
		{
			$role['properties'][] = $textures;
		}
		
		
		if($unsigned)
		{
			foreach ($role['properties'] as $key => $value)
			{
				openssl_sign($value['value'], $signature, $this->privateKey);
				$role['properties'][$key]['signature'] = base64_encode($signature);
			}
		}
		
		
		return json_encode($role, true);
	}
	
	
	public function handleClientJoin()
	{
		// 客户端进入服务器
		if($this->pathInfo == '/sessionserver/session/minecraft/join')
		{
			if(isset($this->data['selectedProfile']))
			{
				$userManager = new mc_user_manager();
				$user = $userManager->getUserByUuid($this->data['selectedProfile']);
				
				
				if(preg_match('!^-?[A-Za-z0-9]+$!',$this->data['serverId']) && $user->accessToken == $this->data['accessToken'])
				{
					file_put_contents("{$this->rootDir}/data/serverid_{$this->data['selectedProfile']}.php","<?php return '{$this->data['serverId']}';");
				}
			}
			
			
			http_response_code(204);
			die();
		}
	}
	
	
	public function handleClientVerification()
	{
		// 服务器验证客户端
		if($this->pathInfo == '/sessionserver/session/minecraft/hasJoined')
		{
			if(isset($_GET['username']) && isset($_GET['serverId']))
			{
				$uuid = mc_user::PlayerUUID($_GET['username']);
				$serveridPath = "{$this->rootDir}/data/serverid_{$uuid}.php";
				
				
				if(file_exists($serveridPath))
				{
					$serverid = include($serveridPath);
					$filemtime = filemtime($serveridPath);
					unlink($serveridPath);
					
					
					if($filemtime >= (time()-10))
					{
						if($serverid == $_GET['serverId'])
						{
							$userManager = new mc_user_manager();
							$user = $userManager->getUserByName($_GET['username']);
							
							
							if($user)
							{
								header('content-type: application/json');
								die($this->encodeRole($user));
							}
						}
					}
				}
			}
			
			
			http_response_code(204);
			die();
		}
	}
	
	
	public function fetchUserProfile()
	{
		// 查询角色
		if(preg_match('!^/sessionserver/session/minecraft/profile/([0-9a-zA-Z]+)$!',$this->pathInfo,$uuid))
		{
			$userManager = new mc_user_manager();
			$user = $userManager->getUserByUuid($uuid[1]);
			
			
			if($user)
			{
				if(isset($_GET['unsigned']) && $_GET['unsigned'] === 'false')
				{
					header('content-type: application/json');
					die($this->encodeRole($user));
				}
				else
				{
					header('content-type: application/json');
					die($this->encodeRole($user, false));
				}
			}
			else
			{
				http_response_code(204);
				die();
			}
		}
	}
	
	
	public function fetchTexture()
	{
		// 查询材质
		if(preg_match('!^/texture/([0-9a-zA-Z]+)$!', $this->pathInfo, $hash))
		{
			if($hash[1] == 'steve')
			{
				$output = 'iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAAdVBMVEUAAAD///+3g2sAzMyzeV4KvLyqclkAr68ApK';
				$output .= 'SbY0mUYD4ElZWPXj6QWT8FiIiBUzkAf38Denp2SzNVVVV3QjVSPYlqQDBKSkpGOqUAaGhBNZs/Pz86MYk3Nzc/KhV';
				$output .= 'JJRAoKCg0JRIzJBFCHQorHg0mGgokGAjoejraAAAAAXRSTlMAQObYZgAAAtFJREFUeNrtlm132jAMhelKFWuOHdr1';
				$output .= 'hYYkZcbz//+Ju5LjsXRwEujHcSNsOefc50gmEK+KYgyIEJtRq0sVw4AQwBN0DQBmudyTyl0OgDvgcz0g5iZcbuFyQ';
				$output .= 'AggxGFoXAO5+nKA7AFUN/m6GAB3BCM29QfU1MuN4kwyDhAIWASZgmZxye7HlEJAwC9XEhxikPvDot6jDLz+tib+qe';
				$output .= 'shBC0D1FmAVpxiZFqviYjVldvQRuYB+vhxorsX4pc7Suz0VkgKCku+/5AYInp9JWIoaf0pCSTOAlJMjuvmu6s/np8';
				$output .= 'PSJqaHW4KIC4BNA5+FuPh44Dv32HBTh7HX9DCX2UH9f1+X9b3xMDSfTeq3K+qyjARnQTs933/B8AO4pMAAvxsBbOA';
				$output .= 'BwDmKzjfgpEWPlfQtl273W47TG2L2UKVIWYyVc4NRlgrZJg2kCyOgO4I2ELWe1tVlgij5pDa1Q/A+/sG6REwGtsC8';
				$output .= 'I+P3sAiA3IlWAm1G6sALE4DEI9QMUluxIXPZtQ7JPMEIG0IoYPE5I0C/AiwAmFmJ5cKi2kFCLgVJGV7YxQwtqAFER';
				$output .= 'ETY4CboCkAKrOHrJSNbSi5LJkyQgGII6CdAiw8Xso2xkquACMAlTYyqaBTo2CQQdZbhNEiNEMCv2diBUBTwNtbN+p';
				$output .= 'NBZcyYLQiccPvCYBCmAD6HVw/xLqTdJe/DNTjYZMEHSHZZgBnAP8N6PudGHc9hBEA7Wnbep/3BSyMTPDmLVDE6qb/';
				$output .= 'Ug9ZlYEqJKubbvqk2ZetvJOIiCW/5sChAMdEX6jgoSLoKxUYx4taKOeFti0v3Q1UXu2ieUBxdgBB+jpXgo7LAJ0A2';
				$output .= 'iPAZjNiaQUFgKycB4rG/4OiI/DcecGJWC6Vm68AZkgrkJxhzUeDrMtagASgdqUwLd9ESABOASqdFjxE5UlABmnvap';
				$output .= '8BnDsvFL/YZwCnzwsK4ALgGcCJ8wLnTUCQTP/8Hn4DsAh5tPm8HxQAAAAASUVORK5CYII=';
				$output = base64_decode($output);
				
				header('Content-Type: image/png');
				die($output);
			}
			
			
			if($hash[1] == 'alex')
			{
				$output = 'iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAAZlBMVEUAAAD////v2r/r0LDvu7HfxKLUt4/zqFiUyJ';
				$output .= 'KMvorrmD+GuYTljT97snjegS5xq26UlmuAglpvb29lZWV8Vz51UDhYWFhyTjZPT09sRi5kQSwjYiQrVChcOyc/Pz8';
				$output .= '2NjYYOBYoKCgm8xoJAAAAAXRSTlMAQObYZgAAAwZJREFUeNrtlu1W6jAQRWtjWiaZtCC9/YgC8v4vec9Mg6Uur6b8';
				$output .= 've6S0Lo8O2NYmClusOMGF7Nr8HKu2IoDTYPk44K6lvBciePNAm7mlTGz3G2voAaYZg9vFzCCjtnZqoHjAYHDJjAM1';
				$output .= 'tqqgmR7Bahf9tFaA6zND6JwXRpxxosZIkz4uQzOWFmTrJPOUgdjOP1hzu7flmNrJe4wtCBoMgR1LVE1mNIYNbAurp';
				$output .= 'afN5N5Xto8vZbl65PhWg0aRiU/C2Rpa0x5w/LHnjQwZVTgGk755+eyNMbWXDeukQIwMjaRm6qyJjmMtTAi1ziHF0O';
				$output .= 'QQwsul+u1SJBnZsTbRJEgIqzxD8H1erksAt80MLTtCawFpvpScDqtKzhUYpA8yKgAv7Wq4GCripmT4PsKPFGIQxdj';
				$output .= 'bFsPCPiDsbY6tAvBU2K+KRZiCHHquimC0ylGCoH8vjSmVEG4xb0Mmb2MYmGYpgH5boBA7iAIPuxL5CUtT0Q72u0wy';
				$output .= '6SDioVOosh3k5ggQIZgQB4iDITlOqwoFiaJwzJAcMJARhOShUCX3AGjWMWYYqHv+zghHntwPPaoWQJh58mLRe5FUS';
				$output .= 'pQ6BenWDgi1B81rCAki0oIgiDvQRRlMkh+JdDgi2b78zieEUKEWglRG4gQp+8EEupTeOz78f39/U32n1oKb3iAQ64';
				$output .= '2CWQfPlWAUAr3MtoQ2jck4XmTe7wL7ykPrFkJRkm9HCUuopF8CN6TXsGTEAjvt2+7Gu4Fl/N5xN+PMs6XCwZJLv4B';
				$output .= 'ER480MzHFsyfwi9ZpDNSYH7IIKcDPKB4iHSwPk7tVo974ZDYZ1VQ/PKfg9Nsddg6ouWfyCMNh2OqzBbBCdxXUDMq2';
				$output .= 'Cq4r6CmDRVEoRvm4z4Q8OwowdmCbgDThEq8Jwg8pb4gSzANU5cY4l1ngCtDMM0NR4yYwfS5LzgoewXPXwuQ1bZDsI';
				$output .= 'JJ2OJHPvcL49wQJEyGQI+5pV/o9Sj8IKcCSd31C5sFEhrv+gVrzAbBul9QINiwB+t+QdHWLBmyPgXtF8CtX5CO4Ls';
				$output .= 'K/gL4WlU0/HKH/gAAAABJRU5ErkJggg==';
				$output = base64_decode($output);
				
				header('Content-Type: image/png');
				die($output);
			}
			
			
			if($hash[1] == 'cape')
			{
				$output = 'iVBORw0KGgoAAAANSUhEUgAAAEAAAAAgBAMAAABQs2O3AAAAIVBMVEUAAAB/j593iJptf5JneIpfb4BYZnVPXGpKVm';
				$output .= 'NGUV1CTFgLTatUAAAAAXRSTlMAQObYZgAAAKFJREFUeNrtzbENwjAQBVArigTpuExAvEG4BQL2ABSYmiaMYG+AU1J';
				$output .= 'y3sBMCRLQIOunoeQ3V9zT/+orjRCRQhE1F8mSMLiLXBFoniDNAYEgZwkYpBj2ACzzbfIQTCFcTgAsYvRuKL7Wr+PP';
				$output .= 'zm0RGN146Itg9QFH26MGZ5h3qMFYZjhRszWEJmrDG40aqpaIEFCkuzIY3rejVkNQdUTqn1/nAThNI5j05ZvKAAAAA';
				$output .= 'ElFTkSuQmCC';
				$output = base64_decode($output);
				
				header('Content-Type: image/png');
				die($output);
			}
			
			
			if(file_exists($texture = "{$this->texturesDir}{$hash[1]}.png"))
			{
				header('Content-Type: image/png');
				die(file_get_contents($texture));
			}
			
			if(file_exists($texture = "{$this->texturesTempDir}{$hash[1]}.png"))
			{
				header('Content-Type: image/png');
				die(file_get_contents($texture));
			}
			else
			{
				try
				{
					if($output = file_get_contents("https://mcskin.com.cn/textures/{$hash[1]}"))
					{
						file_put_contents($texture, $output);
						header('Content-Type: image/png');
						die($output);
					}
				}
				catch(error $error)
				{
					http_response_code(404);
					die();
				}
			}
		}
	}
	
	
	public function fetchAvatar()
	{
		// 查询头像
		if(preg_match('!^/avatar/([0-9a-zA-Z]+)/([0-9]+)$!',$this->pathInfo,$hash))
		{
			if($hash[2] >= 10 && $hash[2] <= 512)
			{
				$size = $hash[2];
			}
			else
			{
				$size = 48;
			}
			
			if($hash[1] == 'steve')
			{
				$output = 'iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAMAAACdt4HsAAAAdVBMVEUAAAD///+3g2sAzMyzeV4KvLyqclkAr68ApK';
				$output .= 'SbY0mUYD4ElZWPXj6QWT8FiIiBUzkAf38Denp2SzNVVVV3QjVSPYlqQDBKSkpGOqUAaGhBNZs/Pz86MYk3Nzc/KhV';
				$output .= 'JJRAoKCg0JRIzJBFCHQorHg0mGgokGAjoejraAAAAAXRSTlMAQObYZgAAAtFJREFUeNrtlm132jAMhelKFWuOHdr1';
				$output .= 'hYYkZcbz//+Ju5LjsXRwEujHcSNsOefc50gmEK+KYgyIEJtRq0sVw4AQwBN0DQBmudyTyl0OgDvgcz0g5iZcbuFyQ';
				$output .= 'AggxGFoXAO5+nKA7AFUN/m6GAB3BCM29QfU1MuN4kwyDhAIWASZgmZxye7HlEJAwC9XEhxikPvDot6jDLz+tib+qe';
				$output .= 'shBC0D1FmAVpxiZFqviYjVldvQRuYB+vhxorsX4pc7Suz0VkgKCku+/5AYInp9JWIoaf0pCSTOAlJMjuvmu6s/np8';
				$output .= 'PSJqaHW4KIC4BNA5+FuPh44Dv32HBTh7HX9DCX2UH9f1+X9b3xMDSfTeq3K+qyjARnQTs933/B8AO4pMAAvxsBbOA';
				$output .= 'BwDmKzjfgpEWPlfQtl273W47TG2L2UKVIWYyVc4NRlgrZJg2kCyOgO4I2ELWe1tVlgij5pDa1Q/A+/sG6REwGtsC8';
				$output .= 'I+P3sAiA3IlWAm1G6sALE4DEI9QMUluxIXPZtQ7JPMEIG0IoYPE5I0C/AiwAmFmJ5cKi2kFCLgVJGV7YxQwtqAFER';
				$output .= 'ETY4CboCkAKrOHrJSNbSi5LJkyQgGII6CdAiw8Xso2xkquACMAlTYyqaBTo2CQQdZbhNEiNEMCv2diBUBTwNtbN+p';
				$output .= 'NBZcyYLQiccPvCYBCmAD6HVw/xLqTdJe/DNTjYZMEHSHZZgBnAP8N6PudGHc9hBEA7Wnbep/3BSyMTPDmLVDE6qb/';
				$output .= 'Ug9ZlYEqJKubbvqk2ZetvJOIiCW/5sChAMdEX6jgoSLoKxUYx4taKOeFti0v3Q1UXu2ieUBxdgBB+jpXgo7LAJ0A2';
				$output .= 'iPAZjNiaQUFgKycB4rG/4OiI/DcecGJWC6Vm68AZkgrkJxhzUeDrMtagASgdqUwLd9ESABOASqdFjxE5UlABmnvap';
				$output .= '8BnDsvFL/YZwCnzwsK4ALgGcCJ8wLnTUCQTP/8Hn4DsAh5tPm8HxQAAAAASUVORK5CYII=';
				$output = base64_decode($output);
			}
			else
			{
				if(file_exists($texture = "{$this->texturesTempDir}{$hash[1]}.png"))
				{
					$output = file_get_contents($texture);
				}
				else
				{
					try
					{
						if($output = file_get_contents("https://mcskin.com.cn/textures/{$hash[1]}"))
						{
							file_put_contents($texture, $output);
						}
					}
					catch(error $error)
					{
						http_response_code(404);
						die();
					}
				}
			}
			
			$ss = getimagesizefromstring($output);
			$im = imagecreatefromstring($output);
			$av = imagecreatetruecolor($size, $size);

			imagecolortransparent($im, imagecolorat($im, $ss[0]-1, 0));
			imagefill($av, 0 ,0 ,imagecolorallocatealpha($av, 0, 0, 0, 127));
			imagesavealpha($av, true);
			imagecopyresized($av, $im, intval($size/16), intval($size/16), intval($ss[0]/8.0), intval($ss[0]/8), intval($size-$size/8), intval($size-$size/8), intval($ss[0]/8), intval($ss[0]/8));
			imagecopyresized($av, $im, 0, 0, intval($ss[0]/1.6), intval($ss[0]/8), intval($size), intval($size), intval($ss[0]/8), intval($ss[0]/8));
			
			header('Content-type: image/png');
			imagepng($av);
			imagedestroy($av);
			imagedestroy($im);
			die();
		}
	}
	
	
	public function handleAuthenticationRequest()
	{
		$this->handleClientJoin();
		$this->handleClientVerification();
		$this->fetchUserProfile();
		$this->fetchTexture();
		$this->fetchAvatar();
		
		
		$response = [
			'meta' => [
				'serverName' => $this->serverName,
				'implementationName' => $this->implementationName,
				'implementationVersion' => $this->implementationVersion
			],
			'skinDomains' => $this->skinDomains,
			'signaturePublickey' => $this->publicKey
		];
		
		header('content-type: application/json');
		die(json_encode($response));
	}
}