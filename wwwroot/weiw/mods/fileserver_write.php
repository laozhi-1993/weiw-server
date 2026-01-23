<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$rootDir = dirname(dirname(__MKHDIR__)) . DIRECTORY_SEPARATOR . 'servers';
			$FileManager = new FileManager($rootDir, '');
			
			if (!$FileManager->writeFile($_POST['path'] ?? '', $_POST['content'] ?? '')) {
				throw new Exception("写入文件失败");
			}
			
			return ['success' => 'ok'];
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