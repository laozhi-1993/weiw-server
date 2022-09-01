<?php return function()
	{
		mkh_csrf::token();
		
		
		try
		{
			if(mc::admin())
			{
				$dir = __MKHDIR__;
				if(isset($_GET['private']) && isset($_GET['public']))
				{
					$_GET['private'] = str_replace('\'','\\\'',$_GET['private']);
					$_GET['public']  = str_replace('\'','\\\'',$_GET['public'] );
					
					
					file_put_contents("{$dir}/rsa_private.php","<?php return '{$_GET['private']}' ?>");
					file_put_contents("{$dir}/rsa_public.php" ,"<?php return '{$_GET['public']}'  ?>");
					
					throw new Exception('保存完成');
				}
				else
				{
					$private = include("{$dir}/rsa_private.php");
					$public  = include("{$dir}/rsa_public.php" );
					$private = htmlentities($private);
					$public  = htmlentities($public );
					
					return Array('private' => $private,'public' => $public);
				}
			}
			else throw new Exception('没有权限');
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};