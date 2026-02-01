<?php class mkh_csrf
{
	public static function domain()
	{
		if(isset($_SERVER['HTTP_REFERER']) && isset($_SERVER['SERVER_NAME']))
		{
			$REFERER = explode('//',$_SERVER['HTTP_REFERER']);
			
			if(stripos($REFERER[1],$_SERVER['SERVER_NAME']) === 0)
			{
				return true;
			}
		}
		else mkh_error::warning('Cross domain access prohibited');
	}
	
	
	public static function token()
	{
		if(isset($_COOKIE['token']) && isset($_GET['token']) && preg_match('!^[0-9a-zA-z]{11}$!',$_COOKIE['token']))
		{
			if($_COOKIE['token'] == $_GET['token'])
			{
				return true;
			}
		}
		else mkh_error::warning('Cross domain access prohibited');
	}
}