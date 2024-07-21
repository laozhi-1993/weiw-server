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
			
			if(!isset($_GET['confirmPassword']))
			{
				throw new Exception('缺少参数 confirmPassword');
			}
			
			if(!mc_user::validateName($_GET['name']))
			{
				throw new Exception('名称无效');
			}
			
			if(!mc_user::validatePassword($_GET['password']))
			{
				throw new Exception('密码长度需在 8 到 30 个字符之间，并且包含至少一个小写字母、一个大写字母、一个数字和一个特殊字符');
			}
			
			
			if($_GET['password'] === $_GET['confirmPassword'])
			{
				$userManager = new mc_user_manager();
				$user = $userManager->addUser($_GET['name'], $_GET['password']);
				
				
				mc_user_authentication::setLoginToken($user);
				return ['success'=>'ok'];
			}
			else
			{
				throw new Exception('重复密码错误');
			}
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};