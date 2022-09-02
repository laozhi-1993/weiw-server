<?php class mc_login
{
	protected $email;
	protected $login_time;
	protected $login_ip;
    public function __construct()
	{
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$ip = explode(', ',$_SERVER['HTTP_X_FORWARDED_FOR']);
			$this->login_ip = end($ip);
		}
		else
		{
			$this->login_ip = $_SERVER['REMOTE_ADDR'];
		}
		
		
		$this->login_time = time();
    }
	
	public function email($email)
	{
		if(mc::data_token(mc_auth::constructOfflinePlayerUuid($email)))
		{
			$this->email = $email;
		}
		else throw new Exception('用户不存在');
	}
	
	public function verification()
	{
		if(isset($this->email))
		{
			$random = mc_auth::random();
			$email  = mc_auth::constructOfflinePlayerUuid($this->email);
			$token  = mc::data_token($email);
			$user   = mc::data_user ($token['uuid'][0]);
			
			if(isset($token['login_token']) === false)
			{
				$token['login_token'] = "{$email}_{$random}";
			}
			
			if(isset($token['accessToken']) === false)
			{
				$token['accessToken'] = "{$email}_{$random}";
			}
			
			$user['login_time'] = $this->login_time;
			$user['login_ip']   = $this->login_ip;
			
			mc::data_user ($token['uuid'][0],$user);
			mc::data_token($email,$token);
			setcookie('login_token',$token['login_token'],time()+1296000,'/');
			throw new Exception('登录完成');
		}
		else throw new Exception('缺少属性');
	}
}