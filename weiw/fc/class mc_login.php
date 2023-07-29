<?php class mc_login
{
	protected $email;
	protected $login_time;
    public function __construct( $email )
	{
		if(mc::data_token(mc_auth::constructOfflinePlayerUuid($email)))
		{
			$this->email = $email;
		}
		else throw new Exception('用户不存在');
		
		
		$this->login_time = time();
    }
	
	public function verification()
	{
		if(isset($this->email))
		{
			$random1 = mc_auth::random();
			$random2 = mc_auth::random();
			$email   = mc_auth::constructOfflinePlayerUuid($this->email);
			$token   = mc::data_token($email);
			$user    = mc::data_user ($token['uuid'][0]);
			$user['login_time'] = $this->login_time;
			
			
			if(isset($token['login_token']) === false)
			{
				$token['login_token'] = "{$email}_{$random1}";
			}
			
			if(isset($token['accessToken']) === false)
			{
				$token['accessToken'] = "{$email}_{$random2}";
			}
			
			
			mc::data_user ($token['uuid'][0],$user);
			mc::data_token($email,$token);
			setcookie('login_token',$token['login_token'],time()+1296000,'/');
			throw new Exception('登录完成');
		}
		else throw new Exception('缺少属性');
	}
}