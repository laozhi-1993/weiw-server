<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_check_auth');
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
		</style>
		<title>登陆</title>
	</head>
	<body>
		<includes-header><?php include('includes/window-header.html') ?></includes-header>
		
		<section>
			<header id="error"></header>
			
			<main>
				<div class="left-div">
					<h2>登陆</h2>
					
					<form action="javascript:login(0)" method="get">
						<input onfocus="error()" id="name" type="text" placeholder="名称" title="请输入您的名称" required="" autofocus />
						<input onfocus="error()" id="password" type="password" title="请输入您的密码" placeholder="密码" required="" autofocus />
						<button class="btn" type="submit">登录</button>
					</form>
					
					<span>没有账号？那就<a href="register.php">注册</a>一个吧。</span>
				</div>
				
				<div class="right-div">
					<img src="/images/1.png" />
				</div>
			</main>
			
			<footer>Copyright © {echo:var.config.serverName} 2023</footer>
		</section>
		
		<script>
			function error(text)
			{
				document.getElementById('error').textContent = text;
			}
			
			function login()
			{
				const baseUrl = '/weiw/index.php?mods=mc_login&';
				const params = new URLSearchParams({
					name: document.getElementById('name').value,
					password: document.getElementById('password').value
				});
				
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
		</script>
	</body>
</html>