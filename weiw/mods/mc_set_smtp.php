<?php return function()
	{
		mkh_csrf::token();
		mc::admin();
		
		
		try
		{
			if(isset($_GET['server']) && isset($_GET['serverport']) && isset($_GET['usermail']) && isset($_GET['user']) && isset($_GET['password']))
			{
				$config = new config('smtp');
				$config ->set('server',     $_GET['server']);
				$config ->set('serverport', $_GET['serverport']);
				$config ->set('usermail',   $_GET['usermail']);
				$config ->set('user',       $_GET['user']);
				$config ->set('password',   $_GET['password']);


				throw new Exception('保存完成');
			}
			else return config::ini('smtp');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};