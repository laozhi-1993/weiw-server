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
				'checkin-money',
				'default-money',
				'private',
				'public',
			];
			
			foreach ($requiredParams as $param) {
				if (!isset($_POST[$param])) {
					throw new Exception("缺少参数 $param");
				}
			}
			
			$config = new config('config');
			$config ->setValue('name',            $_POST['name']);
			$config ->setValue('domain',          $_POST['domain']);
			$config ->setValue('download',        $_POST['download']);
			$config ->setValue('checkinMoney',    $_POST['checkin-money']);
			$config ->setValue('defaultMoney',    $_POST['default-money']);
			$config ->setValue('authDownloadUrl', $_POST['auth-download-url']);
			$config ->setValue('authServerUrl',   $_POST['auth-server-url']);
			$config ->setValue('private',         $_POST['private']);
			$config ->setValue('public',          $_POST['public']);
			
			
			return ['message' => 'ok'];
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};