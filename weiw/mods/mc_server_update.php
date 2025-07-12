<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$requiredParams = [
				'name',
				'domain',
				'download',
				'auth-server-url',
				'checkin-money',
				'default-money',
				'items',
				'private',
				'public',
			];
			
			foreach ($requiredParams as $param) {
				if (!isset($_GET[$param])) {
					throw new Exception("缺少参数 $param");
				}
			}
			
			if (!json_decode($_GET['items'])) {
				throw new Exception('道具语法错误：'.json_last_error());
			}
			
			$config = new config('config');
			$config ->setValue('name',          $_GET['name']);
			$config ->setValue('domain',        $_GET['domain']);
			$config ->setValue('download',      $_GET['download']);
			$config ->setValue('authServerUrl', $_GET['auth-server-url']);
			$config ->setValue('checkinMoney',  $_GET['checkin-money']);
			$config ->setValue('defaultMoney',  $_GET['default-money']);
			$config ->setValue('items',         $_GET['items']);
			$config ->setValue('private',       $_GET['private']);
			$config ->setValue('public',        $_GET['public']);
			
			
			throw new Exception('保存完成');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};