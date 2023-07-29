<?php return function ()
	{
		mkh_csrf::token();
		mc::admin();
		
		
		try
		{
			$config = config::ini('config');
			$dir = str_ireplace('{dir}',__MKHDIR__,$config['user_dir']);
			
			if(!is_dir($dir))
			{
				$dir = __MKHDIR__.'/user';
			}


			$Arr   = Array();
			$user  = glob("{$dir}/user*.php");
			$users = array_chunk($user,20);
			$page  = Array();
			$page['total']   = count($users);
			$page['current'] = 1;
			
			
			if(isset($_GET['current']) && is_numeric($_GET['current']))
			{
				if($_GET['current'] >= 1 && $_GET['current'] <= $page['total'])
				{
					$page['current'] = $_GET['current'];
				}
			}
			
			
			if($page['current'] == 1)
			{
				$page['s'] = 'current=1';
			}
			else
			{
				$page['s'] = 'current='.($page['current']-1);
			}
			
			
			if($page['current'] == $page['total'])
			{
				$page['x'] = 'current='.$page['total'];
			}
			else
			{
				$page['x'] = 'current='.($page['current']+1);
			}
			
			
			foreach($users[$page['current']-1] as $key => $value)
			{
				$data = json_decode(substr_replace(file_get_contents($value),'',0,12),true);
				
				$Arr[$key]['name']          = $data['name'];
				$Arr[$key]['email']         = $data['email'];
				$Arr[$key]['bi']            = $data['bi'];
				$Arr[$key]['login_time']    = date('Y-m-d H:i',$data['login_time']+28800);
				$Arr[$key]['register_time'] = date('Y-m-d H:i',$data['register_time']+28800);
			}
			
			
			return Array('number' => count($user),'page' => $page,'users' => $Arr);
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};