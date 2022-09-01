<?php class mc
{
	static function data_user($uuid,$Arr=false)
	{
		$dir = __MKHDIR__;
		$config = config('config.php');
		if(is_array($Arr))
		{
			$STR = json_encode($Arr);
			return file_put_contents("{$dir}/user/user_{$uuid}.php","<?php die ?>{$STR}");
		}
		else
		{
			if(file_exists("{$dir}/user/user_{$uuid}.php"))
			{
				$user = json_decode(substr_replace(file_get_contents("{$dir}/user/user_{$uuid}.php"),'',0,12),true);
				if(isset($user['SKIN']['hash'])) $user['SKIN']['url'] = "{$config['Yggdrasil']}/texture/{$user['SKIN']['hash']}";
				if(isset($user['CAPE']['hash'])) $user['CAPE']['url'] = "{$config['Yggdrasil']}/texture/{$user['CAPE']['hash']}";
				return $user;
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
				$user['token']    = $token['accessToken'];
				$user['password'] = $token['password'];
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
	
	
	static function user_delete($email) //删除用户
	{
		$dir  = __MKHDIR__;
		$uuid = mc_auth::constructOfflinePlayerUuid($email);
		if(self::data_token($uuid))
		{
			$token = "{$dir}/user/token_{$uuid}.php";
			$user  = "{$dir}/user/user_{$token['uuid'][0]}.php";
			
			
			file_exists($token) && unlink($token);
			file_exists($user)  && unlink($user);
			return true;
		}
		else throw new Exception('用户不存在');
	}
	
	
	static function refresh_password($email) //刷新密码
	{
		$uuid = mc_auth::constructOfflinePlayerUuid($email);
		if($token = self::data_token($uuid))
		{
			$token['password'] = mc_auth::random();
			self::data_token($uuid,$token);
			return $token['password'];
		}
		else throw new Exception('用户不存在');
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
	
	
	static function CAPE($uuid,$url) //设置披风
	{
		if($user = self::data_user($uuid))
		{
			if(isset($user['CAPE']['hash']) && file_exists(__MKHDIR__."/user_textures/{$user['CAPE']['hash']}.png"))
			{
				unlink(__MKHDIR__."/user_textures/{$user['CAPE']['hash']}.png");
			}
			
			
			$user['CAPE']['hash'] = hash('sha256',$uuid.$url);
			self::data_user($uuid,$user);
			file_put_contents(__MKHDIR__."/user_textures/{$user['CAPE']['hash']}.png",$url);
		}
		else throw new Exception('用户不存在');
	}
	
	
	static function SKIN($uuid,$url,$type='default') //设置皮肤
	{
		if($user = self::data_user($uuid))
		{
			if(isset($user['SKIN']['hash']) && file_exists(__MKHDIR__."/user_textures/{$user['SKIN']['hash']}.png"))
			{
				unlink(__MKHDIR__."/user_textures/{$user['SKIN']['hash']}.png");
			}
			
			
			$user['SKIN']['hash']  = hash('sha256',$uuid.$url);
			self::data_user($uuid,$user);
			file_put_contents(__MKHDIR__."/user_textures/{$user['SKIN']['hash']}.png",$url);
		}
		else throw new Exception('用户不存在');
	}
}