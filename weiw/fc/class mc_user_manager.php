<?php class mc_user_manager
{
	private $users;
	private $userDir;
	
	
	public function __construct()
	{
		$this->users = Array();
		$this->userDir = __MKHDIR__.'/users/';
		
		if (!is_dir($this->userDir))
		{
			mkdir($this->userDir, 0777, true);
		}
	}
	
	
	public function getAllUsers()
	{
		foreach(glob("{$this->userDir}*.php") as $file)
		{
			$user = mc_user::fromJson(file_get_contents($file));
			if ($user) {
				$this->users[$user->uuid] = $user;
			}
		}
	}
	
	
	public function getUsers()
	{
		return $this->users;
	}
	
	
	public function getUserDir()
	{
		return $this->userDir;
	}
	
	
	public function getUserByName($name)
	{
		return $this->getUserByUuid(mc_user::PlayerUUID($name));
	}
	
	
	public function getUserByUuid($uuid)
	{
		if(file_exists("{$this->userDir}{$uuid}.php"))
		{
			return mc_user::fromJson(file_get_contents("{$this->userDir}{$uuid}.php"));
		}
		else
		{
			return false;
		}
	}
	
	
	public function userExists($name)
	{
		$uuid = mc_user::PlayerUUID($name);
		if(file_exists("{$this->userDir}{$uuid}.php"))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	public function addUser($name, $password)
	{
		if($this->userExists($name))
		{
			throw new Exception('用户已存在');
		}
		else
		{
			$uuid = mc_user::PlayerUUID($name);
			$money = config::loadConfig('config')['defaultMoney'];
			
			
			$user = new mc_user(
				$uuid,
				$name,
				$money,
				$password
			);
			
			if($user->saveToJson($this->getuserDir()))
			{
				return $user;
			}
			else
			{
				return false;
			}
		}
	}
}