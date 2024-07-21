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
			
			
			$userManager = new mc_user_manager();
			$user = $userManager->getUserByName($_GET['name']);					
			if($user->verifyPassword($_GET['password']))
			{
				$user->setLoginToken();
				$user->setAccessToken();
				$user->saveToJson($userManager->getUserDir());
				
				
				mc_user_authentication::setLoginToken($user);
				return ['success'=>'ok'];
			}
			else
			{
				throw new Exception('密码错误');
			}
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};