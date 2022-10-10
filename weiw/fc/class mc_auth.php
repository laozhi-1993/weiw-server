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
		$this->data    = json_decode(file_get_contents('php://input'),true);
		$this->userdir = __MKHDIR__;
		
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
		$config = config('config.php');
		$textures = Array();
		$textures['timestamp']   = time().'000';
		$textures['profileId']   = $user['id'];
		$textures['profileName'] = $user['name'];
		
		
		if(isset($user['CAPE']['hash'])) $textures['textures']['CAPE']['url'] = "{$config['Yggdrasil']}/texture/{$user['CAPE']['hash']}";
		if(isset($user['SKIN']['hash'])) $textures['textures']['SKIN']['url'] = "{$config['Yggdrasil']}/texture/{$user['SKIN']['hash']}";
		if(isset($user['SKIN']['hash'])) $textures['textures']['SKIN']['metadata']['model'] = 'default';
		
		
			$Arr = Array();
			$Arr['id']   = $user['id'];
			$Arr['name'] = $user['name'];
			$Arr['properties'][0]['name']  = 'textures';
			$Arr['properties'][0]['value'] = base64_encode(json_encode($textures));
			$Arr['properties'][1]['name']  = 'uploadableTextures';
			$Arr['properties'][1]['value'] = $uploadableTextures;
		
		
		if($unsigned)
		{
			$rsa_prikey = config('rsa_private.php');
			openssl_sign($Arr['properties'][0]['value'],$textures,$rsa_prikey);
			openssl_sign($Arr['properties'][0]['value'],$uploadableTextures,$rsa_prikey);
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
					file_put_contents("{$this->userdir}/user/serverid_{$this->data['selectedProfile']}.php","<?php return '{$this->data['serverId']}';");
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
				$id   = "{$this->userdir}/user/serverid_{$uuid}.php";
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
				if(file_exists($texture = "{$this->userdir}/user_textures/{$hash[1]}.png"))
				{
					header('Content-Type: image/png');
					die(file_get_contents($texture));
				}
				else
				{
					try
					{
						if($data = file_get_contents("https://littleskin.cn/textures/{$hash[1]}"))
						{
							file_put_contents($texture,$data);
							header('Content-Type: image/png');
							die($data);
						}
						
						http_response_code(404);
						die();
					}
					catch(error $error)
					{
						http_response_code(404);
						die();
					}
				}
			}
			else
			{
				http_response_code(404);
				die();
			}
		}
		
		
		$response = Array();
		$response['meta']['serverName']              = $this->serverName;
		$response['meta']['implementationName']      = $this->implementationName;
		$response['meta']['implementationVersion']   = $this->implementationVersion;
		$response['meta']['links']['homepage']       = $this->homepage;
		$response['meta']['links']['register']       = $this->register;
		$response['meta']['feature.non_email_login'] = false;
		
		$response['skinDomains']        = $this->skinDomains;
		$response['signaturePublickey'] = config('rsa_public.php');
		
		
		header('content-type: application/json');
		die(json_encode($response));
	}
}