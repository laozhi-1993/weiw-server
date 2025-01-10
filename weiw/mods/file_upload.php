<?php return function ()
{
	try
	{
		ini_set('max_execution_time', 0);
		ini_set('max_input_time', 0);

		$user = mc_user_authentication::getUser();
		if (!$user || !$user->isAdmin()) {
			return ['error' => '没有权限'];
		}
		
		$paths = file_handler::getPath();
		$fullPath = "{$paths['absolutePath']}/{$_FILES['file']['full_path']}";

		if ($_FILES['file']['error'] !== 0) {
			return ['error' => "文件上传错误: {$_FILES['file']['error']}"];
		}
		
		$dir = dirname($fullPath);
		if (!is_dir($dir)) {
			if (!mkdir($dir, 0777, true)) {
				return ['error' => '无法创建目录'];
			}
		}
		
		if (!move_uploaded_file($_FILES['file']['tmp_name'], $fullPath)) {
			return ['error' => '上传失败'];
		}
		
		return ['success' => '文件上传成功', 'file' => $_FILES['file']];
		
	}
	catch (Exception $e)
	{
		return ['error' => $e->getMessage()];
	}
};