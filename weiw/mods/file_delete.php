<?php return function ()
{
	try
	{
		$user = mc_user_authentication::getUser();
		if (!$user || !$user->isAdmin()) {
			return ['error' => '没有权限'];
		}
		
		$paths = file_handler::getPath();
		if ($paths['currentPath'] !== '')
		{
			if (file_handler::delete($paths['absolutePath'])) {
				return ['success' => '删除成功'];
			}
			
			return ['error' => '删除失败'];
		}
		else
		{
			return ['error' => '要删除的文件不存在'];
		}
	}
	catch (Exception $e)
	{
		return ['error' => $e->getMessage()];
	}
};