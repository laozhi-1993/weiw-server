<?php return function ()
	{
		try
		{
			if(!$user = mc_user_authentication::getUser()) {
				throw new Exception('没有登录');
			}
			
			$second = 86400; //86400
			
			
			if(isset($_GET['checkin']))
			{
				if(time() >= ($user->checkinTime + $second))
				{
					$user->setMoney($user->money + config::loadConfig('config')['checkinMoney']);
					$user->setCheckinTime();
					$userManager = new mc_user_manager();
					$userManager->saveToFile($user);
					
					
					return Array(
						'success' => 'ok',
						'time' => $second,
						'money' => $user->money
					);
				}
				else throw new Exception('已经签到过了');
			}
			else
			{
				if((time() - $user->checkinTime) >= $second)
				{
					return Array('count_down' => 0);
				}
				else
				{
					return Array('count_down' => $second - (time() - $user->checkinTime));
				}
			}
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};