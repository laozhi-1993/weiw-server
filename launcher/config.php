<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_config');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<title>设置</title>
		<style>
			body {
				padding-top: 30px;
				margin: 0;
				height: 100vh;
				box-sizing: border-box;
				background-color: #2e2e2e;
			}
			section {
				margin: 0 10px;
				padding: 25px;
				overflow: auto;
				height: calc(100% - 10px);
				box-sizing: border-box;
			}
			button {
				user-select: none;
			}
			main {
				max-width: 1200px;
				margin: 0 auto;
			}
			
			.menu {
				display: flex;
				align-items: center;
				justify-content: space-between;
				padding: 20px;
				margin-bottom: 20px;
				background-color: #3c3c3c;
				border-radius: 10px;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
			}

			.menu button {
				background-color: #444;
				color: #fff;
				border: none;
				padding: 10px 20px;
				font-size: 16px;
				border-radius: 5px;
				cursor: pointer;
				transition: background-color 0.3s;
			}

			.menu button:hover {
				background-color: #666;
			}

			.menu button.active {
				background-color: #007bff;
				box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
			}

			.content {
				margin-top: 20px;
				padding: 20px;
				background-color: #3c3c3c;
				border-radius: 5px;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
				position: fixed;
				opacity: 0;
				visibility: hidden;
				transform: translateY(30px) scale(0.98);
			}

			.content.active {
				position: relative;
				opacity: 1;
				visibility: visible;
				transform: translateY(0) scale(1);
				transition: opacity 1s ease, transform 1s ease;
			}
			
			
			/* 表单控件样式 */
			.form-group {
				color: #fff;
				margin-bottom: 20px;
			}

			label {
				display: block;
				margin-bottom: 8px;
				font-size: 14px;
			}

			input[type="text"],
			input[type="number"],
			input[type="password"],
			textarea,
			select {
				width: 100%;
				padding: 10px;
				font-size: 14px;
				background-color: #333;
				border: 1px solid #555;
				border-radius: 5px;
				color: #fff;
				box-sizing: border-box;
				transition: border-color 0.3s ease, background-color 0.3s ease;
			}

			input[type="text"]:focus,
			input[type="number"]:focus,
			input[type="password"]:focus,
			textarea:focus,
			select:focus {
				border-color: #4CAF50;
				background-color: #444;
			}

			textarea {
				max-width: 100%;
				min-width: 100%;
			}

			/* 按钮样式 */
			.save-btn {
				background-color: #4CAF50;
				color: #fff;
				padding: 10px 20px;
				border: none;
				border-radius: 5px;
				font-size: 16px;
				cursor: pointer;
				transition: background-color 0.3s ease;
			}

			.save-btn:hover {
				background-color: #45a049;
			}

			/* 按需并排的表单控件 */
			.form-inline {
				display: flex;
				justify-content: space-between;
				gap: 20px;
			}

			.form-inline .form-group {
				flex: 1;
			}

			/* 自适应布局 */
			@media screen and (max-width: 768px) {
				.form-inline {
					flex-direction: column;
				}

				.form-inline .form-group {
					flex: none;
					margin-bottom: 10px;
				}
			}
		</style>
	</head>
	<body>
		<section>
			<main>
				<includes-header><?php include('includes/window-header.html') ?></includes-header>
				<includes-scrollbar><?php include('includes/scrollbar.html') ?></includes-scrollbar>
				<includes-message><?php include('includes/message.html') ?></includes-message>

				<div class="menu">
					<button onclick="window.location.href='index.php'">返回首页</button>
					
					<div>
						<button class="menuButton" onclick="showContent(1)">客户端</button>
						<button class="menuButton" onclick="showContent(2)">网站</button>
						<button class="menuButton" onclick="showContent(3)">道具</button>
						<button class="menuButton" onclick="showContent(4)">RCON</button>
						<button class="menuButton" onclick="showContent(5)">RSA</button>
					</div>
				</div>


				<div class="content">
					<form action="/weiw/index.php?mods=mc_config_save&type=client" method="GET">
						<div class="form-inline">
							<div class="form-group">
								<label>我的世界版本</label>
								<input type="text" name="version" value="{echo:var.mc_config.client.version}" placeholder="请输入我的世界版本">
							</div>
							
							<div class="form-group">
								<label>服务器地址（启动游戏会直接进入相应服务器）</label>
								<input type="text" name="quickPlayAddress" value="{echo:var.mc_config.client.quickPlayAddress}" placeholder="请输入服务器地址">
							</div>
						</div>


						<div class="form-inline">
							<div class="form-group">
								<label>加载器类型</label>
								<select name="extensionType" selected="{echo:var.mc_config.client.extensionType}">
									<option value="none">none</option>
									<option value="fabric">fabric</option>
									<option value="forge">forge</option>
									<option value="neoforge">neoforge</option>
								</select>
							</div>

							<div class="form-group">
								<label>加载器版本或安装器下载地址</label>
								<input type="text" name="extensionValue" value="{echo:var.mc_config.client.extensionValue}" placeholder="请输入加载器版本或安装器下载地址">
							</div>
						</div>

						<div class="form-group">
							<label>认证模块下载地址</label>
							<input type="text" name="authModule" value="{echo:var.mc_config.client.authModule}" placeholder="请输入认证模块下载地址">
						</div>

						<div class="form-group">
							<label>Java虚拟机参数</label>
							<textarea name="jvm" rows="3" placeholder="请输入Java虚拟机参数">{echo:var.mc_config.client.jvm}</textarea>
						</div>

						<button type="submit" class="save-btn">保存设置</button>
					</form>
				</div>


				<div class="content">
					<form action="/weiw/index.php?mods=mc_config_save&type=config" method="GET">
						<div class="form-inline">
							<div class="form-group">
								<label>网站名字</label>
								<input type="text" name="serverName" value="{echo:var.mc_config.config.serverName}" placeholder="请输入网站名字">
							</div>

							<div class="form-group">
								<label>网站域名</label>
								<input type="text" name="domain" value="{echo:var.mc_config.config.domain}" placeholder="请输入网站域名">
							</div>
						</div>

						<div class="form-inline">
							<div class="form-group">
								<label>认证地址</label>
								<input type="text" name="authUrl" value="{echo:var.mc_config.config.authUrl}" placeholder="留空将自动获取">
							</div>

							<div class="form-group">
								<label>下载地址</label>
								<input type="text" name="download" value="{echo:var.mc_config.config.download}" placeholder="请输入下载地址">
							</div>
						</div>

						<div class="form-inline">
							<div class="form-group">
								<label>初始金钱</label>
								<input type="number" name="defaultMoney" value="{echo:var.mc_config.config.defaultMoney}" placeholder="请输入初始金钱">
							</div>

							<div class="form-group">
								<label>签到金钱</label>
								<input type="number" name="checkinMoney" value="{echo:var.mc_config.config.checkinMoney}" placeholder="请输入签到金钱">
							</div>
						</div>

						<button type="submit" class="save-btn">保存设置</button>
					</form>
				</div>


				<div class="content">
					<form action="/weiw/index.php?mods=mc_config_save&type=items" method="GET">
						<div class="form-group">
							<label>编辑道具内容</label>
							<textarea name="value" rows="20" placeholder="请输入道具内容">{echo:var.mc_config.items}</textarea>
						</div>
						
						<button type="submit" class="save-btn">保存设置</button>
					</form>
				</div>


				<div class="content">
					<form action="/weiw/index.php?mods=mc_config_save&type=rcon" method="GET">
						<div class="form-inline">
							<div class="form-group">
								<label>地址</label>
								<input type="text" name="host" value="{echo:var.mc_config.rcon.host}" placeholder="请输入RCON地址">
							</div>

							<div class="form-group">
								<label>端口</label>
								<input type="number" name="post" value="{echo:var.mc_config.rcon.post}" placeholder="请输入端口">
							</div>
						</div>

						<div class="form-inline">
							<div class="form-group">
								<label>密码</label>
								<input type="password" name="password" value="{echo:var.mc_config.rcon.password}" placeholder="请输入密码">
							</div>

							<div class="form-group">
								<label>超时时间</label>
								<input type="number" name="time" value="{echo:var.mc_config.rcon.time}" placeholder="请输入超时时间">
							</div>
						</div>

						<button type="submit" class="save-btn">保存设置</button>
					</form>
				</div>


				<div class="content">
					<form action="/weiw/index.php?mods=mc_config_save&type=rsa" method="GET">
						<div class="form-inline">
							<div class="form-group">
								<label>私钥</label>
								<textarea name="private" rows="20" placeholder="请输入私钥">{echo:var.mc_config.rsa.private}</textarea>
							</div>

							<div class="form-group">
								<label>公钥</label>
								<textarea name="public" rows="20" placeholder="请输入公钥">{echo:var.mc_config.rsa.public}</textarea>
							</div>
						</div>

						<button type="submit" class="save-btn">保存设置</button>
					</form>
				</div>
			</main>
		</section>
		
		
		<script src="js/main.js"></script>
		<script>
			document.querySelector('select').value = document.querySelector('select').getAttribute("selected");
			
			
			
			handleFormSubmit("form", (fetch) => {
				fetch.then((data) => {
					showMessage(data.error);
					document.querySelector('section').scrollTop = 0;
				});
			});
			
			// 切换容器内容
			function showContent(containerId) {
				const contents = document.querySelectorAll('.content');
				const buttons = document.querySelectorAll('.menuButton');

				// 隐藏所有内容容器
				contents.forEach(content => {
					content.classList.remove('active');
				});

				// 清除所有按钮的高亮状态
				buttons.forEach(button => {
					button.classList.remove('active');
				});

				// 显示当前选中的内容
				contents[containerId - 1].classList.add('active');

				// 高亮当前选中的按钮
				buttons[containerId - 1].classList.add('active');
			}
			
			setTimeout(() => showContent(1), 10);
		</script>
	</body>
</html>