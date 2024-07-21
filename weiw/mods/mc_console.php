<?php return function ()
	{
		try
		{
			if(!$user = mc_user_authentication::getUser())
			{
				throw new Exception("没有登陆");
			}
			
			
			if(!isset($_GET['command']))
			{
				throw new Exception('缺少参数 command');
			}
			
			
			if(preg_match('!^changepassword (.+) (.+) (.+)$!', $_GET['command'], $command))
			{
				if(!$user->verifyPassword($command[1]))
				{
					throw new Exception('旧密码错误');
				}
				
				if(!$user->validatePassword($command[2]))
				{
					throw new Exception('新密码长度需在 8 到 30 个字符之间，并且包含至少一个小写字母、一个大写字母、一个数字和一个特殊字符');
				}
				
				if($command[2] !== $command[3])
				{
					throw new Exception('确认新密码错误');
				}
				
				
				$userManager = new mc_user_manager();
				$user->setPassword($command[3]);
				$user->saveToJson($userManager->getUserDir());
				
				
				throw new Exception('更改完成');
			}
			
			
			if($user->isAdmin())
			{
				if(preg_match('!^usermoney (.+) (.+)$!', $_GET['command'], $command))
				{
					$userManager = new mc_user_manager();
					
					if(!$userManager->userExists($command[1]))
					{
						throw new Exception("玩家 {$command[1]} 不存在");
					}
					
					if(!is_numeric($command[2]))
					{
						throw new Exception('金钱不合法');
					}
					
					
					$user = $userManager->getUserByName($command[1]);
					$user ->setMoney($user->money + $command[2]);
					$user ->saveToJson($userManager->getUserDir());
					
					
					throw new Exception("给予{$command[1]}增加{$command[2]}金钱，总金钱{$user->money}。");
				}
				
				
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
				else
				{
					$text = $Rcon->send($_GET['command']);
					$text = preg_replace('!(§[0-9a-z]?)!i','',$text);					
					
					
					throw new Exception($text);
				}
			}
			
			
			throw new Exception('无效的指令');
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