<?php return function ()
	{
		try
		{
			// 获取当前用户
			$user = mc_user_authentication::getUser();
			if (!$user) {
				throw new Exception('没有登录');
			}
			
			$clientManager = new client_manager();
			return $clientManager->getAllClient($user);
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};