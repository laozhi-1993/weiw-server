<?php return function ()
	{
		try
		{
			$Arr = Array();
			$client = config::loadConfig('client');
			$client = reset($client);
			
			if ($client)
			{
				$items = json_decode($client['items'],true);
				
				if (json_last_error() === JSON_ERROR_NONE)
				{
					foreach($items as $key => $value)
					{
						$Arr[] = array_merge(Array('name'=>$key),$value);
					}
				}
			}
			
			return $Arr;
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};