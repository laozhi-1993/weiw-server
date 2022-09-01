<?php return function()
	{
		mkh_csrf::token();
		
		
		try
		{
			if($user = mc::user())
			{
				$ini  = config('rcon.php');
				$Rcon = new Rcon($ini['host'] ,$ini['post'] ,$ini['pwd'] ,$ini['time'] );
				if($Rcon ->connect())
				{
					if(isset($_GET['command']) && preg_match('!^[\x{00ff}-\x{ffff}A-Za-z0-9 :]{1,255}$!u',$_GET['command']))
					{
						$list = $Rcon->list();
						if(in_array($user['name'],$list['list']))
						{
							$Rcon->send("sudo {$user['name']} {$_GET['command']}");
							throw new Exception('ok');
						}
						else
						{
							throw new Exception('你没有在游戏中');
						}
					}
					else throw new Exception('命令不合法');
				}
				else throw new Exception('无法连接到我的世界服务器');
			}
			else throw new Exception('没有登录');
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