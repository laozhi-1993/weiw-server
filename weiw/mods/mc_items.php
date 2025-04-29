<?php return function ()
	{
		try
		{
			$Arr = Array();
			$items = json_decode(config::loadConfig('items'),true);
			
			foreach($items as $key => $value)
			{
				$Arr[] = array_merge(Array('name'=>$key),$value);
			}
			
			return $Arr;
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};