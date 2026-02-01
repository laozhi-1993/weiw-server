<?php
	function getDimensionsFromWidth($width) {
		$height = ($width * 16) / 10;
		return ['width' => $width, 'height' => $height];
	}
	
	if (isset($_SERVER['PATH_INFO']))
	{
		$segments = explode('/', $_SERVER['PATH_INFO']);
	}
	else
	{
		$segments = Array();
	}
	
	if (isset($segments[2]) && file_exists("../../usercapes/{$segments[2]}.png"))
	{
		$output = file_get_contents("../../usercapes/{$segments[2]}.png");
	}
	else
	{
		http_response_code(404);
		die;
	}
	
	if (isset($segments[1]) && $segments[1] >= 10 && $segments[1] <= 512)
	{
		$size = getDimensionsFromWidth(intval($segments[1]));
	}
	else
	{
		$size = getDimensionsFromWidth(100);
	}
	
	
	$im = imagecreatefromstring($output);
	$av = imagecreatetruecolor($size['width'], $size['height']);
	
	imagesavealpha($av, true);
	imagefill($av, 0, 0, imagecolorallocatealpha($av, 0, 0, 0, 127));
	
	
	header('Content-type: image/png');
	imagecopyresized($av, $im, 0, 0, 1, 1, $size['width'], $size['height'], 10, 16);
	imagepng($av);
	imagedestroy($av);
	imagedestroy($im);