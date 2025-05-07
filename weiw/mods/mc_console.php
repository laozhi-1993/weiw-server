<?php return function ()
	{
		try
		{
			if(!$user = mc_user_authentication::getUser())
			{
				throw new Exception("没有登陆");
			}
			
			if(!isset($_GET['command']) || $_GET['command'] === '')
			{
				throw new Exception('发送的指令为空');
			}
			
			$commandParser = new mc_command_parser($_GET['command']);
			$commandParser->execute();
			
			
			if($user->isAdmin())
			{
				$client = config::loadConfig('client');
				$client = reset($client);
				
				if ($client)
				{
					$Rcon = new Rcon (
						$client['rcon']['host'],
						$client['rcon']['post'],
						$client['rcon']['password'],
						$client['rcon']['time']
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