<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			$file_handler = new file_handler("{$_SERVER['DOCUMENT_ROOT']}/files", $_GET['p'] ?? '');
			
			if ($file_handler->upload()) {
				return ['success' => '文件上传成功', 'file' => $_FILES['file']];
			}
			
			throw new Exception("上传失败");
		}
		catch (Exception $e)
		{
			return ['error' => $e->getMessage()];
		}
	};