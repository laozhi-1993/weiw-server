<?php
	
	if (version_compare(PHP_VERSION, '7.0.0', '<')) {
		// 如果版本小于 7，则输出错误信息并终止代码
		die("PHP 版本过低，请升级到 PHP 7 或更高版本。");
	}
	
	$customAutoload = function($className)
	{
		if(file_exists($classRoute = __MKHDIR__.strtolower("/fc/class {$className}.php")) && is_file($classRoute))
		{
			require_once($classRoute);
		}
	};
	
	$customErrorHandler = function($error_level,$error_message,$error_file,$error_line)
	{
		throw new mkh_error($error_level,$error_message,$error_file,$error_line);
	};
	
	error_reporting(~E_NOTICE);
    define('__MKHDIR__', __DIR__);
    define('__currenttime__', microtime(true));
	spl_autoload_register($customAutoload);
	set_error_handler($customErrorHandler);
	
	
	if(debug_backtrace() === Array())
	{
		if(isset($_GET['mods']))
		{
			header('content-type: application/json');
			
			
			if(preg_match('!^[A-Za-z0-9._-]+$!',$_GET['mods']) && is_file($route = __MKHDIR__."/mods/{$_GET['mods']}.php"))
			{
				try
				{
					$mods = include($route);
					$json = json_encode($mods());
				}
				catch (Error $error)
				{
					mkh_error::view($error->getCode(),$error->getMessage(),$error->getfile(),$error->getLine());
				}
			}
			else
			{
				$json = json_encode(Array('error' => "Mods \"{$_GET['mods']}\" not exist"));
			}
			
			
			if(isset($_GET['callback']) && preg_match('!^([$]?[A-Za-z0-9._-]{1,30})$!',$_GET['callback']))
			{
				die("{$_GET['callback']}({$json});");
			}
			else
			{
				die($json);
			}
		}
		else
		{
			http_response_code(404);
			exit(0);
		}
	}
	else
    {
        if(isset($_COOKIE['token']) && preg_match('!^[A-Za-z0-9]{11}$!',$_COOKIE['token']))
        {
            $token = $_COOKIE['token'];
        }
        else
        {
            $token = substr(str_shuffle('1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM'),0,11);
        }

        define   ('token',"token=$token");
        setcookie('token',$token,0,'/');
    }