<?php class http
{
	public static function cache($offset)
	{
		$offset = gmdate("D, d M Y H:i:s", time() + $offset);
		
		
		header("Cache-Control: public");
		header("Pragma: cache");
		header("Expires: {$offset} GMT");
	}
	
	
	static function open($url, $post=null, $header=null, $time=null)
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
}