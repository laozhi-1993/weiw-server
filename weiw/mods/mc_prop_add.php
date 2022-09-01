<?php return function ()
	{
		mkh_csrf::token();
		
		
		try
		{
			if(mc::admin())
			{
				if(!isset($_GET['name']) or $_GET['name'] == '')
				{
					$_GET['name'] = 'PropName';
				}
				if(!isset($_GET['describe']) or $_GET['describe'] == '')
				{
					$_GET['describe'] = 'PropDescription';
				}
				if(!isset($_GET['price']) or $_GET['price'] == '')
				{
					$_GET['price'] = '0';
				}
				if(!isset($_GET['command']) or $_GET['command'] == '')
				{
					$_GET['command'] = 'fly {name} enable';
				}
				
				
				
					$id   = time().rand(100,999);
					$prop = config('rcon_prop.php');
					$prop[$id]['id']       = $id;
					$prop[$id]['name']     = $_GET['name'];
					$prop[$id]['describe'] = $_GET['describe'];
					$prop[$id]['price']    = $_GET['price'];
					$prop[$id]['command']  = $_GET['command'];				
					
					
					config('rcon_prop.php',$prop);
					throw new Exception('添加完成');
			}
			else throw new Exception('没有权限');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};