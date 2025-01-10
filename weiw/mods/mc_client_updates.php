<?php return function ()
{
    try
	{
		$appAsarPath = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'app.asar';
        if (file_exists($appAsarPath) && is_file($appAsarPath))
		{
			$hash = hash_file('sha256', $appAsarPath);
			$url = http::get_current_url('app.asar');
			
			return [
				'hash' => $hash,
				'url' => $url,
			];
		}
		else
		{
			return [];
		}
    }
	catch (Exception $Exception)
	{
        return ['error' => $Exception->getMessage()];
    }
};