<?php return function ()
	{
		try
		{
			if($user = mc_user_authentication::getUser())
			{
				$userData = $user->toArray();
				$userData['admin'] = $user->isAdmin();
				
				return $userData;
			}
			else
			{
				return false;
			}
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};