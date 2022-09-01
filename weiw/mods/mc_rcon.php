<?php return function()
	{
		mkh_csrf::token();
		
		
		try
		{
			if(mc::admin())
			{
				$ini  = config('rcon.php');
				$Rcon = new Rcon($ini['host'] ,$ini['post'] ,$ini['pwd'] ,$ini['time'] );
				if($Rcon ->connect())
				{
					$text = $Rcon->send($_GET['command']);
					$text = preg_replace('!(§[0-9a-z]?)!i','',$text);
					$text = nl2br($text);
					
					
					throw new Exception($text);
				}
				else throw new Exception('无法连接到我的世界服务器');
			}
			else throw new Exception('没有权限');
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