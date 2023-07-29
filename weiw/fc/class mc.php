<?php class mc
{
	static function data_user($uuid,$Arr=false)
	{
		$config = config::ini('config');
		$dir = str_ireplace('{dir}',__MKHDIR__,$config['user_dir']);
		
		if(!is_dir($dir))
		{
			$dir = __MKHDIR__.'/user';
		}
		
		if(is_array($Arr))
		{
			$STR = json_encode($Arr);
			return file_put_contents("{$dir}/user_{$uuid}.php","<?php die ?>{$STR}");
		}
		else
		{
			if(file_exists("{$dir}/user_{$uuid}.php"))
			{
				return json_decode(substr_replace(file_get_contents("{$dir}/user_{$uuid}.php"),'',0,12),true);
			}
			else return false;
		}
	}
	
	
	static function data_token($uuid,$Arr=false)
	{
		$config = config::ini('config');
		$dir = str_ireplace('{dir}',__MKHDIR__,$config['user_dir']);
		
		if(!is_dir($dir))
		{
			$dir = __MKHDIR__.'/user';
		}
		
		if(is_array($Arr))
		{
			$STR = json_encode($Arr);
			return file_put_contents("{$dir}/token_{$uuid}.php","<?php die ?>{$STR}");
		}
		else
		{
			if(file_exists("{$dir}/token_{$uuid}.php"))
			{
				return json_decode(substr_replace(file_get_contents("{$dir}/token_{$uuid}.php"),'',0,12),true);
			}
			else return false;
		}
	}
	
	
	static function admin($code = true)
	{
		try
		{
			$config = config::ini('admin');
			$user   = self::user();
			$admin  = explode(' ',$config['email']);
			if(isset($user['email']) && isset($admin) && in_array($user['email'],$admin))
			{
				return true;
			}
			else
			{
				if($code)
				{
					http_response_code(403);
					die;
				}
				else
				{
					return false;
				}
			}
		}
		catch(Exception $Exception)
		{
			if($code)
			{
				http_response_code(403);
				die;
			}
			else
			{
				return false;
			}
		}
	}
	
	
    static function user()
	{
		if(isset($_COOKIE['login_token']))
		{
			$login = explode('_',$_COOKIE['login_token']);
			
			if(isset($login[0]))
			{
				$token = self::data_token($login[0]);
			}
			
			if(isset($token['uuid'][0]))
			{
				$user = self::data_user ($token['uuid'][0]);
				$user['token'] = $token['accessToken'];
			}
			
			
			if(isset($token) && isset($user) && $token && $user)
			{
				if(isset($token['login_token']) && $token['login_token'] == $_COOKIE['login_token'])
				{
					return $user;
				}
			}
		}
		
		throw new Exception('请登录');
    }
	
	
    static function user_exit()
	{
		setcookie('login_token','',0,'/');
		throw new Exception('退出完成');
    }
	
	
	static function money($uuid,$money) //设置金钱
	{
		if($user = self::data_user($uuid))
		{
			$user['bi'] = $money;
			self::data_user($uuid,$user);
		}
		else throw new Exception('用户不存在');
	}
	
	
	static function cape($uuid,$hash) //设置披风
	{
		if($user = self::data_user($uuid))
		{
			$user['CAPE']['hash'] = $hash;
			self::data_user($uuid,$user);
		}
		else throw new Exception('用户不存在');
	}
	
	
	static function skin($uuid,$hash,$model=false) //设置皮肤
	{
		if($user = self::data_user($uuid))
		{
			if($model == false)
			{
				$user['SKIN']['hash']  = $hash;
				$user['SKIN']['model'] = 'default';
			}
			else			
			{
				$user['SKIN']['hash']  = $hash;
				$user['SKIN']['model'] = 'slim';
			}
			
			self::data_user($uuid,$user);
		}
		else throw new Exception('用户不存在');
	}
}