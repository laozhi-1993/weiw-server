<?php return function()
	{
		mkh_csrf::token();
		mc::admin();
		
		
		try
		{
			if(isset($_GET['host']) && isset($_GET['post']) && isset($_GET['pwd']) && isset($_GET['time']))
			{
				$config = new config('rcon');
				$config ->set('host', $_GET['host']);
				$config ->set('post', $_GET['post']);
				$config ->set('pwd',  $_GET['pwd']);
				$config ->set('time', $_GET['time']);


				throw new Exception('保存完成');
			}
			else return config::ini('rcon');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};