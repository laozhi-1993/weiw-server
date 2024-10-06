<?php class MKH
{
    private $Unified = Array();
	private $data = Array();
	private $htmlStr = Null;
	
	
    public function __construct()
	{
        $this->Unified['config'] = config::loadConfig('config');
        $this->Unified['SERVER'] = $_SERVER;
        $this->Unified['index']  = $_SERVER['SCRIPT_NAME'];
		
		
		foreach($_GET  as $key => $value) $this->Unified['GET'] [$key] = nl2br(htmlspecialchars($value));
		foreach($_POST as $key => $value) $this->Unified['POST'][$key] = nl2br(htmlspecialchars($value));
		
		ob_start();
    }
	
	
    public function toUnified(&$var)
    {
		if($var && preg_match('!^(\s*)((?:var)(?:[.][A-Z0-9_-]+)+)(\s*)$!i',$var,$capture))
		{
			foreach(explode('.',$capture[2]) as $key=>$value)
			{
				if($key === 0)
				{
					$var = '$this->Unified';
				}
				else
				{
					if(is_numeric($value))
					{
						$var .= "[ {$value} ]";
					}
					else
					{
						$var .= "['{$value}']";
					}
				}
			}
			
			
			return true;
		}
		else
		{
			return false;
		}
    }
	
	
    public function mods($modsName)
    {
		if(is_file($route = __MKHDIR__."/mods/{$modsName}.php"))
		{
			try
			{
				$mods = include($route);
				$this->Unified[$modsName] = $mods($this);
			}
			catch (Error $error)
			{
				mkh_error::view($error->getCode(),$error->getMessage(),$error->getfile(),$error->getLine());
			}
		}
		else mkh_error::warning("Mods \"{$modsName}\" not exist");
    }
	
	
	public function thetop($text)
	{
		$this->htmlStr = $text.$this->htmlStr;
	}
	
	
	public function conditionalBranching()
	{
		$this->htmlStr = preg_replace('#<\?php endif; \?>(\s*)<!--else-->(\s*)<\?php if\(true\): \?>#Us','<?php else: ?>',$this->htmlStr);
		$this->htmlStr = preg_replace('#<\?php endif; \?>(\s*)<!--else-->(\s*)<\?php if\((.*\(.*\))\): \?>#Us','<?php elseif($3): ?>',$this->htmlStr);
	}
	
	
    public function th1()
    {
        while(preg_match('!<([A-Z]+[0-9]*)( +)([A-Z0-9_-]*)\((.*)\)([^<>]*)>!Ui',$this->htmlStr,$tagsData))
        {
            $s[0]   = $tagsData[0];
            $s[1]   = preg_replace('!( +)([A-Z0-9_-]*)\((.*)\)!Ui','',$tagsData[0],1);
            $s_1    = substr_replace($this->htmlStr,'',0,strpos($this->htmlStr,$tagsData[0]));
            $s_2    = substr_replace($this->htmlStr,'',0,strpos($this->htmlStr,$tagsData[0]));

            if(method_exists('mkh_method',"th1_{$tagsData[3]}"))
            {
                do
                {
                    if($g = preg_match("!.*</{$tagsData[1]}.*>!Uis",$s_1,$a))
                    {
                        $b   = preg_replace("!.*(<{$tagsData[1]}.*?>)!is",'$1',$a[0]);
                        $s_1 = substr_replace($s_1,'bug',strpos($s_1,$b),strlen($b));
                    }
                }
                while($g && 'bug' != substr($s_1,0,3));


                if($g)
                {
                    if(strlen($s_1) == 3)
                    {
                        $s[0] = $s_2;
                        $s[1] = substr_replace($s[0],$s[1],0,strlen($tagsData[0]));
					}
                    else
                    {
                        $s[0] = substr_replace($s_2,'',-strlen($s_1)+3);
                        $s[1] = substr_replace($s[0],$s[1],0,strlen($tagsData[0]));
                    }
                }


				$function = "th1_{$tagsData[3]}";
                $return = mkh_method::$function(explode(',',$tagsData[4]),$s[1],$this);
            }

			if($s[1])
			{
				$this->htmlStr = str_replace($s[0],$return,$this->htmlStr);
			}
			else
			{
				$this->htmlStr = str_replace($s[0],'',$this->htmlStr);
			}
        }
    }
	
	
    public function th2()
    {
		$callback = function($matches)
		{
            if(method_exists('mkh_method',"th2_{$matches[1]}"))
            {
                $function = "th2_{$matches[1]}";
                $return = mkh_method::$function(explode(':',$matches[2]),$this);
				
				
				return $return;
            }
			else
			{
				return $matches[0];
			}
		};
		
		
		$this->htmlStr = preg_replace_callback('!{([A-Z0-9_-]+):(.*)}!Ui',$callback,$this->htmlStr);
    }
	
	
    public function __destruct()
    {
		try
		{
			$this->htmlStr = ob_get_clean();
			$filePath = __MKHDIR__.'/data/'.md5($this->htmlStr).'.php';
			$callback = function($buffer)
			{
				if(isset($_GET['findId']))
				{
					libxml_use_internal_errors(true);
					$dom = new DOMDocument();
					$dom->loadHTML('<?xml encoding="UTF-8">' . $buffer);
					return $dom->saveHTML($dom->getElementById($_GET['findId']));
				}
				else
				{
					return $buffer;
				}
			};
			
			
			if(!is_file($filePath))
			{
				$this->th1();
				$this->th2();
				$this->thetop('<?php defined(\'__MKHDIR__\') or die(http_response_code(403)) ?>');
				$this->conditionalBranching();
				
				file_put_contents($filePath,$this->htmlStr);
			}
			
			
			ob_start($callback);
			include($filePath);
		}
		catch (error $error)
		{
			ob_end_clean();
			ob_start();
			mkh_error::view(
				$error->getCode(),
				$error->getMessage(),
				$error->getfile(),
				$error->getLine()
			);
		}
    }
}