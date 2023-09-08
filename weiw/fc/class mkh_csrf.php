<?php

class mkh_csrf
{
	public static function domain()
	{
		if(defined('__MKHAPI__') && __MKHAPI__)
		{
			if(isset($_SERVER['HTTP_REFERER']) && isset($_SERVER['SERVER_NAME']))
			{
				$REFERER = explode('//',$_SERVER['HTTP_REFERER']);
				
				if(stripos($REFERER[1],$_SERVER['SERVER_NAME']) === 0)
				{
					return true;
				}
			}
			header('content-type: text/html');
			exit("<center><font size='7'>Cross domain access prohibited</font></center>");
		}
	}
	
	
	public static function token()
	{
		if(defined('__MKHAPI__') && __MKHAPI__)
		{
			if(isset($_COOKIE['token']) && isset($_GET['token']) && preg_match('!^[0-9a-zA-z]{11}$!',$_COOKIE['token']))
			{
				if($_COOKIE['token'] == $_GET['token'])
				{
					return true;
				}
			}
			header('content-type: text/html');
			exit("<center><font size='7'>Cross domain access prohibited</font></center>");
		}
	}
}