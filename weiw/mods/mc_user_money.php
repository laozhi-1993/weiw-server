<?php return function ()
	{
		mkh_csrf::token();
		mc::admin();
		
		try
		{
			if(isset($_GET['name']) && $user = mc::data_user($uuid = mc_auth::constructOfflinePlayerUuid($_GET['name'])))
			{
				if(isset($_GET['bi']) && is_numeric($_GET['bi']))
				{
					$money = $user['bi'] + $_GET['bi'];
					mc::money($uuid,$money);
					throw new Exception("给予{$_GET['name']}增加{$_GET['bi']}金钱，总金钱{$money}。");
				}
				else throw new Exception('金钱不合法');
			}
			else throw new Exception('用户不存在');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};