<?php defined('__MKHDIR__') or die(http_response_code(403)) ?><!DOCTYPE html>
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
		<includes-header>	<window-header>
		<style>
			window-header {
				position: fixed;
				top: 0;
				left: 0;
				z-index: 99;
				width: 100%;
				min-height: 28px;
				font-size: 0;
				text-align: right;
				user-select: none;
				-webkit-app-region: drag;
			}
			window-header div {
				display: inline-block;
				width:  28px;
				height: 28px;
				text-align: center;
				-webkit-app-region: no-drag;
			}
			window-header div svg {
				position: relative;
				top: 5px;
				width: 	16px;
				height: 16px;
				vertical-align: top;
			}
			window-header div svg path {
				fill: #00ffff;
			}
			window-header #minimize:hover {
				background-color: #777777;
			}
			window-header #minimize:hover svg path {
				fill: #FFFFFF;
			}
			window-header #maximize:hover {
				background-color: #777777;
			}
			window-header #maximize:hover svg path {
				fill: #FFFFFF;
			}
			window-header #restore:hover {
				background-color: #777777;
			}
			window-header #restore:hover svg path {
				fill: #FFFFFF;
			}
			window-header #close:hover {
				background-color: #cc0000;
			}
			window-header #close:hover svg path {
				fill: #FFFFFF;
			}
		</style>
		<div id="minimize"><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3730"><path d="M128 448h768v128H128z" p-id="3731"></path></svg></svg></div>
		<div id="maximize"><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3389"><path d="M199.111111 256v512h625.777778v-512z m56.888889 455.111111v-341.333333h512v341.333333z" p-id="3390"></path></svg></div>
		<div id="restore" ><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3132"><path d="M512 1255.489906M865.682191 310.085948l-554.675195 0c-14.634419 0-26.403358 11.973616-26.403358 26.710374L284.603638 423.681791l-92.309414 0c-14.634419 0-26.403358 11.973616-26.403358 26.710374l0 349.998001c0 14.634419 11.768939 26.505697 26.403358 26.505697l554.675195 0c14.634419 0 26.710374-11.871277 26.710374-26.505697L773.679792 713.30002l92.002399 0c14.634419 0 26.710374-11.871277 26.710374-26.505697l0-349.998001C892.392564 322.059564 880.31661 310.085948 865.682191 310.085948zM728.65081 781.86688 210.817509 781.86688 210.817509 468.710774l517.8333 0L728.65081 781.86688zM847.363582 668.271037l-73.68379 0L773.679792 450.392165c0-14.634419-12.075954-26.710374-26.710374-26.710374L329.530282 423.681791l0-68.56686 517.8333 0L847.363582 668.271037z" p-id="3133"></path></svg></div>
		<div id="close"   ><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1501"><path d="M557.311759 513.248864l265.280473-263.904314c12.54369-12.480043 12.607338-32.704421 0.127295-45.248112-12.512727-12.576374-32.704421-12.607338-45.248112-0.127295L512.127295 467.904421 249.088241 204.063755c-12.447359-12.480043-32.704421-12.54369-45.248112-0.063647-12.512727 12.480043-12.54369 32.735385-0.063647 45.280796l262.975407 263.775299-265.151458 263.744335c-12.54369 12.480043-12.607338 32.704421-0.127295 45.248112 6.239161 6.271845 14.463432 9.440452 22.687703 9.440452 8.160624 0 16.319527-3.103239 22.560409-9.311437l265.216826-263.807983 265.440452 266.240344c6.239161 6.271845 14.432469 9.407768 22.65674 9.407768 8.191587 0 16.352211-3.135923 22.591372-9.34412 12.512727-12.480043 12.54369-32.704421 0.063647-45.248112L557.311759 513.248864z" fill="#575B66" p-id="1502"></path></svg></div>
	</window-header></includes-header>
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
					<?php if((isset($this->Unified['mc_user'])) && ($this->Unified['mc_user'] == false)): ?><img src="/images/1.png" /><?php else: ?><div class="user">
						<div class="avatar">
							<img src="/weiw/index_auth.php/avatar/<?php if(isset($this->Unified['mc_user']['SKIN']['hash'])): ?><?php echo $this->Unified['mc_user']['SKIN']['hash'] ?><?php endif; ?>/240" />
						</div>
						<div class="name"><?php if(isset($this->Unified['mc_user']['name'])): ?><?php echo $this->Unified['mc_user']['name'] ?><?php endif; ?></div>
						<div class="button" onclick="window.location.replace('index.php')">登陆</div>
					</div><?php endif; ?>
				</div>
			</main>
			<footer>Copyright © <?php if(isset($this->Unified['config']['serverName'])): ?><?php echo $this->Unified['config']['serverName'] ?><?php endif; ?> 2023</footer>
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