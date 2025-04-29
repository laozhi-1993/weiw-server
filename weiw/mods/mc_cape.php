<?php return function ()
	{
		try
		{
			if(!$user = mc_user_authentication::getUser())
			{
				throw new Exception('没有登录');
			}
			
			
			if(!isset($_GET['hash']))
			{
				throw new Exception('缺少参数 hash');
			}
			
			
			if (file_exists(__MKHDIR__."/user_textures/{$_GET['hash']}.png"))
			{
				$userManager = new mc_user_manager();
				$user->setTexture($_GET['hash'], 'cape');
				$user->saveToJson($userManager->getUserDir());
				
				return ['error' => 'ok'];
			}
			else
			{
				throw new Exception('披风不存在');
			}
		}
		catch(error $error)
		{
			return ['error' => $error->getMessage()];
		}
		catch(Exception $Exception)
		{
			return ['error' => $Exception->getMessage()];
		}
	};