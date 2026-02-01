<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			if (!isset($_POST['name']))
			{
				throw new Exception('缺少参数 name');
			}
			
			if (!isset($_POST['money']))
			{
				throw new Exception('缺少参数 money');
			}
			
			$userManager = new mc_user_manager();
			if(!$userManager->userExists($_POST['name']))
			{
				throw new Exception("玩家\"{$_POST['name']}\"不存在");
			}
			
			if(!is_numeric($_POST['money']))
			{
				throw new Exception('金钱不合法');
			}
			
			$user = $userManager->getUserByName($_POST['name']);
			$user ->setMoney($user->money + $_POST['money']);
			$userManager->saveToFile($user);
			
			return ['success' => "给予{$_POST['name']}增加{$_POST['money']}金钱，总金钱{$user->money}。"];
		}
		catch(Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};