<?php return function ()
	{
		try
		{
			if(!$user = mc_user_authentication::getUser())
			{
				throw new Exception('没有登录');
			}
			
			
			$items = json_decode(config::loadConfig('items'), true);
			$config = config::loadConfig('rcon');
			$Rcon = new Rcon (
				$config['host'],
				$config['post'],
				$config['password'],
				$config['time']
			);
			
			
			if(!$Rcon ->connect())
			{
				throw new Exception('无法连接到我的世界服务器');
			}
			
			
			if(!in_array($user->name, $Rcon->list()['list']))
			{
				throw new Exception('你不在游戏中无法购买');
			}
			
			
			if((!isset($_GET['id'])) or (!isset($items[$_GET['id']])))
			{
				throw new Exception('道具不存在');
			}
			
			
			if((!isset($items[$_GET['id']]['price'])) or ($items[$_GET['id']]['price'] >= $user->money))
			{
				throw new Exception('你的金币不够');
			}
			else
			{
				$text = $Rcon->send(str_ireplace('{name}', $user->name, $items[$_GET['id']]['command']));
				$text = preg_replace('!(§[0-9a-z]?)!i', '', $text);
				$text = nl2br($text);
				
				
				$userManager = new mc_user_manager();
				$user->setMoney($user->money - $items[$_GET['id']]['price']);
				$user->saveToJson($userManager->getUserDir());
				
				
				return Array (
					'error' => $text,
					'money' => $user->money
				);
			}
		}
		catch(error $error)
		{
			return Array ('error' => $error->getMessage());
		}
		catch(Exception $Exception)
		{
			return Array ('error' => $Exception->getMessage());
		}
	};