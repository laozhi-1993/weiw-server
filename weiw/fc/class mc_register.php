<?php class mc_register
{
	protected $blacklist;
	protected $name;
	protected $email;
	protected $password;
	protected $register_time;
	protected $login_time;
	protected $login_ip;
	protected $sign_in;
	protected $bi;
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
		
		
		$config = config('config.php');
		$this->blacklist     = false;
		$this->password      = mc_auth::random();
		$this->login_time    = time();
		$this->register_time = time();
		$this->sign_in       = 0;
		$this->bi            = $config['initial_money'];
    }

	public function name($name)
	{
		if(preg_match('!^[\x{00ff}-\x{ffff}A-Za-z0-9_-]{2,15}$!u',$name))
		{
			if(!mc::data_user(mc_auth::constructOfflinePlayerUuid($name)))
			{
				$this->name = $name;
			}
			else throw new Exception('用户已存在');
		}
		else throw new Exception('用户名不合法');
	}

	public function email($email)
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
			$user['login_ip']      = $this->login_ip;
			$user['sign_in']       = $this->sign_in;
			$user['bi']            = $this->bi;
			$user['blacklist']     = $this->blacklist;
			
			
			$token = Array();
			$token['login_token'] = $email.'_'.mc_auth::random();
			$token['accessToken'] = $email.'_'.mc_auth::random();
			$token['id']          = $email;
			$token['uuid'][]      = $uuid;
			$token['email']       = $this->email;
			$token['password']    = $this->password;
			
			
			mc::data_user ($uuid ,$user);
			mc::data_token($email,$token);
			setcookie('login_token',$token['login_token'],time()+1296000,'/');
			throw new Exception('注册完成');
		}
		else throw new Exception('缺少属性');
	}
}