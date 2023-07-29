<?php return function()
	{
		mkh_csrf::token();
		mc::admin();
		
		
		try
		{
			$config = config::ini('rcon');
			$Rcon   = new Rcon($config['host'] ,$config['post'] ,$config['pwd'] ,$config['time'] );
			if($Rcon ->connect())
			{
				$text = $Rcon->send($_GET['command']);
				$text = preg_replace('!(§[0-9a-z]?)!i','',$text);					
				
				throw new Exception($text);
			}
			else throw new Exception('无法连接到我的世界服务器');
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