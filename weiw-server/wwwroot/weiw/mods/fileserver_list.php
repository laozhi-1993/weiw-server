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
			
			return [
				'path'       => $path,
				'parent'     => $FileManager->getParentDir($path),
				'breadcrumb' => $FileManager->getBreadcrumb($path),
				'list'       => $FileManager->getList($path),
			];
		}
		catch(Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};