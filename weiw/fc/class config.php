<?php 

/**
 * 配置管理类
 * 
 * 用于动态加载、修改和保存PHP配置文件
 * 支持键值增删改查及键顺序调整功能
 */
class Config
{
	/**
	 * 当前加载的配置数组
	 * @var array
	 */
	private $config;
	
	/**
	 * 当前配置文件名（不含扩展名）
	 * @var string
	 */
	private $configName;

	/**
	 * 构造函数
	 * 
	 * @param string $name 配置文件名（不含.php扩展名）
	 * @throws Exception 当配置文件不存在时抛出异常
	 */
	public function __construct($name)
	{
		$this->config = self::loadConfig($name);
		$this->configName = $name;
	}
	
	/**
	 * 析构函数
	 * 
	 * 对象销毁时自动保存当前配置到文件
	 */
	public function __destruct()
	{
		// 将配置数组转换为PHP文件内容
		file_put_contents(
			__MKHDIR__."/config/{$this->configName}.php",
			'<?php return '.var_export($this->config, true).'; ?>'
		);
	}
	
	/**
	 * 检查配置键是否存在
	 * 
	 * @param string $key 要检查的键名
	 * @return bool 存在返回true，否则返回false
	 */
	public function keyExists($key)
	{
		return array_key_exists($key, $this->config);
	}
	
	/**
	 * 设置配置值
	 * 
	 * @param string $name 配置键名
	 * @param mixed $value 配置值
	 */
	public function setValue($name, $value)
	{
		$this->config[$name] = $value;
	}
	
	/**
	 * 获取配置值
	 * 
	 * @param string $name 配置键名
	 * @return mixed 对应的配置值
	 * @throws Exception 当键不存在时抛出异常
	 */
	public function getValue($name)
	{
		return $this->config[$name];
	}
	
	/**
	 * 删除配置项
	 * 
	 * @param string $name 要删除的配置键名
	 */
	public function deleteValue($name)
	{
		if (array_key_exists($name, $this->config)) {
			unset($this->config[$name]);
		}
	}
	
	/**
	 * 移动配置键到指定位置
	 * 
	 * @param string $key 要移动的键名
	 * @param int $position 目标位置（从0开始）
	 * @return bool 成功返回true，键不存在返回false
	 */
	public function moveKeyToPosition($key, $position)
	{
		// 检查键是否存在
		if (!array_key_exists($key, $this->config)) {
			return false;
		}
		
		// 提取所有键并处理位置
		$keys = array_keys($this->config);
		$currentIndex = array_search($key, $keys, true);
		
		// 移除当前键
		array_splice($keys, $currentIndex, 1);
		
		// 插入到目标位置
		array_splice($keys, $position, 0, $key);
		
		// 按新顺序重建数组
		$result = [];
		foreach ($keys as $k) {
			$result[$k] = $this->config[$k];
		}
		
		$this->config = $result;
		
		return true;
	}
	
	/**
	 * 静态方法加载配置文件
	 * 
	 * @param string $name 配置文件名（不含.php扩展名）
	 * @return array 加载的配置数组
	 * @throws Exception 当配置文件不存在时抛出异常
	 */
	public static function loadConfig($name)
	{
		$filePath = __MKHDIR__."/config/{$name}.php";
		if (!file_exists($filePath)) {
			throw new Exception("配置文件 {$name}.php 不存在");
		}
		return include($filePath);
	}
}