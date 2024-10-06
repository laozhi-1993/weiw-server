<?php class mc_user_authentication
{
	// 静态方法，用于获取当前用户对象
	public static function getUser()
	{
		// 检查是否存在 'login_token' Cookie 并进行验证
		if(isset($_COOKIE['login_token']) && preg_match('!^([A-Fa-f0-9]+)_([a-fA-F0-9]+)$!',$_COOKIE['login_token'],$token))
		{
			$userManager = new mc_user_manager();
			$user = $userManager->getUserByUuid($token[1]);
			
			// 验证用户对象及其登录令牌是否匹配
			if ($user && $token[2] === $user->loginToken) {
				return $user;
			}
		}
		
		
		return false;
	}
	
	// 静态方法，用于设置登录令牌的Cookie
	public static function setLoginToken($user, $second=1296000)
	{
		setcookie('login_token',$user->uuid.'_'.$user->loginToken,time()+$second,'/');
	}
	
	// 静态方法，用于清除登录令牌的Cookie
	public static function clearLoginToken()
	{
		setcookie('login_token','',0,'/');
	}
}