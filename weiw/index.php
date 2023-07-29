<?php
if(PHP_VERSION < 7) die('PHP version needs to be greater than 7.0.0');
if(!defined('__MKHDIR__'))
{
	error_reporting(~E_NOTICE);
    define('__MKHDIR__',__DIR__);
    define('__currenttime__',microtime(true));

	function include_html($name,$route)
	{
		if(!is_dir($route) && file_exists($route))
		{
			try
			{
				ob_start();
				include($route);
			}
			catch(Exception $Exception)
			{
				echo $Exception->getMessage();
			}
			
			
			$GLOBALS['_mkhbody'][$name] = mkh::Extract_HTML(ob_get_contents(),'body');
			$GLOBALS['_mkhhead'][$name] = mkh::Extract_HTML(ob_get_contents(),'head');
			ob_end_clean();
		}
		else exit("<center><font size='7'>flie \"{$route}\" not exist</font></center>");
	}


	function mods($a,$parameter=false)
	{
		if(is_file($route = __MKHDIR__."/mods/{$a}.php"))
		{
			try
			{
				$mods = include($route);
				return $mods($parameter);
			}
			catch (Error $error)
			{
				mkh_error::view($error->getCode(),$error->getMessage(),$error->getfile(),$error->getLine());
			}
		}
		else exit("<center><font size='7'>Mods \"{$a}\" not exist</font></center>");
	}


	spl_autoload_register(function ($class_name){
		if(file_exists($class_route = __MKHDIR__.strtolower("/fc/class {$class_name}.php")) && is_file($class_route))
			require_once($class_route);
	});


	set_error_handler(function ($error_level,$error_message,$error_file,$error_line){
		throw new mkh_error($error_level,$error_message,$error_file,$error_line);
	});


	if(realpath(__FILE__) === realpath($_SERVER['SCRIPT_FILENAME']))
	{
		if(isset($_GET['mods']))
		{
			header('content-type: application/json');
			define('__MKHAPI__',true);
			if(isset($_GET['callback']))
			{
				$callback = preg_replace('![^a-zA-Z0-9._$]!','',$_GET['callback']);
				$json     = json_encode(mods($_GET['mods']));
				
				die("$callback($json);");
			}
			
			
			exit(json_encode(mods($_GET['mods'])));
		}
		else
		{
			http_response_code(404);
			exit(0);
		}
	}
	else
    {
        if(isset($_COOKIE['token']) && preg_match('!^[0-9a-zA-z]{11}$!',$_COOKIE['token']))
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


	$GLOBALS['_mkhbody'] = Array();
	$GLOBALS['_mkhhead'] = Array();
	$GLOBALS['_MKHURL']  = Array();
	$GLOBALS['_MKHGET']  = Array();
	$GLOBALS['_MKHPOST'] = Array();


	foreach($_GET  as $key => $value) $GLOBALS['_MKHURL'][$key]  = "$key=".urlencode($value);
	foreach($_GET  as $key => $value) $GLOBALS['_MKHGET'][$key]  = nl2br(htmlspecialchars($value));
	foreach($_POST as $key => $value) $GLOBALS['_MKHPOST'][$key] = nl2br(htmlspecialchars($value));
}