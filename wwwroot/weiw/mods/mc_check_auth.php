<?php return function ()
	{
		try
		{
			if(mc_user_authentication::getUser())
			{
				header("Location: index.php");
				exit;
			}
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};