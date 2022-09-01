<?php return function()
	{
		mkh_csrf::token();
		
		
		try
		{
			if(isset($_GET['id']) && $user = mc::user())
			{
				$attribute = json_decode(http::open("https://littleskin.cn/texture/{$_GET['id']}"),true);
				if(isset($attribute['hash']))
				{
					mc::skin($user['id'],http::open("https://littleskin.cn/textures/{$attribute['hash']}"));
					throw new Exception('使用成功');
				}
				else throw new Exception('使用失败');
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