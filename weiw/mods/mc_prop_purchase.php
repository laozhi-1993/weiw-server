<?php return function()
	{
		mkh_csrf::token();
		
		
		try
		{
			if($user = mc::user())
			{
				$config = config::ini('rcon');
				$prop   = json_decode(config::ini('prop'),true);
				$Rcon   = new Rcon($config['host'] ,$config['post'] ,$config['pwd'] ,$config['time'] );
				if($Rcon ->connect())
				{
					if(isset($_GET['id']) && isset($prop[$_GET['id']]))
					{
						if(isset($prop[$_GET['id']]['price']) && $prop[$_GET['id']]['price'] <= $user['bi'])
						{
							$list = $Rcon->list();
							if(in_array($user['name'],$list['list']))
							{
								$text = $Rcon->send(str_ireplace('{name}',$user['name'],$prop[$_GET['id']]['command']));
								$text = preg_replace('!(§[0-9a-z]?)!i','',$text);
								$text = nl2br($text);
								
								
								$data_user       = mc::data_user($user['id']);
								$data_user['bi'] = $user['bi'] - $prop[$_GET['id']]['price'];
								mc::data_user($user['id'],$data_user);
								return Array('error' => $text,'bi' => $data_user['bi']);
							}
							else throw new Exception('你不在游戏中无法购买');
						}
						else throw new Exception('你的金币不够');
					}
					else throw new Exception('道具不存在');
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