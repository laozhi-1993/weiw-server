<?php return function()
	{
		try
		{
			session_start();
			
			if(isset($_GET['type']) && $_GET['type'] == 'code')
			{
				if(isset($_SESSION['verification']))
				{
					$config = config::ini('admin');
					
					
					if(isset($_GET['val']) && strlen($_GET['val']) >= 6 && ($_SESSION['verification']['code'] == strtoupper($_GET['val']) or $config['password'] == $_GET['val']))
					{
						if(time() <= ($_SESSION['verification']['time'] + 300))
						{
							if(mc::data_token(mc_auth::constructOfflinePlayerUuid($_SESSION['verification']['email'])))
							{
								$login = new mc_login( $_SESSION['verification']['email'] );
								$login ->verification();
							}
							else
							{
								$_SESSION['register'] = true;
								throw new Exception('register');
							}
						}
						else throw new Exception('验证码已过期请重新获取');
					}
					else throw new Exception('验证码错误');
				}
				else throw new Exception('验证码为空请重新获取验证码');
			}
			
			
			if(isset($_GET['type']) && $_GET['type'] == 'register')
			{
				if(isset($_SESSION['register']) && $_SESSION['register'] === true)
				{
					$register = new mc_register( $_SESSION['verification']['email'], $_GET['val'] );
					$register ->preservation();
				}
				else throw new Exception('没有通过身份验证');
			}
			
			
			if(isset($_GET['type']) && $_GET['type'] == 'email')
			{
				if(preg_match('!^[0-9a-zA-Z_-]+@([0-9a-zA-Z]+[.])+[a-zA-Z]{2,4}$!',$_GET['val']))
				{
					$smtp       = config::ini('smtp'); //导入smtp配置文件
					$server     = $smtp['server'];     //SMTP服务器
					$serverport = $smtp['serverport']; //SMTP服务器端口
					$usermail   = $smtp['usermail'];   //SMTP服务器的用户邮箱
					$user       = $smtp['user'];       //SMTP服务器的用户帐号
					$password   = $smtp['password'];   //SMTP服务器的用户密码		
					
					
					$_SESSION['verification']['email']     = strtolower($_GET['val']);
					$_SESSION['verification']['code']      = substr(str_shuffle('QWERTYUIOPASDFGHJKLZXCVBNM0123456789'),0,6);
					$_SESSION['verification']['time']      = time();
					$_SESSION['verification']['frequency'] = 0;
					
					
					$smtp = new Smtp($server,$serverport,true,$user,$password);  //这里面的一个true是表示使用身份验证,否则不使用身份验证.
					$smtp ->debug = false; //是否显示发送的调试信息
					$smtp ->sendmail($_SESSION['verification']['email'], $usermail, '验证码', $_SESSION['verification']['code'], 'TXT');
					throw new Exception('code');
				}
				else throw new Exception('邮箱格式不正确');
			}
			
			
			throw new Exception('缺少必要参数');
		}
		catch(Exception $Exception)
		{
			if($Exception->getMessage() == '登录完成')
			{
				unset($_SESSION['verification']);
				return Array('error' => 'ok');
			}
			
			if($Exception->getMessage() == '注册完成')
			{
				unset($_SESSION['verification']);
				unset($_SESSION['register']);
				return Array('error' => 'ok');
			}
			
			
			return Array('error' => $Exception->getMessage());
		}
		catch(error $error)
		{
			return Array('error' => 'code');
		}
	};