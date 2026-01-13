<?php return function ()
{
	try
	{
		$Arr = Array();
		$files = glob(dirname(dirname(__MKHDIR__)) . DIRECTORY_SEPARATOR . 'usercapes' . DIRECTORY_SEPARATOR . '*.png');
		
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