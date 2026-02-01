<?php return function ()
	{
		try
		{
			if(!isset($_GET['name']))
			{
				throw new Exception('缺少参数 name');
			}
			
			if(!isset($_GET['password']))
			{
				throw new Exception('缺少参数 password');
			}
			
			$config = config::loadConfig('config');
			$userManager = new mc_user_manager();
			$user = $userManager->getUserByName($_GET['name']);
			if(!$user)
			{
				throw new Exception('密码错误或玩家不存在');
			}
			
			if(!$user->verifyPassword($_GET['password']))
			{
				throw new Exception('密码错误或玩家不存在');
			}
			
			$user->setLoginToken();
			$user->setAccessToken();
			$userManager->saveToFile($user);
			
			return [
				'success'=>'ok',
				'name'   => $config['name'],
				'token'  => $user->uuid.'_'.$user->loginToken,
			];
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};