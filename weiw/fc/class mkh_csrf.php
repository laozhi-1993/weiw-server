<?php

class mkh_csrf
{
	static function domain()
	{
		if(defined('__MKHAPI__') && __MKHAPI__)
		{
			if(isset($_SERVER['HTTP_REFERER']))
			{
				$REFERER = explode('//',$_SERVER['HTTP_REFERER']);
				
				if(stripos($REFERER[1],$_SERVER['SERVER_NAME']) === 0)
				{
					return true;
				}
			}
			exit("<center><font size='7'>Cross domain access prohibited</font></center>");
		}
	}
	
	
	static function token()
	{
		if(defined('__MKHAPI__') && __MKHAPI__)
		{
			if(isset($_COOKIE['token']) && preg_match('!^[0-9a-zA-z]{11}$!',$_COOKIE['token']))
			{
				if($_COOKIE['token'] == $_GET['token'])
				{
					return true;
				}
			}
			exit("<center><font size='7'>Cross domain access prohibited</font></center>");
		}
	}
}