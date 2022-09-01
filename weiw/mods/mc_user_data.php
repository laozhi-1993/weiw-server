<?php return function ()
	{
		mkh_csrf::token();
		
		
		try
		{
			if(mc::admin())
			{
				$Arr  = Array();
				$uuid = mc_auth::constructOfflinePlayerUuid($_GET['name']);
				
				
				if(isset($_GET['bi']) && is_numeric($_GET['bi']))
				{
					mc::money($uuid,$_GET['bi']);
				}
				
				
				if($user = mc::data_user($uuid))
				{
					$Arr['blacklist']     = $user['blacklist'];
					$Arr['name']          = $user['name'];
					$Arr['email']         = $user['email'];
					$Arr['bi']            = $user['bi'];
					$Arr['login_ip']      = $user['login_ip'];
					$Arr['login_time']    = date('Y-m-d H:i',$user['login_time']+28800);
					$Arr['register_time'] = date('Y-m-d H:i',$user['register_time']+28800);
					
					
					return $Arr;
				}
				else throw new Exception('用户不存在');
			}
			else throw new Exception('没有权限');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};