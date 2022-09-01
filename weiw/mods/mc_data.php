<?php return function ()
	{
		mkh_csrf::token();
		
		
		try
		{
			if($user = mc::user())
			{
				$data = Array();
				$data['money'] = $user['bi'];
				
				
				try
				{
					$ini  = config('rcon.php');
					$Rcon = new Rcon($ini['host'] ,$ini['post'] ,$ini['pwd'] ,$ini['time'] );
					$Rcon ->connect();
					
					$data['user'] = $Rcon->list();
				}
				catch(error $error)
				{
					$data['user']['current'] = 0;
					$data['user']['maximum'] = 0;
					$data['user']['list']    = Array();
				}
				
				
				return $data;
			}
			else throw new Exception('没有登录');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};