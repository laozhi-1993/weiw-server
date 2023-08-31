<?php

class http_post
{
	static function open($url, $params = false, $header = array(), $cookie = '', $daili = false)
	{
		if (is_array($params))
		{
			$params = http_build_query($params, null, '&');
		}
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_COOKIE, $cookie);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		if($daili)
		{
			curl_setopt($ch, CURLOPT_PROXY, '114.220.182.166'); //代理服务器地址
			curl_setopt($ch, CURLOPT_PROXYPORT, 8118); //代理服务器端口
		}

		if($params)
		{
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		}
		
		$response = curl_exec($ch);
		curl_close($ch);
	 
		return $response;
	}
}