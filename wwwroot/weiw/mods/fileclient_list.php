<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$clientsDir = dirname($_SERVER['DOCUMENT_ROOT']) . DIRECTORY_SEPARATOR . 'clients';
			$FileManager = new FileManager($clientsDir, http::get_current_url('clients'));
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