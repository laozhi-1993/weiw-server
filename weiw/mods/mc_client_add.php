<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$requiredParams = [
				'name',
				'version',
				'extension-type',
				'extension-value',
				'server',
				'auth-url',
				'jvm',
				'downloads',
			];
			
			foreach ($requiredParams as $param) {
				if (!isset($_GET[$param])) {
					throw new Exception("缺少参数 $param");
				}
			}
			
			if (!in_array($_GET['extension-type'], ['fabric', 'forge', 'neoforge'], true)) {
				$_GET['extension-type'] = 'none';
			}
			
			
			$clientDir = "{$_SERVER['DOCUMENT_ROOT']}/files/{$_GET['name']}";
			
			if (!file_exists($clientDir))
			{
				mkdir($clientDir, 0777, true);
			}
			
			
			$id = uniqid();
			$Arr = Array();
			$Arr['id']               = $id;
			$Arr['name']             = $_GET['name'];
			$Arr['version']          = $_GET['version'];
			$Arr['extensionType']    = $_GET['extension-type'];
			$Arr['extensionValue']   = $_GET['extension-value'];
			
			
			$Arr['server']           = $_GET['server'];
			$Arr['authUrl']          = $_GET['auth-url'];
			$Arr['jvm']              = $_GET['jvm'];
			$Arr['downloads']        = $_GET['downloads'];
			$Arr['items']            = config::loadConfig('items');
			
			
			$Arr['rcon']['host']     = '127.0.0.1';
			$Arr['rcon']['post']     = '25575';
			$Arr['rcon']['password'] = '123456';
			$Arr['rcon']['time']     = '3000';
			
			$client = new config('client');
			$client ->setValue($id, $Arr);
			
			return ['error' => 'ok'];
		}
		catch (Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};