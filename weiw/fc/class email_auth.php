<?php class email_auth
{
	public $email     = 0;
	public $timeout   = 0;
	public $frequency = 0;
	
	public function __construct()
	{
		if (session_status() == PHP_SESSION_NONE){
			session_start();
		}
	}
	
	public function email()
	{
		return strtolower($this->email);
	}
	
	public function code()
	{
		return substr(str_shuffle('QWERTYUIOPASDFGHJKLZXCVBNM0123456789'),0,6);
	}
	
	public function timeout()
	{
		if(!is_numeric($this->timeout))
		{
			return 0;
		}
		
		
		if($this->timeout === 0)
		{
			return 0;
		}
		else
		{
			return time() + $this->timeout;
		}
	}
	
	public function send()
	{
		if(!preg_match('!^[0-9a-zA-Z_-]+@([0-9a-zA-Z]+[.])+[a-zA-Z]{2,4}$!',$this->email))
		{
			throw new Exception('邮箱格式不正确');
		}
		
		
		$smtp   = config::ini('smtp');
		$config = config::ini('config');
		
		
		if($smtp['server'] !== '')
		{
			include_once __MKHDIR__.'/PHPMailer/Exception.php';
			include_once __MKHDIR__.'/PHPMailer/PHPMailer.php';
			include_once __MKHDIR__.'/PHPMailer/SMTP.php';

			$_SESSION['code']['email']     = $this->email();
			$_SESSION['code']['time']      = $this->timeout();
			$_SESSION['code']['code']      = $this->code();
			$_SESSION['code']['frequency'] = 0;
			$_SESSION['code']['auth']      = false;
			
			
			$mail = new \PHPMailer\PHPMailer\PHPMailer(true);
			$mail->isSMTP();
			$mail->Host     = $smtp['server'];     // SMTP 服务器地址
			$mail->Port     = $smtp['serverport']; // SMTP 端口
			$mail->Username = $smtp['user'];       // SMTP 用户名
			$mail->Password = $smtp['password'];   // SMTP 密码
			$mail->SMTPAuth = true;
			$mail->CharSet  = 'UTF-8';


			$mail->setFrom($smtp['usermail'], $config['serverName']); // 发件人地址和名称
			$mail->addAddress($_SESSION['code']['email']);            // 收件人地址和名称


			$mail->isHTML(false);
			$mail->Subject = '验证码';                  // 邮件主题
			$mail->Body    = $_SESSION['code']['code']; // 邮件内容
			$mail->send();
		}
		else
		{
			$_SESSION['code']['email']     = $this->email();
			$_SESSION['code']['time']      = $this->timeout();
			$_SESSION['code']['code']      = '123456';
			$_SESSION['code']['frequency'] = 0;
			$_SESSION['code']['auth']      = false;
		}
	}
	
	public static function data()
	{
		if (session_status() == PHP_SESSION_NONE){
			session_start();
		}
		
		
		if(isset($_SESSION['code']))
		{
			return $_SESSION['code'];
		}
		else
		{
			throw new Exception('数据为空');
		}
	}
	
	public static function auth($code)
	{
		if (session_status() == PHP_SESSION_NONE){
			session_start();
		}
		
		
		if(!isset($_SESSION['code']))
		{
			throw new Exception('没有获取验证码');
		}
		
		if(strtoupper($code) != $_SESSION['code']['code'])
		{
			throw new Exception('验证码错误');
		}
		
		if($_SESSION['code']['time'] != 0)
		{
			if(time() >= $_SESSION['code']['time'])
			{
				throw new Exception('验证码已过期请重新获取');
			}
		}
		
		$_SESSION['code']['auth'] = true;
	}
	
	public static function isauth()
	{
		if (session_status() == PHP_SESSION_NONE){
			session_start();
		}
		
		
		if(!isset($_SESSION['code']))
		{
			throw new Exception('没有通过身份验证');
		}
		
		if($_SESSION['code']['auth'] == false)
		{
			throw new Exception('没有通过身份验证');
		}
	}
	
	public static function unauth()
	{
		if (session_status() == PHP_SESSION_NONE){
			session_start();
		}
		
		
		unset($_SESSION['code']);
	}
}