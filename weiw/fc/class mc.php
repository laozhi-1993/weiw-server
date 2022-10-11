<?php class mc
{
	static function data_user($uuid,$Arr=false)
	{
		$dir = __MKHDIR__;
		if(is_array($Arr))
		{
			$STR = json_encode($Arr);
			return file_put_contents("{$dir}/user/user_{$uuid}.php","<?php die ?>{$STR}");
		}
		else
		{
			if(file_exists("{$dir}/user/user_{$uuid}.php"))
			{
				return json_decode(substr_replace(file_get_contents("{$dir}/user/user_{$uuid}.php"),'',0,12),true);
			}
			else return false;
		}
	}
	
	
	static function data_token($uuid,$Arr=false)
	{
		$dir = __MKHDIR__;
		if(is_array($Arr))
		{
			$STR = json_encode($Arr);
			return file_put_contents("{$dir}/user/token_{$uuid}.php","<?php die ?>{$STR}");
		}
		else
		{
			if(file_exists("{$dir}/user/token_{$uuid}.php"))
			{
				return json_decode(substr_replace(file_get_contents("{$dir}/user/token_{$uuid}.php"),'',0,12),true);
			}
			else return false;
		}
	}
	
	
	static function admin()
	{
		$user  = self::user();
		$admin = explode(' ',config('admin.php'));
		if(isset($user['email']) && isset($admin) && in_array($user['email'],$admin))
		{
			return true;
		}
		else
		{
			return false;
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
		if(isset($_COOKIE['login_token']))
		{
			$login = explode('_',$_COOKIE['login_token']);
			
			if(isset($login[0]))
			{
				$token = self::data_token($login[0]);
				
				if(isset($token['login_token']) && $token['login_token'] == $_COOKIE['login_token'])
				{
					unset($token['login_token']);
					self::data_token($login[0],$token);
					setcookie('login_token','',0,'/');
					throw new Exception('退出完成');
				}
			}
		}
		
		throw new Exception('请登录');
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