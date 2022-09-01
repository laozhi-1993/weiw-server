<?php return function()
	{
		mkh_csrf::token();
		
		
		try
		{
			if(mc::admin())
			{
				if(isset($_GET['serverName']) && isset($_GET['domain']) && isset($_GET['home']) && isset($_GET['register']) && isset($_GET['download']) && isset($_GET['Yggdrasil']) && isset($_GET['sign_in_money']) && isset($_GET['initial_money']))
				{
					$config = config('config.php');
					$config['serverName']    = $_GET['serverName'];
					$config['domain']        = $_GET['domain'];
					$config['home']          = $_GET['home'];
					$config['register']      = $_GET['register'];
					$config['download']      = $_GET['download'];
					$config['Yggdrasil']     = $_GET['Yggdrasil'];
					$config['sign_in_money'] = $_GET['sign_in_money'];
					$config['initial_money'] = $_GET['initial_money'];
					
					
					config('config.php',$config);
					throw new Exception('保存完成');
				}
			}
			else throw new Exception('没有权限');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};