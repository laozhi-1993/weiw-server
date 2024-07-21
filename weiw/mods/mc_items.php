<?php return function ()
	{
		try
		{
			$Arr = Array();
			foreach(json_decode(config::loadConfig('items'),true) as $key => $value)
			{
				$Arr[] = Array(
					'name' => $key,
					'price' => $value['price']
				);
			}
			
			return $Arr;
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};