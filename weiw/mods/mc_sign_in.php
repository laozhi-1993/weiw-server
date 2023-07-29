<?php return function()
	{
		try
		{
			if($user = mc::user())
			{
				$data_user = mc::data_user($user['id']);
				$config    = config::ini('config');
				if(isset($_GET['si']) && $_GET['si'] == '1')
				{
					//86400
					if(!isset($data_user['sign_in']) or time() >= ($data_user['sign_in'] + 86400))
					{
						$data_user['sign_in'] = time();
						$data_user['bi']      = $data_user['bi'] + $config['sign_in_money'];
						mc::data_user($user['id'],$data_user);
						
						
						return Array('error' => 'ok','time' => '86400','bi' => $data_user['bi']);
					}
					else throw new Exception('已经签到过了');
				}
				else
				{
					if(!isset($data_user['sign_in']) or (time() - $data_user['sign_in']) >= 86400)
					{
						return Array('count_down' => 0);
					}
					else
					{
						return Array('count_down' => 86400 - (time() - $data_user['sign_in']));
					}
				}
			}
			else throw new Exception('没有登录');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};