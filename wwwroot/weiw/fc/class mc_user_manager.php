<?php class mc_user_manager
{
	private $userDir;
	public function __construct()
	{
		$this->userDir = dirname(dirname(__MKHDIR__)) . DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR;
		
		if (!is_dir($this->userDir))
		{
			mkdir($this->userDir, 0777, true);
		}
	}
	
	
	public function getAllUsers()
	{
		$users = [];
		$files = glob("{$this->userDir}*.json");
		
		foreach ($files as $file)
		{
			$pathinfo = pathinfo($file);
			$user = $this->getUserByUuid($pathinfo['filename']);
			if ($user) {
				$users[] = $user;
			}
		}
		
		return $users;
	}
	
	
	public function getUsers($page = 1, $pageSize = 20)
	{
		$arrayPaginate = function($array, $page, $pageSize)
		{
			// 参数验证
			$page = max(1, intval($page));
			$pageSize = max(1, intval($pageSize));
			
			// 计算分页信息
			$total = count($array);
			$totalPages = ceil($total / $pageSize);
			
			// 计算起始位置
			$offset = ($page - 1) * $pageSize;
			
			// 获取当前页数据
			$currentPageData = array_slice($array, $offset, $pageSize);
			
			// 返回分页结果
			return [
				'data' => $currentPageData,
				'current_page' => $page,
				'page_size' => $pageSize,
				'total' => $total,
				'total_pages' => $totalPages,
			];
		};
		
		$users = [];
		$files = glob("{$this->userDir}*.json");
		$paginate = $arrayPaginate($files, $page, $pageSize);
		
		foreach ($paginate['data'] as $file)
		{
			$pathinfo = pathinfo($file);
			$user = $this->getUserByUuid($pathinfo['filename']);
			if ($user) {
				$users[] = $user;
			}
		}
		
		$paginate['data'] = $users;
		return $paginate;
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
		if(!file_exists("{$this->userDir}{$uuid}.json"))
		{
			return false;
		}
		
		$data = json_decode(file_get_contents("{$this->userDir}{$uuid}.json"), true);
		if (json_last_error() !== JSON_ERROR_NONE)
		{
			return false;
		}
		
		
		$user = new mc_user(
			$data['uuid'],
			$data['name'],
			$data['money'],
		);
		
		$user->password       = $data['password'];
		$user->loginTime      = $data['loginTime'];
		$user->registerTime   = $data['registerTime'];
		$user->checkinTime    = $data['checkinTime'];
		$user->isAllowedLogin = $data['isAllowedLogin'];
		$user->CAPE           = $data['CAPE'];
		$user->SKIN           = $data['SKIN'];
		$user->loginToken     = $data['loginToken'];
		$user->accessToken    = $data['accessToken'];
		
		return $user;
	}
	
	
	public function userExists($name)
	{
		$uuid = mc_user::PlayerUUID($name);
		if(file_exists("{$this->userDir}{$uuid}.json") && is_file("{$this->userDir}{$uuid}.json"))
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
			return false;
		}
		
		$uuid = mc_user::PlayerUUID($name);
		$money = config::loadConfig('config')['defaultMoney'];
		
		
		$user = new mc_user(
			$uuid,
			$name,
			$money,
		);
		
		$user->setPassword($password);
		$user->setLoginTime();
		$user->setRegisterTime();
		$user->setCheckinTime();
		$user->setIsAllowedLogin();
		$user->setLoginToken();
		$user->setAccessToken();
		$user->setTexture('', 'steve');
		$user->setTexture('', 'cape');

		if($this->saveToFile($user))
		{
			return $user;
		}
		else
		{
			return false;
		}
	}
	
	public function saveToFile(mc_user $user)
	{
        $userData = $user->toArray();
        $jsonStr = json_encode($userData);
        
		return file_put_contents("{$this->userDir}{$userData['uuid']}.json", $jsonStr);
	}
}