<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$file_handler = new file_handler($_GET['p'] ?? '', "{$_SERVER['DOCUMENT_ROOT']}/files");
			
			if ($file_handler->isExists()) {
				$file_handler->delete();
				return ['success' => '删除成功'];
			}
			
			throw new Exception("要删除的文件不存在");
		}
		catch (Exception $e)
		{
			return ['error' => $e->getMessage()];
		}
	};