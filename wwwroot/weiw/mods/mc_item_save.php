<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$requiredParams = [
				'name',
				'command',
				'price',
				'icon',
				'rconAddress',
				'rconPort',
				'rconPassword',
			];
			
			foreach ($requiredParams as $param) {
				if (!isset($_POST[$param])) {
					throw new Exception("缺少参数 $param");
				}
			}
			
			
			$item = new config('item');
			$item->setValue($_POST['name'], [
				'name'         => $_POST['name'],
				'command'      => $_POST['command'],
				'price'        => $_POST['price'],
				'icon'         => $_POST['icon'],
				'rconAddress'  => $_POST['rconAddress'],
				'rconPort'     => $_POST['rconPort'],
				'rconPassword' => $_POST['rconPassword'],
			]);
			
			return ['message' => 'ok'];
		}
		catch (Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};