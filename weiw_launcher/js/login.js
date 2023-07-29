	var type = 'email';
	var mc_login_once = once();
	var mc_login = function ()
	{
		mc_login_once((open) => {
			$('main .button span:eq(0)').css('display','none');
			$('main .button span:eq(1)').css('display','inline-block');
			$.getJSON('/weiw/index.php',{'mods':'mc_login','type':type,'val':$('input').val()},(data) => {
				$('main .button span:eq(0)').css('display','inline-block');
				$('main .button span:eq(1)').css('display','none');
				open();
				
				if(data.error == 'ok')
				{
					index();
					return;
				}
				
				if(data.error == 'code')
				{
					$('main input').val('');
					$('main input').attr('placeholder','请输入验证码');
					return type = 'code';
				}
				
				if(data.error == 'register')
				{
					$('main input').val('');
					$('main input').attr('placeholder','请输入用户名称');
					return type = 'register';
				}
				
				
				$('main .error span').html(data.error);
				$('main .error').show();
			});
		});
	}