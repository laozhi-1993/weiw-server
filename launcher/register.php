<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_user');
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<style>
			body {
				background-color: #0568C1;
				margin: 0;
			}
			header {
				text-align: center;
				font-size: 20px;
				color: #FFFFFF;
			}
			footer {
				text-align: center;
				font-size: 20px;
				color: #FFFFFF;
			}
			section {
				display: grid;
				grid-template-rows: 1fr auto 1fr;
				align-items: center;
				min-height: 100vh;
				padding: 50px;
				box-sizing: border-box;
			}
			h2 {
				margin: 0;
				text-align: center;
			}
			img {
				width: 100%;
			}
			form {
				margin: 20px 0;
			}
			form input {
				transition: border-color 0.3s ease;
				outline: none;
				margin-bottom: 15px;
				font-size: 16px;
				color: #999;
				text-align: left;
				padding: 15px 20px;
				width: 100%;
				line-height: 25px;
				display: inline-block;
				box-sizing: border-box;
				background: #f7fafc;
				border-radius: 36px;
				border: 1px solid #e5e5e5;
			}
			form input:focus {
				border-color: #0E6DC2;
			}
			form button {
				transition: background 0.3s ease;
				padding: 15px 20px;
				width: 100%;
				line-height: 25px;
				display: inline-block;
				color: #FFFFFF;
				cursor: pointer;
				background: #0568C1;
				border-radius: 36px;
				border: none;
			}
			form button:hover {
				background: #FDC500;
			}
			main {
				display: flex;
				justify-content: space-between;
				overflow: hidden;
				margin: 20px auto;
				max-width: 900px;
				min-height: 400px;
				background-color: #FFFFFF;
				border-radius: 8px;
			}
			.left-div {
				padding: 50px;
				box-sizing: border-box;
				width: 50%;
				background-color: #FFFFFF;
			}
			.right-div {
				padding: 40px;
				box-sizing: border-box;
				width: 50%;
				background-color: #F4F9FD;
				text-align: center;
				display: grid;
				align-items: center;
			}
			.user {
				padding-top: 10px;
				text-align: center;
			}
			.user .name {
				color: #303030;
				font-size: 20px;
			}
			.user img {
				width: 240px;
				height: 240px;
				border-radius: 15px;
				background-color: #FFFFFF;
			}
			.user .button {
				transition: background 0.3s ease;
				background-color: #0568C1;
				border-radius: 5px;
				font-size: 12px;
				color: #FFFFFF;
				cursor: pointer;
				margin:  5px;
				width: 240px;
				height: 40px;
				line-height: 40px;
				display: inline-block;
			}
			.user .button:hover {
				background-color: #FDC500;
			}
		</style>
	</head>
	<body>
		<includes-header><?php include('includes/window-header.html') ?></includes-header>
		<section>
			<header id="error"></header>
			<main>
				<div class="left-div">
					<h2>注册账号</h2>
					<form action="javascript:register(0)" method="get">
						<input onfocus="error()" id="name" type="text" placeholder="名称" title="请输入您的名称" required="" autofocus />
						<input onfocus="error()" id="password" type="password" title="请输入密码" placeholder="密码" required="" autofocus />
						<input onfocus="error()" id="confirmPassword" type="password" title="请输入确认密码" placeholder="确认密码" required="" autofocus />
						<button class="btn" type="submit">注册</button>
					</form>
					<span>已有账号？那就<a href="login.php">登录</a>吧。</span>
				</div>
				<div class="right-div">
					<img if(var.mc_user,==,false) src="/images/1.png" />
					<!--else-->
					<div if() class="user">
						<div class="avatar">
							<img src="/weiw/index_auth.php/avatar/{echo:var.mc_user.SKIN.hash}/240" />
						</div>
						<div class="name">{echo:var.mc_user.name}</div>
						<div class="button" onclick="window.location.replace('index.php')">登陆</div>
					</div>
				</div>
			</main>
			<footer>Copyright © {echo:var.config.serverName} 2023</footer>
		</section>
		<script>
			function error(text)
			{
				document.getElementById('error').textContent = text;
			}
			
			function register()
			{
				const baseUrl = '/weiw/index.php?mods=mc_register&';
				const params = new URLSearchParams({
					name: document.getElementById('name').value,
					password: document.getElementById('password').value
				});
				
				if(document.getElementById('password').value == document.getElementById('confirmPassword').value)
				{
					fetch(baseUrl+params.toString())
						.then(response => {
							if (!response.ok) {
								throw new Error('Network response was not ok ' + response.statusText);
							}
							return response.json();
						})
						.then(data => {
							if(data.success == "ok")
							{
								window.location.replace('index.php');
							}
							else
							{
								error(data.error);
							}
						})
						.catch(error => {
							console.error(error);
						});
				}
				else
				{
					error('确认密码错误');
				}
			}
		</script>
	</body>
</html>