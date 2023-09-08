<?php return function()
	{
		mkh_csrf::token();
		mc::admin();
		
		
		try
		{
			if(isset($_GET['command']))
			{
				$command = explode(' ', $_GET['command']);
				if($command[0] == 'usermoney')
				{
					isset($command[1]) or throw new Exception('缺少参数1');
					isset($command[2]) or throw new Exception('缺少参数2');
					
					if(is_numeric($command[2]))
					{
						$money = mc::money(mc_auth::constructOfflinePlayerUuid($command[1]), $command[2]);
						throw new Exception("给予{$command[1]}增加{$command[2]}金钱，总金钱{$money}。");
					}
					else
					{
						throw new Exception('金钱不合法');
					}
				}
				
				
				$config = config::ini('rcon');
				$Rcon   = new Rcon($config['host'] ,$config['post'] ,$config['pwd'] ,$config['time'] );
				if($Rcon ->connect())
				{
					$text = $Rcon->send($_GET['command']);
					$text = preg_replace('!(§[0-9a-z]?)!i','',$text);					
					
					throw new Exception($text);
				}
				
				throw new Exception('无法连接到我的世界服务器');
			}
			
			throw new Exception('缺少command参数');
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