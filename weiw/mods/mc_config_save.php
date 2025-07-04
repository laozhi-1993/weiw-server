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
			
			if($_GET['type'] == 'config')
			{
				$requiredParams = [
					'name',
					'domain',
					'download',
					'auth-server-url',
					'checkin-money',
					'default-money'
				];
				
				foreach ($requiredParams as $param) {
					if (!isset($_GET[$param])) {
						throw new Exception("缺少参数 $param");
					}
				}
				
				$config = new config('config');
				$config ->setValue('name',          $_GET['name']);
				$config ->setValue('domain',        $_GET['domain']);
				$config ->setValue('download',      $_GET['download']);
				$config ->setValue('authServerUrl', $_GET['auth-server-url']);
				$config ->setValue('checkinMoney',  $_GET['checkin-money']);
				$config ->setValue('defaultMoney',  $_GET['default-money']);
				
				
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