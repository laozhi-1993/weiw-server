<?php return function ()
	{
		mkh_csrf::domain();
		mkh_csrf::token();
		
		
		try
		{
			if(mc::admin())
			{
				if(isset($_GET['content']))
				{
					$notice = Array();
					$notice['content'] = base64_encode($_GET['content']);
					$notice['time'] = time();
					
					config('notice.php',$notice);
					throw new Exception('ok');
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