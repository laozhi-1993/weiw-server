<?php return function ()
{
	try
	{
		$Arr = Array();
		$files = glob(__MKHDIR__.'/user_textures/*.png');
		
		foreach($files as $filePath)
		{
			$fileInfo = pathinfo($filePath);
			$Arr[] = $fileInfo['filename'];
		}
		
		return $Arr;
	}
	catch (Exception $e)
	{
		return Array('error' => $Exception->getMessage());
	}
};