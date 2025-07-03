<?php return function ()
	{
		try
		{
			if(!$user = mc_user_authentication::getUser())
			{
				throw new Exception('没有登录');
			}
			
			
			$requiredParams = [
				'currentPassword',
				'newPassword',
				'confirmPassword',
			];
			
			foreach ($requiredParams as $param) {
				if (!isset($_GET[$param])) {
					throw new Exception("缺少参数 $param");
				}
			}
			
			
			if(!$user->verifyPassword($_GET['currentPassword']))
			{
				throw new Exception('旧密码错误');
			}
			
			if(!$user->validatePassword($_GET['newPassword']))
			{
				throw new Exception('新密码长度需在 8 到 30 个字符之间，并且包含至少一个小写字母、一个大写字母、一个数字和一个特殊字符！');
			}
			
			if($_GET['newPassword'] !== $_GET['confirmPassword'])
			{
				throw new Exception('新密码和确认密码不匹配！');
			}
			
			
			$userManager = new mc_user_manager();
			$user->setPassword($_GET['newPassword']);
			$user->saveToJson($userManager->getUserDir());
			
			
			return [
				'status' => 'success',
				'message' => '密码修改成功',
			];
		}
		catch(Exception $Exception)
		{
			return [
				'status' => 'error',
				'message' => $Exception->getMessage(),
			];
		}
	};