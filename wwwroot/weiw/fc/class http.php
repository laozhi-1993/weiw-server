<?php class http
{
	public static function cache($offset)
	{
		$offset = gmdate("D, d M Y H:i:s", time() + $offset);
		
		
		header("Cache-Control: public");
		header("Pragma: cache");
		header("Expires: {$offset} GMT");
	}
	
	
	public static function open($url, $post=null, $header=null, $time=null)
	{
		is_array($post)   && $options['http']['method']  = 'POST';
		is_array($post)   && $header[]                   = 'Content-type: application/x-www-form-urlencoded';
		is_array($post)   or $post                       = array();
		is_array($header) or $header                     = array();
		is_numeric($time) or $time                       = 10;


		$header[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36';
		$header[] = 'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';


		$options['http']['header']  = implode("\r\n", $header);
		$options['http']['content'] = http_build_query($post);
		$options['http']['timeout'] = round($time);
		return file_get_contents($url, false, stream_context_create($options));
	}
	
	
	public static function get_current_url() {
		// 检查是否为 HTTPS 协议
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		
		// 获取域名
		$domain = $_SERVER['HTTP_HOST'];
		
		// 获取端口号
		$port = $_SERVER['SERVER_PORT'];
		
		// 只有当端口不是默认的 80 或 443 时，才加上端口号
		if (($protocol === "http://" && $port != 80) || ($protocol === "https://" && $port != 443)) {
			// 解决端口重复的问题，判断 HTTP_HOST 是否已经包含端口
			if (strpos($domain, ":") === false) {
				$domain .= ":" . $port;
			}
		}
		
		$paths = [];
		$paths[] = $protocol . $domain;
		
		foreach(func_get_args() as $path)
		{
			foreach(explode('/', $path) as $routeParameter)
			{
				if ($routeParameter) $paths[] = rawurlencode($routeParameter);
			}
		}
		
		// 合拼完整的 URL
		return implode('/', $paths);
	}
}