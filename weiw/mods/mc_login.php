<?php return function()
	{
		try
		{
			if(isset($_GET['type']))
			{
				if($_GET['type'] == 'code')
				{
					if(isset($_GET['val']))
					{
						email_auth::auth($_GET['val']);


						if(mc::data_token(mc_auth::constructOfflinePlayerUuid(email_auth::data()['email'])))
						{
							$login = new mc_login( email_auth::data()['email'] );
							$login ->verification();
							
							email_auth::unauth();
							throw new Exception('ok');
						}
						else
						{
							throw new Exception('register');
						}
					}
					else
					{
						throw new Exception('缺少val参数');
					}
				}
				
				
				if($_GET['type'] == 'register')
				{
					email_auth::isauth();


					if(isset($_GET['val']))
					{
						$register = new mc_register( email_auth::data()['email'], $_GET['val'] );
						$register ->preservation();
						
						email_auth::unauth();
						throw new Exception('ok');
					}
					else
					{
						throw new Exception('缺少val参数');
					}
				}
				
				
				if($_GET['type'] == 'email')
				{
					if(isset($_GET['val']))
					{
						$email_auth = new email_auth();
						$email_auth->email   = $_GET['val'];
						$email_auth->timeout = 300;
						$email_auth->send();
					}
					else
					{
						throw new Exception('缺少val参数');
					}
					
					
					throw new Exception('code');
				}
			}
			else
			{
				throw new Exception('缺少type参数');
			}
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};