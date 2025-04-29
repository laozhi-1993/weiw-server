<?php class mc_command_parser
{
    private $user;
    private $name;
    private $params;
	
	
    public function __construct($command)
	{
		$this->user = mc_user_authentication::getUser();
		
		if(!$this->user)
		{
			throw new Exception("没有登陆");
		}
		
		$parse = self::parse($command);
		
		if($parse)
		{
			$this->name = 'command_' . array_shift($parse);
			$this->params = $parse;
		}
    }
	
    public static function parse($input)
    {
        preg_match_all('!"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"|\'([^\'\\\\]*(?:\\\\.[^\'\\\\]*)*)\'|(\S+)!', $input, $matches);

        $result = array_map(function ($match1, $match2, $match3) {
            return stripslashes($match1 ?: $match2 ?: $match3);
        }, $matches[1], $matches[2], $matches[3]);

        return array_filter($result);
    }
	
	public function exists()
	{
		return method_exists($this, $this->name);
	}
	
    public function execute()
    {
        if ($this->exists())
		{
            call_user_func_array([$this, $this->name], $this->params);
        }
	}
	
	
	
	
	
	
	// 指令
	private function command_texture($id=10000)
	{
		try
		{
			$texture = json_decode(http::open("https://mcskin.com.cn/texture/{$id}"),true);
			
			switch ($texture['type'])
			{
				case 'steve':
				case 'alex':
					$userManager = new mc_user_manager();
					$this->user->setTexture($texture['hash'], $texture['type']);
					$this->user->saveToJson($userManager->getUserDir());
					
					throw new Exception('使用完成');
					
				default:
					throw new Exception('不支持的材质类型');
			}
		}
		catch(error $error)
		{
			throw new Exception('无法获取材质信息');
		}
		catch(Exception $Exception)
		{
			throw new Exception($Exception->getMessage());
		}
	}
	
    private function command_changepassword($old=false, $new=false, $confirm=false)
    {
		if(!$this->user->verifyPassword($old))
		{
			throw new Exception('旧密码错误');
		}
		
		if(!$this->user->validatePassword($new))
		{
			throw new Exception('新密码长度需在 8 到 30 个字符之间，并且包含至少一个小写字母、一个大写字母、一个数字和一个特殊字符');
		}
		
		if($new !== $confirm)
		{
			throw new Exception('确认新密码错误');
		}
		
		
		$userManager = new mc_user_manager();
		$this->user->setPassword($confirm);
		$this->user->saveToJson($userManager->getUserDir());
		
		
		throw new Exception('更改完成');
    }
	
    private function command_usermoney($name=false, $money=false)
    {
		if(!$this->user->isAdmin())
		{
			throw new Exception('没有权限');
		}
		
		$userManager = new mc_user_manager();
		
		if(!$userManager->userExists($name))
		{
			throw new Exception("玩家 {$name} 不存在");
		}
		
		if(!is_numeric($money))
		{
			throw new Exception('金钱不合法');
		}
		
		
		$user = $userManager->getUserByName($name);
		$user ->setMoney($user->money + $money);
		$user ->saveToJson($userManager->getUserDir());
		
		
		throw new Exception("给予{$name}增加{$money}金钱，总金钱{$user->money}。");
    }
}