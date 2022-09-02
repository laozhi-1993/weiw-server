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
		$this->implementationVersion = '1.0.0';
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
		$textures = Array();
		$textures['timestamp']   = time().'000';
		$textures['profileId']   = $user['id'];
		$textures['profileName'] = $user['name'];
		
		
		if(isset($user['CAPE']['url'])) $textures['textures']['CAPE']['url'] = $user['CAPE']['url'];
		if(isset($user['SKIN']['url'])) $textures['textures']['SKIN']['url'] = $user['SKIN']['url'];
		if(isset($user['SKIN']['url'])) $textures['textures']['SKIN']['metadata']['model'] = 'default';
		
		
			$Arr = Array();
			$Arr['id']   = $user['id'];
			$Arr['name'] = $user['name'];
			$Arr['properties'][0]['name']  = 'textures';
			$Arr['properties'][0]['value'] = base64_encode(json_encode($textures));
			$Arr['properties'][1]['name']  = 'uploadableTextures';
			$Arr['properties'][1]['value'] = $uploadableTextures;
		
		
		if($unsigned)
		{
			$rsa_prikey = include(__MKHDIR__.'/rsa_private.php');
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
		//登录账号分配令牌
		if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == '/authserver/authenticate')
		{
			if(isset($this->data['username']))
			{
				$token = mc::data_token(self::constructOfflinePlayerUuid($this->data['username']));
			}
			
			if(isset($token['uuid'][0]))
			{
				$user  = mc::data_user($token['uuid'][0]);
			}
			
			
			if(isset($token) && isset($user) && $token && $user)
			{
				if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				{
					$ip = explode(', ',$_SERVER['HTTP_X_FORWARDED_FOR']);
					$user['login_time'] = time();
					$user['login_ip']   = end($ip);
				}
				else
				{
					$user['login_time'] = time();
					$user['login_ip']   = $_SERVER['REMOTE_ADDR'];
				}
				
				if($user['blacklist'])
				{
					http_response_code(403);
					die('{"error":"ForbiddenOperationException","errorMessage":"禁止登录"}');
				}
				
				if($token['password'] == $this->data['password'])
				{
					if(isset($this->data['clientToken']))
					{
						mc::data_user($token['uuid'][0],$user);
						die($this->token($user,$this->data['clientToken'],$this->data['requestUser']));
					}
					else
					{
						mc::data_user($token['uuid'][0],$user);
						die($this->token($user));
					}
				}
				else
				{
					http_response_code(403);
					die('{"error":"ForbiddenOperationException","errorMessage":"密码错误"}');
				}
			}
			else
			{
				http_response_code(403);
				die('{"error":"ForbiddenOperationException","errorMessage":"账号不存在"}');
			}
		}
		
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
		
		//验证令牌
		if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == '/authserver/validate')
		{
			if(isset($this->data['accessToken']))
			{
				$uuid  = explode('_',$this->data['accessToken']);
				$token = mc::data_token($uuid[0]);
				if($token)
				{
					if(isset($token['accessToken']) && isset($token['clientToken']) && isset($this->data['accessToken']) && isset($this->data['clientToken']))
					{
						if($token['accessToken'] == $this->data['accessToken'] && $token['clientToken'] == $this->data['clientToken'])
						{
							http_response_code(204);
							die();
						}
					}
				}
			}
			
			
			http_response_code(403);
			die('{"error":"ForbiddenOperationException","errorMessage":"Invalid token."}');
		}
		
		//刷新令牌
		if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == '/authserver/refresh')
		{
			if(isset($this->data['accessToken']))
			{
				$uuid  = explode('_',$this->data['accessToken']);
				$token = mc::data_token($uuid[0]);
				$user  = mc::data_user ($token['uuid'][0]);
				if($user && $token)
				{
					if(isset($token['accessToken']) && isset($token['clientToken']) && isset($this->data['accessToken']) && isset($this->data['clientToken']))
					{
						if($token['accessToken'] == $this->data['accessToken'] && $token['clientToken'] == $this->data['clientToken'])
						{
							if(isset($this->data['clientToken']))
							{
								die($this->token($user,$this->data['clientToken']));
							}
							else
							{
								die($this->token($user));
							}
						}
					}
				}
			}
			
			
			http_response_code(403);
			die('{"error":"ForbiddenOperationException","errorMessage":"Invalid token."}');
		}
		
		//登出
		if(isset($_SERVER['PATH_INFO']) && $_SERVER['PATH_INFO'] == '/authserver/signout')
		{
			if(isset($this->data['username']) && isset($this->data['password']))
			{
				$uuid  = self::constructOfflinePlayerUuid($this->data['username']);
				$token = mc::data_token($uuid);
				if($token)
				{
					if(isset($token['password']) && isset($this->data['password']))
					{
						if($token['password'] == $this->data['password'])
						{
							unset($token['accessToken']);
							unset($token['clientToken']);
							mc::data_token($uuid,$token);
						}
					}
				}
			}
			
			http_response_code(204);
			die();
		}
		
		//查询角色属性
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
			if(isset($hash[1]) && file_exists("{$this->userdir}/user_textures/{$hash[1]}.png"))
			{
				header('Content-Type: image/png');
				die(file_get_contents("{$this->userdir}/user_textures/{$hash[1]}.png"));
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
		$response['signaturePublickey'] = include("{$this->userdir}/rsa_public.php");
		
		
		header('content-type: application/json');
		die(json_encode($response));
	}
}