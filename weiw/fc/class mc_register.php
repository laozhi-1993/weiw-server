<?php class mc_register
{
	protected $name;
	protected $email;
	protected $register_time;
	protected $login_time;
	protected $sign_in;
	protected $bi;
    public function __construct( $email, $name )
	{
		if(preg_match('!^[0-9a-zA-Z_-]+@([0-9a-zA-Z]+[.])+[a-zA-Z]{2,4}$!',$email) && strlen($email) <= 60)
		{
			if(!mc::data_token(mc_auth::constructOfflinePlayerUuid($email)))
			{
				$this->email = $email;
			}
			else throw new Exception('邮箱已存在');
		}
		else throw new Exception('邮箱格式不正确');
		
		
		if(preg_match('!^[\x{00ff}-\x{ffff}A-Za-z0-9_-]{2,15}$!u',$name))
		{
			if(!mc::data_user(mc_auth::constructOfflinePlayerUuid($name)))
			{
				$this->name = $name;
			}
			else throw new Exception('用户已存在');
		}
		else throw new Exception('用户名不合法');
		
		
		
		
		$config = config::ini('config');
		$this->login_time    = time();
		$this->register_time = time();
		$this->sign_in       = 0;
		$this->bi            = $config['initial_money'];
    }
	
	public function preservation()
	{
		if(isset($this->email) && isset($this->name))
		{
			$uuid  = mc_auth::constructOfflinePlayerUuid($this->name);
			$email = mc_auth::constructOfflinePlayerUuid($this->email);
			$user  = Array();
			$user['id']            = $uuid;
			$user['name']          = $this->name;
			$user['email']         = $this->email;
			$user['register_time'] = $this->register_time;
			$user['login_time']    = $this->login_time;
			$user['sign_in']       = $this->sign_in;
			$user['bi']            = $this->bi;
			
			
			$token = Array();
			$token['login_token'] = $email.'_'.mc_auth::random();
			$token['accessToken'] = $email.'_'.mc_auth::random();
			$token['id']          = $email;
			$token['uuid'][]      = $uuid;
			$token['email']       = $this->email;
			
			
			mc::data_user ($uuid ,$user);
			mc::data_token($email,$token);
			setcookie('login_token',$token['login_token'],time()+1296000,'/');
		}
		else throw new Exception('缺少属性');
	}
}