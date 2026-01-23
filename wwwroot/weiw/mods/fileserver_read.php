<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$rootDir = dirname(dirname(__MKHDIR__)) . DIRECTORY_SEPARATOR . 'servers';
			$FileManager = new FileManager($rootDir, '');
			
			$data = $FileManager->readFile($_GET['p'] ?? '');
			if ($data === false) {
				throw new Exception("读取文件失败");
			}
			
			return ['data' => $data];
		}
		catch (error $e)
		{
			return ['error' => $e->getMessage()];
		}
		catch (Exception $e)
		{
			return ['error' => $e->getMessage()];
		}
	};