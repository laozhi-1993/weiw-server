<?php return function()
	{
		try
		{
			if(isset($_GET['page']) && is_numeric($_GET['page']))
			{
				$page = $_GET['page'];
			}
			else
			{
				$page = 1;
			}
			
			
			return json_decode(http::open("https://mcskin.mahua-a.top/skinlib/list?filter=skin&sort=time&page={$page}"),true);
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};