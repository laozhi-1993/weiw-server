<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			if (!isset($_GET['name'])) {
				throw new Exception("缺少参数 name");
			}
			
			
			$item = new config('item');
			$item->deleteValue($_GET['name']);
			
			return ['message' => 'ok'];
		}
		catch (Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};