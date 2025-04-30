<?php class mc_user
{
    private $uuid;              // 用户的唯一标识符
    private $name;              // 用户名
    private $money;             // 用户的金钱数额
    private $password;          // 用户的加密密码
    private $loginTime;         // 用户最近一次登录时间戳
    private $registerTime;      // 用户注册时间戳
    private $checkinTime;       // 用户最近一次签到时间戳
    private $isAllowedLogin;    // 用户是否被允许登录的标志
    private $CAPE;              // 用户的披风信息
    private $SKIN;              // 用户的皮肤信息
    private $loginToken;        // 用户的登录令牌
    private $accessToken;       // 用户的访问令牌
    
    /**
     * 构造函数，初始化用户对象
     *
     * @param string $uuid 用户的唯一标识符
     * @param string $name 用户名
     * @param int $money 用户的金钱数额
     * @param string $password 用户的密码（未加密）
     */
    public function __construct($uuid, $name, $money, $password)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->money = $money;
        
        $this->setPassword($password);
        $this->setLoginTime();
        $this->setRegisterTime();
        $this->setCheckinTime();
        $this->setIsAllowedLogin();
        $this->setLoginToken();
        $this->setAccessToken();
        $this->setTexture('', 'steve');
        $this->setTexture('', 'cape');
    }
    
    //Setter 方法
    
    /**
     * 设置用户的金钱数额
     *
     * @param int $money 新的金钱数额
     */
    public function setMoney($money)
    {
        $this->money = $money;
    }
    
    /**
     * 设置用户的密码，并进行加密处理
     *
     * @param string $password 用户的密码（未加密）
     */
    public function setPassword($password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->password = $hashedPassword;
    }
    
    /**
     * 设置用户的登录时间为当前时间戳
     */
    public function setLoginTime()
    {
        $this->loginTime = time();
    }
    
    /**
     * 设置用户的注册时间为当前时间戳
     */
    public function setRegisterTime()
    {
        $this->registerTime = time();
    }
    
    /**
     * 设置用户的签到时间为当前时间戳
     */
    public function setCheckinTime()
    {
        $this->checkinTime = time();
    }
    
    /**
     * 设置用户是否被允许登录的标志
     *
     * @param bool $allowedLogin 是否允许用户登录，默认为 true
     */
    public function setIsAllowedLogin($allowedLogin = true)
    {
        $this->isAllowedLogin = $allowedLogin;
    }
    
	/**
	 * 设置用户的材质信息
	 *
	 * @param string $hash 材质的哈希值
	 * @param string $model 材质的模型类型，支持 'steve'、'alex' 和 'cape' 三种类型
	 * 
	 * @return bool 返回布尔值，表示操作是否成功
	 */
	public function setTexture($hash, $model)
	{
		switch ($model)
		{
			case 'steve':
				if($hash == '')
				{
					$this->SKIN['hash'] = 'steve';
					$this->SKIN['model'] = 'default';
				}
				else
				{
					$this->SKIN['hash'] = $hash;
					$this->SKIN['model'] = 'default';
				}
				
				return true;

			case 'alex':
				if($hash == '')
				{
					$this->SKIN['hash'] = 'alex';
					$this->SKIN['model'] = 'slim';
				}
				else
				{
					$this->SKIN['hash'] = $hash;
					$this->SKIN['model'] = 'slim';
				}
				
				return true;

			case 'cape':
				if($hash == '')
				{
					$this->CAPE['hash'] = 'cape';
				}
				else
				{
					$this->CAPE['hash'] = $hash;
				}
				
				return true;

			default:
				return false; // 未知的模型类型，返回 false
		}
	}
    
    /**
     * 设置用户的登录令牌，使用随机生成的字节序列
     */
    public function setLoginToken()
    {
        $this->loginToken = bin2hex(random_bytes(32));
    }
    
    /**
     * 设置用户的访问令牌，使用随机生成的字节序列
     */
    public function setAccessToken()
    {
        $this->accessToken = bin2hex(random_bytes(32));
    }
    
    //Getter 方法
    
    /**
     * 魔术方法，用于动态获取类的私有属性。
     *
     * @param string $name 属性名
     * @return mixed 属性值，如果属性不存在则返回 null
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        } else {
            return NULL;
        }
    }
    
    /**
     * 将用户对象的属性转换为数组形式
     *
     * @return array 包含用户属性的关联数组
     */
    public function toArray()
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'money' => $this->money,
            'password' => $this->password,
            'loginTime' => $this->loginTime,
            'registerTime' => $this->registerTime,
            'checkinTime' => $this->checkinTime,
            'isAllowedLogin' => $this->isAllowedLogin,
            'CAPE' => $this->CAPE,
            'SKIN' => $this->SKIN,
            'loginToken' => $this->loginToken,
            'accessToken' => $this->accessToken
        ];
    }
    
    /**
     * 将用户对象的属性保存为 JSON 格式，并写入文件
     *
     * @param string $nameDir 文件保存目录
     * @return bool 如果保存成功则返回 true，否则返回 false
     */
    public function saveToJson($nameDir)
    {
        $userData = $this->toArray();
        $jsonStr = json_encode($userData);
        
        if (file_put_contents("{$nameDir}{$userData['uuid']}.php", "<?php die ?>{$jsonStr}")) {
            return true;
        } else {
            return false;
        }
    }
    
    //验证方法
    
    /**
     * 验证用户输入的密码是否与存储的加密密码匹配
     *
     * @param string $password 待验证的密码
     * @return bool 如果密码匹配则返回 true，否则返回 false
     */
    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }
    
    /**
     * 验证用户是否为管理员
     *
     * @return bool 如果用户是管理员则返回 true，否则返回 false
     */
    public function isAdmin()
    {
        return in_array($this->name, config::loadConfig('admin'));
    }
    
    //静态验证方法
    
    /**
     * 静态方法：验证用户名是否合法
     *
     * @param string $name 待验证的用户名
     * @return bool 如果用户名合法则返回 true，否则返回 false
     */
    public static function validateName($name)
    {
        return preg_match('!^[\x{00ff}-\x{ffff}A-Za-z0-9_-]{2,15}$!u', $name);
    }
    
    /**
     * 静态方法：验证密码是否合法
     *
     * 密码必须包含至少一个小写字母、一个大写字母、一个数字和一个特殊字符，
     * 长度在 8 到 30 个字符之间。
     *
     * @param string $password 待验证的密码
     * @return bool 如果密码合法则返回 true，否则返回 false
     */
    public static function validatePassword($password)
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]{8,30}$/', $password);
    }
    
    /**
     * 静态方法：从 JSON 字符串中创建 mc_user 对象
     *
     * @param string $jsonString 包含用户信息的 JSON 字符串
     * @return mc_user 创建的 mc_user 对象
     * @throws Exception 如果 JSON 格式无效时抛出异常
     */
    public static function fromJson($jsonString)
    {
        $data = json_decode(substr_replace($jsonString, '', 0, 12), true);
        
        if (!$data) {
            throw new Exception('不是有效的 JSON 格式');
        }
        
        $user = new self(
            $data['uuid'],
            $data['name'],
            $data['money'],
            $data['password']
        );
        
        $user->password = $data['password'];
        $user->loginTime = $data['loginTime'];
        $user->registerTime = $data['registerTime'];
        $user->checkinTime = $data['checkinTime'];
        $user->isAllowedLogin = $data['isAllowedLogin'];
        $user->CAPE = $data['CAPE'];
        $user->SKIN = $data['SKIN'];
        $user->loginToken = $data['loginToken'];
        $user->accessToken = $data['accessToken'];
        
        return $user;
    }
    
    /**
     * 静态方法：使用用户名生成 UUID
     *
     * @param string $username 用户名
     * @return string 生成的 UUID
     */
    public static function PlayerUUID($username)
    {
        $data = hex2bin(md5("OfflinePlayer:" . strtolower($username)));
        $data[6] = chr(ord($data[6]) & 0x0f | 0x30);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return bin2hex($data);
    }
}