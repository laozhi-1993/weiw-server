<?php

class Print_Array
{
	static function Arr($a,$b = false)
	{
		$Arr = Array();

		foreach($a as $key => $value)
		{
			if(is_array($value))
			{
				$value = self::Arr($value,true);
			}
			else
			{
				$value = str_replace('\\','\\\\',$value);
				$value = str_replace('\'','\\\'',$value);
				$value = "'{$value}'";
			}

			$key = str_replace('\\','\\\\',$key);
			$key = str_replace('\'','\\\'',$key);
			$key = "'{$key}'";

			$Arr[]   = "{$key} => {$value}";
		}

		if($b)
		{
			return 'Array('.implode(',',$Arr).')';
		}

		return "<?php return Array(".implode(',',$Arr).");";
	}
}