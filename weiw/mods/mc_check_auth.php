<?php return function ()
	{
		try
		{
			if($user = mc_user_authentication::getUser())
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