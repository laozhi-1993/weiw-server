<?php return function ()
	{
		try
		{
			if(!isset($_GET['name']))
			{
				throw new Exception('缺少参数 name');
			}
			
			if(!mc_user::validateName($_GET['name']))
			{
				throw new Exception('名称无效');
			}
			
			
			$userManager = new mc_user_manager();
			if($userManager->getUserByName($_GET['name']))
			{
				return ['success'=>'login'];
			}
			else
			{
				return ['success'=>'register'];
			}
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};