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
			
			
			if (file_exists(dirname(dirname(__MKHDIR__)) . DIRECTORY_SEPARATOR . 'usercapes' . DIRECTORY_SEPARATOR. "{$_GET['hash']}.png"))
			{
				$user->setTexture($_GET['hash'], 'cape');
				$userManager = new mc_user_manager();
				$userManager->saveToFile($user);
				
				return ['success' => 'ok'];
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