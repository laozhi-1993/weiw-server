<?php return function()
	{
		mkh_csrf::token();
		
		
		try
		{
			$refresh = Array();
			$user    = mc::user();
			
			
			if($user)
			{
				$refresh['password'] = mc::refresh_password($user['email']);
				$refresh['error']    = '刷新完成';
				return $refresh;
			}
			else throw new Exception('你没有登陆');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};