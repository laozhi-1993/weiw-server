<?php return function ()
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
			
			
			if(isset($_GET['filter']) && $_GET['filter'] == 'cape')
			{
				$filter = 'cape';
			}
			else
			{
				$filter = 'skin';
			}
			
			
			return json_decode(http::open("https://mcskin.com.cn/skinlib/list?filter={$filter}&sort=time&page={$page}"),true);
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};