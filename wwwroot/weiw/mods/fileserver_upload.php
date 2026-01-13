<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$rootDir = dirname(dirname(__MKHDIR__)) . DIRECTORY_SEPARATOR . 'servers';
			$FileManager = new FileManager($rootDir, '');
			$path = $_GET['p'] ?? '';
			
			if (isset($_FILES['file']) && $FileManager->upload($path, $_FILES['file'])) {
				return ['success' => '文件上传成功'];
			}
			
			throw new Exception("上传失败");
		}
		catch (Exception $e)
		{
			return ['error' => $e->getMessage()];
		}
	};