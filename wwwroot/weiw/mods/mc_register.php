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
			if($userManager->userExists($_GET['name']))
			{
				throw new Exception('玩家已存在');
			}
			
			if(!mc_user::validateName($_GET['name']))
			{
				throw new Exception('名称无效');
			}
			
			if(!mc_user::validatePassword($_GET['password']))
			{
				throw new Exception('密码长度需在 8 到 30 个字符之间，并且包含至少一个小写字母、一个大写字母、一个数字和一个特殊字符');
			}
			
			
			mc_user_authentication::setLoginToken($userManager->addUser($_GET['name'], $_GET['password']));
			return ['success'=>'ok'];
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};