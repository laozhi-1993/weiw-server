<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			if (isset($_GET['id']) && isset($_GET['newIndex']))
			{
				$client = new config('client');
				$client ->moveKeyToPosition($_GET['id'], $_GET['newIndex']);
			}
			
			return ['error' => 'ok'];
		}
		catch(Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};