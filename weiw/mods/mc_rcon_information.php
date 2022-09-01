<?php return function()
	{
		mkh_csrf::token();
		
		
		try
		{
			if(mc::admin())
			{
				if(isset($_GET['host']) && isset($_GET['post']) && isset($_GET['pwd']) && isset($_GET['time']))
				{
					$rcon = Array();
					$rcon['host'] = $_GET['host'];
					$rcon['post'] = $_GET['post'];
					$rcon['pwd']  = $_GET['pwd'];
					$rcon['time'] = $_GET['time'];
					
					
					config('rcon.php',$rcon);
					throw new Exception('保存完成');
				}
				else return config('rcon.php');
			}
			else throw new Exception('没有权限');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};