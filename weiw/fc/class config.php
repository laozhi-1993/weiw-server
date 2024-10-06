<?php class config
{
    private $config;
	private $configName;
    public function __construct($name)
	{
		$this->config = self::loadConfig($name);
		$this->configName = $name;
    }
	
	public function __destruct()
	{
		file_put_contents(__MKHDIR__."/config/{$this->configName}.php",'<?php return '.var_export($this->config,true).' ?>');
	}
	
	public function setValue($name,$value)
	{
		$this->config[$name] = $value;
	}
	
	public function getValue($name)
	{
		return $this->config[$name];
	}
	
    public function deleteValue($name)
    {
        if (array_key_exists($name, $this->config)) {
            unset($this->config[$name]);
        }
    }

    public static function loadConfig($name)
	{
        return include(__MKHDIR__."/config/{$name}.php");
    }
}