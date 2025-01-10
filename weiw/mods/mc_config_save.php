<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			if(!isset($_GET['type'])) {
				throw new Exception("缺少参数 type");
			}
			
			if($_GET['type'] == 'client')
			{
				$requiredParams = [
					'version',
					'authModule',
					'jvm',
					'quickPlayAddress',
					'extensionType',
					'extensionValue'
				];
				
				foreach ($requiredParams as $param) {
					if (!isset($_GET[$param])) {
						throw new Exception("缺少参数 $param");
					}
				}
				
				$client = new config('client');
				$client ->setValue('version',          $_GET['version']);
				$client ->setValue('authModule',       $_GET['authModule']);
				$client ->setValue('jvm',              $_GET['jvm']);
				$client ->setValue('quickPlayAddress', $_GET['quickPlayAddress']);
				$client ->setValue('extensionType',    $_GET['extensionType']);
				$client ->setValue('extensionValue',   $_GET['extensionValue']);
				
				
				throw new Exception('保存完成');
			}
			
			
			if($_GET['type'] == 'config')
			{
				$requiredParams = [
					'serverName',
					'domain',
					'download',
					'authUrl',
					'checkinMoney',
					'defaultMoney'
				];
				
				foreach ($requiredParams as $param) {
					if (!isset($_GET[$param])) {
						throw new Exception("缺少参数 $param");
					}
				}
				
				$config = new config('config');
				$config ->setValue('serverName',   $_GET['serverName']);
				$config ->setValue('domain',       $_GET['domain']);
				$config ->setValue('download',     $_GET['download']);
				$config ->setValue('authUrl',      $_GET['authUrl']);
				$config ->setValue('checkinMoney', $_GET['checkinMoney']);
				$config ->setValue('defaultMoney', $_GET['defaultMoney']);
				
				
				throw new Exception('保存完成');
			}
			
			
			if($_GET['type'] == 'rcon')
			{
				$requiredParams = [
					'host',
					'post',
					'password',
					'time'
				];
				
				foreach ($requiredParams as $param) {
					if (!isset($_GET[$param])) {
						throw new Exception("缺少参数 $param");
					}
				}
				
				$config = new config('rcon');
				$config ->setValue('host',     $_GET['host']);
				$config ->setValue('post',     $_GET['post']);
				$config ->setValue('password', $_GET['password']);
				$config ->setValue('time',     $_GET['time']);


				throw new Exception('保存完成');
			}
			
			
			if($_GET['type'] == 'rsa')
			{
				$requiredParams = [
					'private',
					'public'
				];
				
				foreach ($requiredParams as $param) {
					if (!isset($_GET[$param])) {
						throw new Exception("缺少参数 $param");
					}
				}
				
				$config = new config('rsa');
				$config ->setValue('private', $_GET['private']);
				$config ->setValue('public',  $_GET['public']);
				
				
				throw new Exception('保存完成');
			}
			
			
			if($_GET['type'] == 'items')
			{
				if (!isset($_GET['value'])) {
					throw new Exception("缺少参数 value");
				}
				
				if (!json_decode($_GET['value'])) {
					throw new Exception('语法错误：'.json_last_error());
				}
				
				
				file_put_contents(__MKHDIR__.'/config/items.php','<?php return '.var_export($_GET['value'],true).' ?>');
				throw new Exception('保存完毕');
			}
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};