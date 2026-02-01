<?php return function ()
	{
		try
		{
			return array_values(config::loadConfig('item'));
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};