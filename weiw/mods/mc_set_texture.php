<?php return function()
	{
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
						return Array('error' => 'ok','hash' => $texture['hash'],'type' => 'steve');
					}
					
					if($texture['type'] == 'alex')
					{
						mc::skin($user['id'],$texture['hash'],true);
						return Array('error' => 'ok','hash' => $texture['hash'],'type' => 'alex');
					}
					
					if($texture['type'] == 'cape' && mc::admin(false))
					{
						mc::cape($user['id'],$texture['hash'],true);
						return Array('error' => 'ok','hash' => $texture['hash'],'type' => 'cape');
					}
					
					throw new Exception('不支持的材质类型');
				}
				else throw new Exception('缺少关键参数');
			}
			else throw new Exception('缺少id参数');
		}
		catch(error $error)
		{
			return Array('error' => '无法获取材质信息或材质不存在');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};