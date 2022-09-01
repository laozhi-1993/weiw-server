<?php return function($url)
	{
		mkh_csrf::token();
		
		
		$config = config('config.php');
		header("X-Authlib-Injector-API-Location: {$config['Yggdrasil']}");
		
		try
		{
			$user = mc::user();
			if(stristr($_SERVER['HTTP_USER_AGENT'],'weiw-launcher'))
			{
				$user['client'] = true;
			}
			else
			{
				$user['client'] = false;
			}
			if(mc::admin())
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