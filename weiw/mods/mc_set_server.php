<?php return function()
	{
		mkh_csrf::token();
		mc::admin();
		
		
		try
		{
			if(isset($_GET['serverName']) && isset($_GET['domain']) && isset($_GET['download']) && isset($_GET['Yggdrasil']) && isset($_GET['sign_in_money']) && isset($_GET['initial_money']) && isset($_GET['user_dir']) && isset($_GET['textures_dir']))
			{
				$config = new config('config');
				$config ->set('serverName',    $_GET['serverName']);
				$config ->set('domain',        $_GET['domain']);
				$config ->set('download',      $_GET['download']);
				$config ->set('Yggdrasil',     $_GET['Yggdrasil']);
				$config ->set('sign_in_money', $_GET['sign_in_money']);
				$config ->set('initial_money', $_GET['initial_money']);
				$config ->set('user_dir',      $_GET['user_dir']);
				$config ->set('textures_dir',  $_GET['textures_dir']);


				throw new Exception('保存完成');
			}
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};