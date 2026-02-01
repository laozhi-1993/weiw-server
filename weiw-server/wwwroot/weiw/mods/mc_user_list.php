<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			
			$userManager = new mc_user_manager();
			return $userManager->getUsers($_GET['page'] ?? 1);
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};