<?php return function()
	{
		mkh_csrf::token();
		
		
		try
		{
			if(isset($_GET['log_out']) && $_GET['log_out'] == 1)
			{
				mc::user_exit();
			}
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};