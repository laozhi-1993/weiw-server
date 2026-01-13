<?php return function ()
	{
		try
		{
			if(!$user = mc_user_authentication::getUser())
			{
				throw new Exception('没有登录');
			}
			
			if (!isset($_GET['id']))
			{
				throw new Exception('缺少参数 id');
			}
			
			$items = config::loadConfig('item');
			
			if(!isset($items[$_GET['id']]))
			{
				throw new Exception('道具不存在');
			}
			
			$item = $items[$_GET['id']];
			$Rcon = new Rcon (
				$item['rconAddress'],
				$item['rconPort'],
				$item['rconPassword'],
				300,
			);
			
			if(!$Rcon ->connect())
			{
				throw new Exception('无法连接到我的世界服务器');
			}
			
			if(!in_array($user->name, $Rcon->list()['list']))
			{
				throw new Exception('你不在游戏中无法购买');
			}
			
			
			if((!isset($item['price'])) or ($item['price'] >= $user->money))
			{
				throw new Exception('你的金币不够');
			}
			else
			{
				$text = $Rcon->send(str_ireplace('{name}', $user->name, $item['command']));
				$text = preg_replace('!(§[0-9a-z]?)!i', '', $text);
				$text = nl2br($text);
				
				
				$user->setMoney($user->money - $item['price']);
				$userManager = new mc_user_manager();
				$userManager->saveToFile($user);
				
				
				return Array (
					'success' => $text,
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