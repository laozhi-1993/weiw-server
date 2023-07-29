<?php return function($_MKH)
{
	$str = '$this->_Unified';
	foreach($_MKH as $value)
	{
		if(is_numeric($value))
		{
			$str .= "[{$value}]";
		}
		else
		{
			$str .= "['{$value}']";
		}
	}
	
	return "<?php echo {$str} ?>";
};