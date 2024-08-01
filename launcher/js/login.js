	let loading = false;
	let handleDataRequest = function (requestData)
	{
		if (loading) {
			return;
		}
		
		$('main .button span:eq(0)').css('display','none');
		$('main .button span:eq(1)').css('display','inline-block');
		loading = true;
		$.getJSON('/weiw/index.php',requestData,(data) => {
			$('main .button span:eq(0)').css('display','inline-block');
			$('main .button span:eq(1)').css('display','none');
			loading = false;
			
			if (data.success == 'ok') {
				index();
			}
			
			if (data.success == 'login') {
				$('#Default').hide();
				$('#login').show();
			}
			
			if (data.success == 'register') {
				$('#Default').hide();
				$('#register').show();
			}
			
			if (data.error) {
				$('main .error span').html(data.error);
				$('main .error').show();
			}
		});
	}


	let loginOrRegister = function ()
	{
		requestData = {};
		requestData['mods'] = 'mc_login_or_register';
		requestData['name'] = $('#name').val();
		handleDataRequest(requestData);
	}

	let loginUser = function ()
	{
		requestData = {};
		requestData['mods'] = 'mc_login';
		requestData['name'] = $('#name').val();
		requestData['password'] = $('#login #password').val();
		handleDataRequest(requestData);
	}

	let registerUser = function ()
	{
		requestData = {};
		requestData['mods'] = 'mc_register';
		requestData['name'] = $('#name').val();
		requestData['password'] = $('#register #password').val();
		requestData['confirmPassword'] = $('#register #confirmPassword').val();
		handleDataRequest(requestData);
	}