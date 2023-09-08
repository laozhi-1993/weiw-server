<?php return function()
	{
		try
		{
			if(isset($_GET['id']))
			{
				$user = mc::user();
				$texture = json_decode(http::open("https://mcskin.cn/texture/{$_GET['id']}"),true);
				
				isset($texture['hash']) or throw new Exception('缺少参数hash');
				isset($texture['type']) or throw new Exception('缺少参数type');
				
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
				
				throw new Exception('不支持的材质类型');
			}
			
			throw new Exception('缺少参数id');
		}
		catch(error $error)
		{
			return Array('error' => '无法获取材质信息');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};