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
	private $authUrl;
	private $publicKey;
	private $privateKey;
    public function __construct()
	{
		$config = config::loadConfig('config');
		$rsa    = config::loadConfig('rsa');
		
		if(isset($_SERVER['PATH_INFO']))
		{
			$this->pathInfo = $_SERVER['PATH_INFO'];
		}
		else
		{
			$this->pathInfo = Null;
		}
		
		if ($config['authUrl'])
		{
			$this->authUrl = $config['authUrl'];
		}
		else
		{
			$this->authUrl = $this->resolveAuthUrl();
		}
		
		$this->data                  = json_decode(file_get_contents('php://input'), true);
		$this->rootDir               = __MKHDIR__;
		$this->texturesDir           = __MKHDIR__.'/user_textures/';
		$this->texturesTempDir       = __MKHDIR__.'/data/textures/';
		$this->implementationName    = 'weiw auth server';
		$this->implementationVersion = '1.1.2';
		$this->publicKey             = $rsa['public'];
		$this->privateKey            = $rsa['private'];
		
		$this->serverName = $config['serverName'];
		$this->skinDomains[] = parse_url($this->authUrl, PHP_URL_HOST);
		
		
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
			$textures['textures']['CAPE']['url'] = "{$this->authUrl}/texture/{$user->CAPE['hash']}";
		}
		
		
		if(strlen($user->SKIN['hash']) == 64)
		{
			$textures['textures']['SKIN']['url'] = "{$this->authUrl}/texture/{$user->SKIN['hash']}";
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
				$output = 'iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAFDUlEQVR42u2a20sUURzH97G0LKMotPuWbVpslj1olJ';
				$output .= 'XdjCgyisowsSjzgrB0gSKyC5UF1ZNQWEEQSBQ9dHsIe+zJ/+nXfM/sb/rN4ZwZ96LOrnPgyxzP/M7Z+X7OZc96JpE';
				$output .= 'ISfWrFhK0YcU8knlozeJKunE4HahEqSc2nF6zSEkCgGCyb+82enyqybtCZQWAzdfVVFgBJJNJn1BWFgC49/VpwGVl';
				$output .= 'D0CaxQiA5HSYEwBM5sMAdKTqygcAG9+8coHKY/XXAZhUNgDYuBSPjJL/GkzVVhAEU5tqK5XZ7cnFtHWtq/TahdSw2';
				$output .= 'l0HUisr1UKIWJQBAMehDuqiDdzndsP2EZECAG1ZXaWMwOCODdXqysLf++uXUGv9MhUHIByDOijjdiSAoH3ErANQD7';
				$output .= '3C7TXXuGOsFj1d4YH4OTJAEy8y9Hd0mCaeZ5z8dfp88zw1bVyiYhCLOg1ZeAqC0ybaDttHRGME1DhDeVWV26u17lR';
				$output .= 'APr2+mj7dvULfHw2q65fhQRrLXKDfIxkau3ZMCTGIRR3URR5toU38HbaPiMwUcKfBAkoun09PzrbQ2KWD1JJaqswj';
				$output .= 'deweoR93rirzyCMBCmIQizqoizZkm2H7iOgAcHrMHbbV9KijkUYv7qOn55sdc4fo250e+vUg4329/Xk6QB/6DtOws';
				$output .= '+dHDGJRB3XRBve+XARt+4hIrAF4UAzbnrY0ve07QW8uHfB+0LzqanMM7qVb+3f69LJrD90/1axiEIs6qIs21BTITo';
				$output .= 'ewfcSsA+Bfb2x67OoR1aPPzu2i60fSNHRwCw221Suz0O3jO+jh6V1KyCMGse9721XdN5ePutdsewxS30cwuMjtC86';
				$output .= '0T5JUKpXyKbSByUn7psi5l+juDlZYGh9324GcPKbkycaN3jUSAGxb46IAYPNZzW0AzgiQ5tVnzLUpUDCAbakMQXXr';
				$output .= 'OtX1UMtHn+Q9/X5L4wgl7t37r85OSrx+TYl379SCia9KXjxRpiTjIZTBFOvrV1f8ty2eY/T7XJ81FQAwmA8ASH1ob';
				$output .= '68r5PnBsxA88/xAMh6SpqW4HRnLBrkOA9Xv5wPAZjAUgOkB+SHxgBgR0qSMh0zmZRsmwDJm1gFg2PMDIC8/nAHIMl';
				$output .= 's8x8GgzOsG5WiaqREgYzDvpTwjLDy8NM15LpexDEA3LepjU8Z64my+8PtDCmUyRr+fFwA2J0eAFYA0AxgSgMmYBMZ';
				$output .= 'TwFQnO9RNAEaHOj2DXF5UADmvAToA2ftyxZYA5BqgmZZApDkdAK4mAKo8GzPlr8G8AehzMAyA/i1girUA0HtYB2Ca';
				$output .= 'IkUBEHQ/cBHSvwF0AKZFS5M0ZwMQtEaEAmhtbSUoDADH9ff3++QZ4o0I957e+zYAMt6wHkhzpjkuAcgpwNcpA7AZD';
				$output .= 'LsvpwiuOkBvxygA6Bsvb0HlaeKIF2EbADZpGiGzBsA0gnwQHGOhW2snRpbpPexbAB2Z1oicAMQpTnGKU5ziFKc4xS';
				$output .= 'lOcYpTnOIUpzgVmgo+XC324WfJAdDO/+ceADkCpuMFiFKbApEHkOv7BfzfXt+5gpT8V7rpfYJcDz+jAsB233r6yyB';
				$output .= 'sJ0mlBCDofuBJkel4vOwBFPv8fyYAFPJ+wbSf/88UANNRVy4Awo6+Ig2gkCmgA5DHWjoA+X7AlM//owLANkX0w035';
				$output .= '9od++pvX8fdMAcj3/QJ9iJsAFPQCxHSnQt8vMJ3v2wCYpkhkAOR7vG7q4aCXoMoSgG8hFAuc/grMdAD4B/kHl9da7';
				$output .= 'Ne9AAAAAElFTkSuQmCC';
				$output = base64_decode($output);
				
				header('Content-Type: image/png');
				die($output);
			}
			else
			{
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
				$output = 'iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAFDUlEQVR42u2a20sUURzH97G0LKMotPuWbVpslj1olJ';
				$output .= 'XdjCgyisowsSjzgrB0gSKyC5UF1ZNQWEEQSBQ9dHsIe+zJ/+nXfM/sb/rN4ZwZ96LOrnPgyxzP/M7Z+X7OZc96JpE';
				$output .= 'ISfWrFhK0YcU8knlozeJKunE4HahEqSc2nF6zSEkCgGCyb+82enyqybtCZQWAzdfVVFgBJJNJn1BWFgC49/VpwGVl';
				$output .= 'D0CaxQiA5HSYEwBM5sMAdKTqygcAG9+8coHKY/XXAZhUNgDYuBSPjJL/GkzVVhAEU5tqK5XZ7cnFtHWtq/TahdSw2';
				$output .= 'l0HUisr1UKIWJQBAMehDuqiDdzndsP2EZECAG1ZXaWMwOCODdXqysLf++uXUGv9MhUHIByDOijjdiSAoH3ErANQD7';
				$output .= '3C7TXXuGOsFj1d4YH4OTJAEy8y9Hd0mCaeZ5z8dfp88zw1bVyiYhCLOg1ZeAqC0ybaDttHRGME1DhDeVWV26u17lR';
				$output .= 'APr2+mj7dvULfHw2q65fhQRrLXKDfIxkau3ZMCTGIRR3URR5toU38HbaPiMwUcKfBAkoun09PzrbQ2KWD1JJaqswj';
				$output .= 'deweoR93rirzyCMBCmIQizqoizZkm2H7iOgAcHrMHbbV9KijkUYv7qOn55sdc4fo250e+vUg4329/Xk6QB/6DtOws';
				$output .= '+dHDGJRB3XRBve+XARt+4hIrAF4UAzbnrY0ve07QW8uHfB+0LzqanMM7qVb+3f69LJrD90/1axiEIs6qIs21BTITo';
				$output .= 'ewfcSsA+Bfb2x67OoR1aPPzu2i60fSNHRwCw221Suz0O3jO+jh6V1KyCMGse9721XdN5ePutdsewxS30cwuMjtC86';
				$output .= '0T5JUKpXyKbSByUn7psi5l+juDlZYGh9324GcPKbkycaN3jUSAGxb46IAYPNZzW0AzgiQ5tVnzLUpUDCAbakMQXXr';
				$output .= 'OtX1UMtHn+Q9/X5L4wgl7t37r85OSrx+TYl379SCia9KXjxRpiTjIZTBFOvrV1f8ty2eY/T7XJ81FQAwmA8ASH1ob';
				$output .= '68r5PnBsxA88/xAMh6SpqW4HRnLBrkOA9Xv5wPAZjAUgOkB+SHxgBgR0qSMh0zmZRsmwDJm1gFg2PMDIC8/nAHIMl';
				$output .= 's8x8GgzOsG5WiaqREgYzDvpTwjLDy8NM15LpexDEA3LepjU8Z64my+8PtDCmUyRr+fFwA2J0eAFYA0AxgSgMmYBMZ';
				$output .= 'TwFQnO9RNAEaHOj2DXF5UADmvAToA2ftyxZYA5BqgmZZApDkdAK4mAKo8GzPlr8G8AehzMAyA/i1girUA0HtYB2Ca';
				$output .= 'IkUBEHQ/cBHSvwF0AKZFS5M0ZwMQtEaEAmhtbSUoDADH9ff3++QZ4o0I957e+zYAMt6wHkhzpjkuAcgpwNcpA7AZD';
				$output .= 'LsvpwiuOkBvxygA6Bsvb0HlaeKIF2EbADZpGiGzBsA0gnwQHGOhW2snRpbpPexbAB2Z1oicAMQpTnGKU5ziFKc4xS';
				$output .= 'lOcYpTnOIUpzgVmgo+XC324WfJAdDO/+ceADkCpuMFiFKbApEHkOv7BfzfXt+5gpT8V7rpfYJcDz+jAsB233r6yyB';
				$output .= 'sJ0mlBCDofuBJkel4vOwBFPv8fyYAFPJ+wbSf/88UANNRVy4Awo6+Ig2gkCmgA5DHWjoA+X7AlM//owLANkX0w035';
				$output .= '9od++pvX8fdMAcj3/QJ9iJsAFPQCxHSnQt8vMJ3v2wCYpkhkAOR7vG7q4aCXoMoSgG8hFAuc/grMdAD4B/kHl9da7';
				$output .= 'Ne9AAAAAElFTkSuQmCC';
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