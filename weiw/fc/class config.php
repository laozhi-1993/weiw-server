<?php class config
{
	public $renew;
    public $config;
	public $config_name;
    public function __construct($name)
	{
		$this->renew = false;
		$this->config = self::ini($name);
		$this->config_name = $name;
    }
	
	public function __destruct()
	{
		if($this->renew) file_put_contents(__MKHDIR__."/config/{$this->config_name}.php",'<?php return '.var_export($this->config,true).' ?>');
	}
	
	public function set($name,$value)
	{
		if($value === false)
		{
			unset($this->config[$name]);
			$this->renew = true;
		}
		else
		{
			$this->config[$name] = $value;
			$this->renew = true;
		}
	}
	
    static function ini($name)
	{
        return include(__MKHDIR__."/config/{$name}.php");
    }
}