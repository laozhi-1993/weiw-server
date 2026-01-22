<?php class mc_user_authentication
{
	// 静态方法，用于获取当前用户对象
	public static function getUser(string|null $loginToken = null)
	{
		if ($loginToken === null)
		{
			$loginToken = $_COOKIE['login_token'] ?? '';
		}
		
		if ($loginToken)
		{
			[$id, $token] = explode('_', $loginToken, 2);
			
			if($token)
			{
				$userManager = new mc_user_manager();
				$user = $userManager->getUserByUuid($id);
				
				// 验证用户对象及其登录令牌是否匹配
				if ($user && $user->loginToken && $token === $user->loginToken) {
					return $user;
				}
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
	public static function clearLoginToken($user)
	{
		$user->setLoginToken();
		$user->setAccessToken();
		$userManager = new mc_user_manager();
		$userManager->saveToFile($user);
		setcookie('login_token','',0,'/');
	}
}