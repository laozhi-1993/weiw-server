<?php class MKH
{
	public $_initial;
    public $_Unified;
	public $_mkhdir;
    public $_Main_View;
    public function __construct($Main_View)
	{
        $this->_Unified['key']    = Array();
        $this->_Unified['value']  = Array();
        $this->_Unified['config'] = config::ini('config');
		$this->_Unified['URL']    = $GLOBALS['_MKHURL'];
		$this->_Unified['GET']    = $GLOBALS['_MKHGET'];
		$this->_Unified['POST']   = $GLOBALS['_MKHPOST'];
		$this->_Unified['head']   = $GLOBALS['_mkhhead'];
		$this->_Unified['body']   = $GLOBALS['_mkhbody'];
        $this->_Unified['index']  = $_SERVER['SCRIPT_NAME'];
        $this->_Unified['SERVER'] = $_SERVER;
		$this->_Unified['COOKIE'] = $_COOKIE;
		
		
		$this->_initial   = Array();
		$this->_mkhdir    = __MKHDIR__;
        $this->_Main_View = $Main_View;
    }


 	static function Extract_HTML($str,$element)
	{
		if(preg_match("!<{$element}.*>!Uis",$str,$text))
		{
			$str = substr_replace($str,'',0,strpos($str,$text[0])+strlen($text[0]));
			$str = substr_replace($str,'',strpos($str,"</{$element}>"));
			
			
			return $str;
		}
	}


    public function parameter($str,$f)
    {
		$cs  = array();
		$str = str_replace("'",'"',$str);
		$str = preg_replace_callback('!"(.+)"!U',function($value)
		{
			$value[1] = $this->Format_array($value[1],true,'this->_Unified');
			$value[1] = base64_encode($value[1]);
			return '"'.$value[1].'"';
		},$str);
		
		
		foreach(explode($f,$str) as $key => $value)
		{
			$value = $this->Format_array($value,false,'this->_Unified');
			$value = preg_replace_callback('!"(.+)"!U',function($a)
			{
				return '"'.base64_decode($a[1]).'"';
			},$value);
			$cs[] = $value;
		}
		
		return $cs;
    }


	public function Format_array($str,$k,$name)
	{
		return preg_replace_callback('!\[([a-z0-9-_.]+)\]!Ui',function($New_format) use ($k,$name)
		{
			$arr = "\${$name}";
			foreach(explode('.',$New_format[1]) as $value)
			{
				if(is_numeric($value))
					$arr .= "[$value]";
				else
					$arr .= "['$value']";
			}
			
			if($k)
			{
				$this->_initial[] = $arr;
				return "{{$arr}}";
			}
			else
			{
				$this->_initial[] = $arr;
				return $arr;
			}
		},$str);
	}
	
	
    public function th1(&$str)
    {
        while(preg_match('!<([a-z]+[0-9]*) +([a-z0-9_-]*)\((.*)\):[^<>]*>!Ui',$str,$mkh))
        {
            $mkh[2] = strtolower($mkh[2]);
            $route  = "{$this->_mkhdir}/method/th1_{$mkh[2]}.php";
            $s[0]   = $mkh[0];
            $s[1]   = preg_replace('! +([a-z0-9_-]*)\((.*)\):!Ui','',$mkh[0],1);
            $s_1    = substr_replace($str,'',0,strpos($str,$mkh[0]));
            $s_2    = substr_replace($str,'',0,strpos($str,$mkh[0]));

            if(file_exists($route) && is_file($route))
            {
                do
                {
                    if($g = preg_match("!.*</{$mkh[1]}.*>!Uis",$s_1,$a))
                    {
                        $b   = preg_replace("!.*(<{$mkh[1]}.*?>)!is",'$1',$a[0]);
                        $s_1 = substr_replace($s_1,'bug',strpos($s_1,$b),strlen($b));
                    }
                }
                while($g && 'bug' != substr($s_1,0,3));


                if($g)
                {
                    if(strlen($s_1) == 3)
                    {
                        $s[0] = $s_2;
                        $s[1] = substr_replace($s[0],$s[1],0,strlen($mkh[0]));
					}
                    else
                    {
                        $s[0] = substr_replace($s_2,'',-strlen($s_1)+3);
                        $s[1] = substr_replace($s[0],$s[1],0,strlen($mkh[0]));
                    }
                }


                $function = include($route);
                $s[1]     = $function($this->parameter($mkh[3],','),$s[1],$str);
            }

            $str = str_replace($s[0],$s[1],$str);
        }
		
        $str = preg_replace('!<\?php +endif; +\?>\s*<\!--else-->\s*<\?php +if\( *true *\): +\?>!Uis','<?php else: ?>',$str);
        $str = preg_replace('!<\?php +endif; +\?>\s*<\!--else-->\s*<\?php +if\((.*)\): +\?>!Uis','<?php elseif($1): ?>',$str);
    }


    public function th2(&$str)
    {
        $b = $str;
        while(preg_match('!\{([a-z0-9_-]+):(.*)\}!Ui',$b,$s))
        {
            $s[1]  = strtolower($s[1]);
            $route = "{$this->_mkhdir}/method/th2_{$s[1]}.php";
            $b     = str_ireplace($s[0],'',$b);

            if(file_exists($route) && is_file($route))
            {
                $function = include($route);
                $c        = $function($this->parameter($s[2],':'));
                $str      = str_replace($s[0],$c,$str);
            }
        }
    }


    public function mods($mods,$parameter=false)
    {
		$this->_Unified[$mods] = mods($mods,$parameter);
    }


    public function send($Template='index.frame.php')
    {
		try
		{
			if(!is_file($file_html = $this->_mkhdir.'/data/'.md5($this->_Main_View).'_'.filemtime($this->_Main_View).'.php'))
			{
				$html = file_get_contents($this->_Main_View);
				$html = preg_replace('!<\?PHP.*\?>!Uis','',$html);
				
				$this->th1($html);
				$this->th2($html);
				
				$initial = '<?php defined(\'__MKHDIR__\') or die(http_response_code(404)) ?>';
				foreach(array_unique($this->_initial) as $value)
				{
					$initial .= "<?php isset({$value}) or {$value} = false ?>";
				}
				
				file_put_contents($file_html,$initial.$html);
			}
		
		
			ob_start();
			include($file_html);
		}
		catch (error $error)
		{
			ob_get_clean();
			mkh_error::view($error->getCode(),$error->getMessage(),$error->getfile(),$error->getLine());
		}
		
		if(realpath($this->_Main_View) === realpath($_SERVER['SCRIPT_FILENAME']))
		{
			$str = ob_get_clean();
			$str = str_ireplace('<Execution-time>',sprintf('%.5f',microtime(true)-__currenttime__),$str);
			
			
			if(file_exists($Template) && is_file($Template))
			{
				if(isset($_SERVER['HTTP_LOCAL']))
				{
					$str = str_replace("\t",'',$str);
					$str = str_replace("\r",'',$str);
					$str = str_replace("\n",'',$str);
					
					$html         = Array();
					$html['head'] = self::Extract_HTML($str,'head');
					$html['body'] = self::Extract_HTML($str,'body');
					
					die(json_encode($html));
				}
				
				try
				{
					include($Template);
				}
				catch(Exception $Exception)
				{
					$aaa = $Exception->getMessage();
					$aaa = str_ireplace('<!--head-->','<mkh-head>'.self::Extract_HTML($str,'head').'</mkh-head>',$aaa);
					$aaa = str_ireplace('<!--body-->','<mkh-body>'.self::Extract_HTML($str,'body').'</mkh-body>',$aaa);
				}
				
				die($aaa);
			}
			
			die($str);
		}
		else throw new Exception(ob_get_clean());
    }
}