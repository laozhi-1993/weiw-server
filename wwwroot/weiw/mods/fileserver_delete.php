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
			$password = $_GET['password'] ?? '';
			
			
			if (!$user->validatePassword($password)) {
				throw new Exception('密码错误无法删除此文件');
			}
			
			if (!$FileManager->exists($path)) {
				throw new Exception("要删除的文件不存在");
			}
			
			$FileManager->delete($path);
			return ['success' => '删除成功'];
		}
		catch (Exception $e)
		{
			return ['error' => $e->getMessage()];
		}
	};