<?php return function()
	{
		mkh_csrf::token();
		mc::admin();
		
		
		try
		{
			if(isset($_GET['private']) && isset($_GET['public']))
			{
				$config = new config('rsa');
				$config ->set('private', $_GET['private']);
				$config ->set('public',  $_GET['public']);


				throw new Exception('保存完成');
			}
			else
			{
				$config  = config::ini('rsa');
				$private = htmlentities($config['private']);
				$public  = htmlentities($config['public'] );
				
				return Array('private' => $private,'public' => $public);
			}
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};