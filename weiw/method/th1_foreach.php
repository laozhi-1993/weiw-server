<?php return function($_MKH,$html)
{
	$_MKH[1] = str_replace(':','=>',$_MKH[1]);
	return "<?php if(is_array({$_MKH[0]}) && count({$_MKH[0]})): ?><?php foreach({$_MKH[0]} as {$_MKH[1]}): ?>{$html}<?php endforeach; ?><?php endif; ?>";
};