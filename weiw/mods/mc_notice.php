<?php return function ()
	{
		$data = Array();
		$notice = config('notice.php');
		
		if(isset($notice['content']))
		{
			$data['content'] = base64_decode($notice['content']);
		}
		else
		{
			$data['content'] = '';
		}
		
		if(isset($notice['time']))
		{
			$data['date'] = date('Y年m月d日 H时i分' ,$notice['time'] + 28800 );
		}
		else
		{
			$data['date'] = 0;
		}
		
		
		return $data;
	};