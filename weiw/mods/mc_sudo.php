<?php return function ()
	{
		try
		{
			if(!$user = mc_user_authentication::getUser())
			{
				throw new Exception('没有登录');
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
			
			
			if((!isset($_GET['command'])) or (!preg_match('!^[\x{00ff}-\x{ffff}A-Za-z0-9 ]{1,255}$!u',$_GET['command'])))
			{
				throw new Exception('命令不合法');
			}
			
			
			if(in_array($user->name, $Rcon->list()['list']))
			{
				$Rcon->send("sudo {$user->name} {$_GET['command']}");
				throw new Exception('ok');
			}
			else
			{
				throw new Exception('你没有在游戏中');
			}
		}
		catch(error $error)
		{
			return Array('error' => $error->getMessage());
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};