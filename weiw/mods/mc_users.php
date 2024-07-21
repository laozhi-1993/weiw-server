<?php return function ()
	{
		try
		{
			if((!$user = mc_user_authentication::getUser()) or (!$user->isAdmin())) {
				throw new Exception("没有权限");
			}
			
			
			$userManager = new mc_user_manager();
			$userManager->getAllUsers();
			
			$users = array_chunk($userManager->getUsers(),20);
			$Arr   = Array();
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
				$Arr[$key]['name']          = $value->toArray()['name'];
				$Arr[$key]['money']         = $value->toArray()['money'];
				$Arr[$key]['loginTime']    = date('Y-m-d H:i',$value->toArray()['loginTime']+28800);
				$Arr[$key]['registerTime'] = date('Y-m-d H:i',$value->toArray()['registerTime']+28800);
			}
			
			
			return Array('number' => count($userManager->getUsers()),'page' => $page,'users' => $Arr);
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};