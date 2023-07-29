<?php return function ()
	{
		mkh_csrf::token();
		mc::admin();
		
		
		try
		{
			if(isset($_GET['value']))
			{
				json_decode($_GET['value']);
				if(json_last_error() == JSON_ERROR_NONE)
				{
					file_put_contents(__MKHDIR__.'/config/prop.php','<?php return '.var_export($_GET['value'],true).' ?>');
					throw new Exception('保存完毕');
				}
				else
				{
					throw new Exception('语法错误：'.json_last_error());
				}
			}
			else
			{
				return config::ini('prop');
			}
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};