<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			if (isset($_GET['id']))
			{
				$client = new config('client');
				$client ->deleteValue($_GET['id']);
			}
			
			return ['error' => 'ok'];
		}
		catch(Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};