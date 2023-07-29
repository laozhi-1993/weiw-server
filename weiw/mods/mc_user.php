<?php return function($url)
	{
		try
		{
			$user = mc::user();
			if(mc::admin(false))
			{
				$user['admin'] = true;
			}
			else
			{
				$user['admin'] = false;
			}
		}
		catch(Exception $Exception)
		{
			if($url)
			{
				$_SERVER['REQUEST_URI'] = urlencode($_SERVER['REQUEST_URI']);
				header("Location: {$url}?url={$_SERVER['REQUEST_URI']}");
				die();
			}
			else return Array('error' => $Exception->getMessage());
		}
		
		return $user; 
	};