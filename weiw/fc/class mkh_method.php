<?php class mkh_method
{
	public static function th1_foreach($parameter,$html,$target)
	{
		if($target->toUnified($parameter[0]) && $target->toUnified($parameter[1]) && $target->toUnified($parameter[2]))
		{
			$code  = "<?php if(isset({$parameter[0]}) && count({$parameter[0]})): ?>";
			$code .= "<?php foreach({$parameter[0]} as {$parameter[1]}=>{$parameter[2]}): ?>";
			$code .= $html;
			$code .= "<?php endforeach; ?>";
			$code .= "<?php endif; ?>";
			
			return $code;
		}
		else
		{
			return $html;
		}
	}

	public static function th1_if($parameter,$html,$target)
	{
		if(isset($parameter[0]) && isset($parameter[1]) && isset($parameter[2]))
		{
			if($target->toUnified($parameter[0]))
				$isset[0] = "(isset({$parameter[0]})) && ";
			else
				$isset[0] = Null;
			
			if($target->toUnified($parameter[2]))
				$isset[2] = "(isset({$parameter[2]})) && ";
			else
				$isset[2] = Null;
			
			
			$code  = "<?php if({$isset[0]}{$isset[2]}({$parameter[0]} {$parameter[1]} {$parameter[2]})): ?>";
			$code .= $html;
			$code .= "<?php endif; ?>";
		}
		else
		{
			$code  = "<?php if(true): ?>";
			$code .= $html;
			$code .= "<?php endif; ?>";
		}
		
		return $code;
	}
	
	
	public static function th2_url($parameter,$target)
	{
		if($target->toUnified($parameter[1]))
		{
			$parameter[0] .= "=";
			$parameter[0] .= "<?php if(isset({$parameter[1]})): ?>";
			$parameter[0] .= "<?php echo urlencode({$parameter[1]}) ?>";
			$parameter[0] .= "<?php endif; ?>";
			
			
			return $parameter[0];
		}
		else
		{
			$parameter[0] .= "=";
			$parameter[0] .= "<?php if(isset(\$_GET['{$parameter[1]}'])): ?>";
			$parameter[0] .= "<?php echo urlencode(\$_GET['{$parameter[1]}']) ?>";
			$parameter[0] .= "<?php endif; ?>";
			
			
			return $parameter[0];
		}
	}
	
	public static function th2_echo($parameter,$target)
	{
		if($target->toUnified($parameter[0]))
		{
			$code  = "<?php if(isset({$parameter[0]})): ?>";
			$code .= "<?php echo {$parameter[0]} ?>";
			$code .= '<?php endif; ?>';
			
			
			return $code;
		}
		else
		{
			return "<?php echo {$parameter[0]} ?>";
		}
	}
	
	public static function th2_json($parameter,$target)
	{
		if($target->toUnified($parameter[0]))
		{
			return "<?php echo json_encode({$parameter[0]}) ?>";
		}
	}
}