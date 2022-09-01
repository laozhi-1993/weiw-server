<?php return function ()
	{
		mkh_csrf::token();
		
		
		try
		{
			if(mc::admin())
			{
				if(isset($_GET['id']))
				{
					$id   = $_GET['id'];
					$prop = config('rcon_prop.php');
					
					if(isset($prop[$id]))
					{
						unset($prop[$id]);
						config('rcon_prop.php',$prop);
						throw new Exception('删除完成');
					}
					else throw new Exception('删除的数据不存在');
				}
				else throw new Exception('缺少参数');
			}
			else throw new Exception('没有权限');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};