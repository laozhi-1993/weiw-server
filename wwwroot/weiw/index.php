<?php
	
	if (version_compare(PHP_VERSION, '8.0.0', '<')) {
		// 如果版本小于 8，则输出错误信息并终止代码
		die("PHP 版本过低，请升级到 PHP 8 或更高版本。");
	}
	
	function rootdir(...$args)
	{
		return implode(DIRECTORY_SEPARATOR, array_merge([__DIR__], $args));
	}
	
	
	$customAutoload = function($className)
	{
		if(file_exists($classRoute = rootdir('fc', strtolower("class {$className}.php"))) && is_file($classRoute))
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
	
	
	$files = glob(rootdir('config', '*.example'));
	$folders = [
		'config',
		'data',
		'fc',
		'mods',
	];
	
	foreach ($files as $sourceFile)
	{
		$targetFile = substr($sourceFile, 0, -8);
		
		if (!file_exists($targetFile))
		{
			copy($sourceFile, $targetFile);
		}
	}
	
	foreach ($folders as $dirname)
	{
		$fullDir = rootdir($dirname);
		
		if (!is_dir($fullDir))
		{
			mkdir($fullDir, 0755, true);
		}
	}
	
	
	if(debug_backtrace() === Array())
	{
		if(isset($_GET['mods']))
		{
			header('content-type: application/json');
			
			
			if(preg_match('!^[A-Za-z0-9._-]+$!',$_GET['mods']) && is_file($route = rootdir('mods', "{$_GET['mods']}.php")))
			{
				try
				{
					$mods = include($route);
					$json = json_encode($mods());
				}
				catch (Error $error)
				{
					$json = json_encode([
						'error' => $error->getMessage(),
						'file' =>  $error->getfile(),
						'code' =>  $error->getCode(),
						'line' =>  $error->getLine(),
					]);
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