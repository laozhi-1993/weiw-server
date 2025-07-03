<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$client = config::loadConfig('client');
			$requiredParams = [
				'server',
				'auth-url',
				'jvm',
				'downloads',
				'items',
				'rcon-host',
				'rcon-post',
				'rcon-password',
				'rcon-time'
			];
			
			foreach ($requiredParams as $param) {
				if (!isset($_POST[$param])) {
					throw new Exception("缺少参数 $param");
				}
			}
			
			if (!array_key_exists($_GET['id'] ?? null, $client))
			{
				throw new Exception('配置不存在');
			}
			
			if (!json_decode($_POST['items']))
			{
				throw new Exception('道具语法错误：'.json_last_error());
			}
			
			
			$Arr = $client[$_GET['id']];
			
			$Arr['server']           = $_POST['server'];
			$Arr['authUrl']          = $_POST['auth-url'];
			$Arr['jvm']              = $_POST['jvm'];
			$Arr['downloads']        = $_POST['downloads'];
			$Arr['items']            = $_POST['items'];
			
			
			$Arr['rcon']['host']     = $_POST['rcon-host'];
			$Arr['rcon']['post']     = $_POST['rcon-post'];
			$Arr['rcon']['password'] = $_POST['rcon-password'];
			$Arr['rcon']['time']     = $_POST['rcon-time'];
			
			$client = new config('client');
			$client ->setValue($_GET['id'], $Arr);
			
			return ['error' => '保存完成'];
		}
		catch (Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};