<?php return function()
	{
		try
		{
			session_start();
			
			if(isset($_GET['type']) && $_GET['type'] == 'code')
			{
				isset($_SESSION['verification']) or throw new Exception('验证码为空请重新获取验证码');
				isset($_GET['val']) or throw new Exception('没有输入验证码');
				
				if(strtoupper($_GET['val']) != $_SESSION['verification']['code']) throw new Exception('验证码错误');
				if(time() >= $_SESSION['verification']['time']) throw new Exception('验证码已过期请重新获取');



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
					$smtp   = config::ini('smtp');
					$config = config::ini('config');
					
					
					if($smtp['server'] !== '')
					{
						include __MKHDIR__.'/PHPMailer/Exception.php';
						include __MKHDIR__.'/PHPMailer/PHPMailer.php';
						include __MKHDIR__.'/PHPMailer/SMTP.php';

						$_SESSION['verification']['email']     = strtolower($_GET['val']);
						$_SESSION['verification']['code']      = substr(str_shuffle('QWERTYUIOPASDFGHJKLZXCVBNM0123456789'),0,6);
						$_SESSION['verification']['time']      = time() + 300;
						$_SESSION['verification']['frequency'] = 0;
						
						
						$mail = new \PHPMailer\PHPMailer\PHPMailer(true);
						$mail->isSMTP();
						$mail->Host       = $smtp['server'];     // SMTP 服务器地址
						$mail->Port       = $smtp['serverport']; // SMTP 端口
						$mail->Username   = $smtp['user'];       // SMTP 用户名
						$mail->Password   = $smtp['password'];   // SMTP 密码
						$mail->SMTPAuth   = true;


						$mail->setFrom($smtp['usermail'], $config['serverName']); // 发件人地址和名称
						$mail->addAddress($_SESSION['verification']['email']);    // 收件人地址和名称


						$mail->isHTML(false);
						$mail->Subject = '验证码';                          // 邮件主题
						$mail->Body    = $_SESSION['verification']['code']; // 邮件内容
						$mail->send();
					}
					else
					{
						$_SESSION['verification']['email']     = strtolower($_GET['val']);
						$_SESSION['verification']['code']      = '123456';
						$_SESSION['verification']['time']      = time() + 300;
						$_SESSION['verification']['frequency'] = 0;
					}
					
					
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
	};