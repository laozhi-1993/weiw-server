<?php return function()
	{
		mkh_csrf::token();
		
		
		try
		{
			if(isset($_GET['id']) && $user = mc::user())
			{
				$texture = json_decode(http::open("https://littleskin.cn/texture/{$_GET['id']}"),true);
				if(isset($texture['hash']) && isset($texture['type']))
				{
					if($texture['type'] == 'steve')
					{
						mc::skin($user['id'],$texture['hash']);
						return Array('error' => 'ok','hash' => $texture['hash']);
					}
					
					if($texture['type'] == 'alex')
					{
						mc::skin($user['id'],$texture['hash'],true);
						return Array('error' => 'ok','hash' => $texture['hash']);
					}
					
					throw new Exception('不支持的材质类型');
				}
				else throw new Exception('获取材质信息失败');
			}
			else throw new Exception('缺少参数');
		}
		catch(error $error)
		{
			return Array('error' => '获取材质信息失败');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};