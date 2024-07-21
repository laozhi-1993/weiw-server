<?php return function ()
	{
		try
		{
			if(!$user = mc_user_authentication::getUser())
			{
				throw new Exception('没有登录');
			}
			
			
			if(!isset($_GET['id']))
			{
				throw new Exception('缺少参数id');
			}
			else
			{
				$texture = json_decode(http::open("https://mcskin.com.cn/texture/{$_GET['id']}"),true);
				if(!isset($texture['hash']))
				{
					throw new Exception('缺少参数 hash');
				}
				
				if(!isset($texture['type']))
				{
					throw new Exception('缺少参数 type');
				}
				
				if(!in_array($texture['type'], ['steve','alex']))
				{
					throw new Exception('不支持的材质类型');
				}
			}
			
			
			if($texture['type'] == 'steve')
			{
				$userManager = new mc_user_manager();
				$user->setSKIN($texture['hash'], true );
				$user->saveToJson($userManager->getUserDir());
				
				
				return Array (
					'error' => 'ok',
					'hash' => $texture['hash'],
					'type' => 'steve'
				);
			}
			
			if($texture['type'] == 'alex')
			{
				$userManager = new mc_user_manager();
				$user->setSKIN($texture['hash'], false);
				$user->saveToJson($userManager->getUserDir());
				
				
				return Array (
					'error' => 'ok',
					'hash' => $texture['hash'],
					'type' => 'alex'
				);
			}
		}
		catch(error $error)
		{
			return Array ('error' => '无法获取材质信息');
		}
		catch(Exception $Exception)
		{
			return Array ('error' => $Exception->getMessage());
		}
	};