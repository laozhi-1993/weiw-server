<?php class mc_auth
{
    public $data;
	public $userdir;
	public $implementationName;
	public $implementationVersion;
	public $skinDomains;
	public $serverName;
	public $homepage;
	public $register;
	public $uploadableTextures;
    public function __construct()
	{
		$this->data                  = json_decode(file_get_contents('php://input'),true);
		$this->userdir               = __MKHDIR__;
		$this->skinDomains           = Array();
		$this->implementationName    = 'weiw auth server';
		$this->implementationVersion = '1.1.0';
		$this->uploadableTextures    = '';
    }


    static function constructOfflinePlayerUuid($username)
	{
        $data = hex2bin(md5("OfflinePlayer:" . strtolower($username)));
        $data[6] = chr(ord($data[6]) & 0x0f | 0x30);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return bin2hex($data);
    }
	
	
	static function random()
	{
		return md5(time().str_shuffle('QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890'));
	}
	
	
	static function user($user) //用户信息序列化
	{
		$Arr = Array();
		$Arr['id'] = $user['id'];
		$Arr['properties'] = Array();
		
		return $Arr;
	}
	
	
	static function Profile($user,$unsigned,$uploadableTextures) //角色信息的序列化
	{
		$config = config::ini('config');
		$textures = Array();
		$textures['timestamp']   = time().'000';
		$textures['profileId']   = $user['id'];
		$textures['profileName'] = $user['name'];
		
		
		if(isset($user['CAPE']['hash']))  $textures['textures']['CAPE']['url'] = "{$config['Yggdrasil']}/texture/{$user['CAPE']['hash']}";
		if(isset($user['SKIN']['hash']))  $textures['textures']['SKIN']['url'] = "{$config['Yggdrasil']}/texture/{$user['SKIN']['hash']}";
		if(isset($user['SKIN']['model'])) $textures['textures']['SKIN']['metadata']['model'] = $user['SKIN']['model'];
		
		
			$Arr = Array();
			$Arr['id']   = $user['id'];
			$Arr['name'] = $user['name'];
			$Arr['properties'][0]['name']  = 'textures';
			$Arr['properties'][0]['value'] = base64_encode(json_encode($textures));
			$Arr['properties'][1]['name']  = 'uploadableTextures';
			$Arr['properties'][1]['value'] = $uploadableTextures;
		
		
		if($unsigned)
		{
			$config = config::ini('rsa');
			openssl_sign($Arr['properties'][0]['value'],$textures,$config['private']);
			openssl_sign($Arr['properties'][0]['value'],$uploadableTextures,$config['private']);
			$Arr['properties'][0]['signature'] = base64_encode($textures);
			$Arr['properties'][1]['signature'] = base64_encode($uploadableTextures);
		}
		
		
		return $Arr;
	}
	

	public function token($user,$clientToken=false,$requestUser=false)
	{
		if($clientToken && preg_match('!^[a-z0-9]+$!',$clientToken))
		{
			$token = Array();
			$token['accessToken'] = self::constructOfflinePlayerUuid($user['email']).'_'.self::random();
			$token['clientToken'] = $clientToken;
			$token['selectedProfile']     = self::Profile($user,false,$this->uploadableTextures);
			$token['availableProfiles'][] = self::Profile($user,false,$this->uploadableTextures);
		}
		else
		{
			$token = Array();
			$token['accessToken'] = self::constructOfflinePlayerUuid($user['email']).'_'.self::random();
			$token['clientToken'] = self::random();
			$token['selectedProfile']     = self::Profile($user,false,$this->uploadableTextures);
			$token['availableProfiles'][] = self::Profile($user,false,$this->uploadableTextures);
		}
		
		if($requestUser)
		{
			$token['user'] = self::user($user);
		}
		
		$email = self::constructOfflinePlayerUuid($user['email']);
		$Arr   = mc::data_token($email);
		$Arr['accessToken'] = $token['accessToken'];
		$Arr['clientToken'] = $token['clientToken'];
		
		mc::data_token($email,$Arr);
		return json_encode($token);
	}
	
	
	public function __destruct()
	{
		//客户端进入服务器
		if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == '/sessionserver/session/minecraft/join')
		{
			if(isset($this->data['selectedProfile']))
			{
				$user  = mc::data_user($this->data['selectedProfile']);
			}
			
			if(isset($user['email']))
			{
				$token = mc::data_token(self::constructOfflinePlayerUuid($user['email']));
			}
			
			
			if(isset($user) && isset($token) && $user && $token)
			{
				if(preg_match('!^-?[A-Za-z0-9]+$!',$this->data['serverId']) && $token['accessToken'] == $this->data['accessToken'])
				{
					file_put_contents("{$this->userdir}/data/serverid_{$this->data['selectedProfile']}.php","<?php return '{$this->data['serverId']}';");
				}
			}
			
			
			http_response_code(204);
			die();
		}
		
		//服务端验证客户端
		if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == '/sessionserver/session/minecraft/hasJoined')
		{
			if(isset($_GET['username']))
			{
				$uuid = self::constructOfflinePlayerUuid($_GET['username']);
				$id   = "{$this->userdir}/data/serverid_{$uuid}.php";
				if(file_exists($id))
				{
					if(filemtime($id) >= (time()-10))
					{
						$serverid = include($id);
						if($serverid == $_GET['serverId'])
						{
							if($user = mc::data_user($uuid))
							{
								unlink($id);
								header('content-type: application/json');
								die(json_encode(self::Profile($user,true,$this->uploadableTextures)));
							}
						}
					}
					
					unlink($id);
				}
			}
			
			
			http_response_code(204);
			die();
		}
		
		//查询角色
		if(isset($_SERVER['PATH_INFO']) && preg_match('!^/sessionserver/session/minecraft/profile/([0-9a-zA-Z]+)$!',$_SERVER['PATH_INFO'],$uuid))
		{
			if(isset($uuid[1]) && $user = mc::data_user($uuid[1]))
			{
				if(isset($_GET['unsigned']) && $_GET['unsigned'] === 'false')
				{
					header('content-type: application/json');
					die(json_encode(self::Profile($user,true ,$this->uploadableTextures)));
				}
				else
				{
					header('content-type: application/json');
					die(json_encode(self::Profile($user,false,$this->uploadableTextures)));
				}
			}
			else
			{
				http_response_code(204);
				die();
			}
		}
		
		//查询材质
		if(isset($_SERVER['PATH_INFO']) && preg_match('!^/texture/([0-9a-zA-Z]+)$!',$_SERVER['PATH_INFO'],$hash))
		{
			if(isset($hash[1]))
			{
				$config = config::ini('config');
				$dir = str_ireplace('{dir}',$this->userdir,$config['textures_dir']);
				
				if(!is_dir($dir))
				{
					$dir = "{$this->userdir}/user_textures";
				}
				
				
				if(file_exists($texture = "{$dir}/{$hash[1]}.png"))
				{
					header('Content-Type: image/png');
					die(file_get_contents($texture));
				}
				else
				{
					try
					{
						if($data = file_get_contents("https://mcskin.cn/textures/{$hash[1]}"))
						{
							file_put_contents($texture,$data);
							header('Content-Type: image/png');
							die($data);
						}
					}
					catch(error $error){}
				}
			}
			
			
			http_response_code(404);
			die();
		}
		
		
		//查询头像
		if(isset($_SERVER['PATH_INFO']) && preg_match('!^/avatar(\?.*)?$!',$_SERVER['PATH_INFO']))
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
			
			
			if(isset($_GET['size']) && $_GET['size'] >= 1 && $_GET['size'] <= 512)
			{
				$size = $_GET['size'];	
			}
			else
			{
				$size = 48;
			}
			
			if(isset($_GET['hash']))
			{
				$config = config::ini('config');
				$dir = str_ireplace('{dir}',$this->userdir,$config['textures_dir']);
				
				if(!is_dir($dir))
				{
					$dir = "{$this->userdir}/user_textures";
				}
				
				
				if(file_exists($texture = "{$dir}/{$_GET['hash']}.png"))
				{
					$output = file_get_contents($texture);
				}
				else
				{
					try
					{
						if($output = file_get_contents("https://mcskin.cn/textures/{$_GET['hash']}"))
						{
							file_put_contents($texture,$output);
						}
					}
					catch(error $error){}
				}
			}

			$ss = getimagesizefromstring($output);
			$im = imagecreatefromstring($output);
			$av = imagecreatetruecolor($size, $size);

			imagecolortransparent($im, imagecolorat($im, $ss[0]-1, 0));
			imagefill($av, 0 ,0 ,imagecolorallocatealpha($av, 0, 0, 0, 127));
			imagesavealpha($av, true);
			imagecopyresized($av, $im, ($size/16), ($size/16), ($ss[0]/8.0), ($ss[0]/8), ($size-$size/8), ($size-$size/8), ($ss[0]/8), ($ss[0]/8));
			imagecopyresized($av, $im, (0)       , (0)       , ($ss[0]/1.6), ($ss[0]/8), ($size)        , ($size)        , ($ss[0]/8), ($ss[0]/8));

			header('Content-type: image/png');
			imagepng($av);
			imagedestroy($av);
			imagedestroy($im);
			die();
		}
		
		
		$config   = config::ini('rsa');
		$response = Array();
		$response['meta']['serverName']              = $this->serverName;
		$response['meta']['implementationName']      = $this->implementationName;
		$response['meta']['implementationVersion']   = $this->implementationVersion;
		$response['meta']['links']['homepage']       = $this->homepage;
		$response['meta']['links']['register']       = $this->register;
		$response['meta']['feature.non_email_login'] = false;
		
		$response['skinDomains']        = $this->skinDomains;
		$response['signaturePublickey'] = $config['public'];
		
		
		header('content-type: application/json');
		die(json_encode($response));
	}
}