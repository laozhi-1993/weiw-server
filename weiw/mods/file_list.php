<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$file_handler = new file_handler("{$_SERVER['DOCUMENT_ROOT']}/files", $_GET['p'] ?? '');
			
			return [
				'current'       => $file_handler->getCurrentPath(),
				'pathArray'     => $file_handler->getPathToArray(),
				'parent'        => $file_handler->getParentDir(),
				'directoryList' => $file_handler->getDirectoryListing(),
			];
		}
		catch(Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};