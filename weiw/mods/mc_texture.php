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
				throw new Exception('缺少参数 id');
			}
			
			
			$texture = json_decode(http::open("https://mcskin.com.cn/texture/{$_GET['id']}"),true);
			
			switch ($texture['type'])
			{
				case 'steve':
				case 'alex':
					$userManager = new mc_user_manager();
					$user->setTexture($texture['hash'], $texture['type']);
					$user->saveToJson($userManager->getUserDir());
					
					return [
						'error' => 'ok',
						'type' => $texture['type'],
						'hash' => $texture['hash']
					];
					
				default:
					return [
						'error' => '不支持的材质类型'
					];
			}
		}
		catch(error $error)
		{
			return ['error' => '无法获取材质信息'];
		}
		catch(Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};