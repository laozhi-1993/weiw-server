<?php return function ()
	{
		mkh_csrf::token();
		
		
		try
		{
			return config('rcon_prop.php');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};