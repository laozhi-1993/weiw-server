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
				'loaderType',
				'loaderValue'
			];
			
			foreach ($requiredParams as $param) {
				if (!isset($_GET[$param])) {
					throw new Exception("缺少参数 $param");
				}
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
			$Arr['extensionType']    = $_GET['loaderType'];
			$Arr['extensionValue']   = $_GET['loaderValue'];
			
			
			$Arr['address']          = '127.0.0.1';
			$Arr['authModule']       = 'https://authlib-injector.yushi.moe/artifact/53/authlib-injector-1.2.5.jar';
			$Arr['jvm']              = '-Xmx6G';
			$Arr['downloads']        = '';
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