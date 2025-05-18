<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");

	if (isset($_GET['version']))
	{
		try
		{
			$callback = function($version, $download)
			{
				return ['version'=>$version,'download'=>$download];
			};
			
			$html = file_get_contents("https://files.minecraftforge.net/net/minecraftforge/forge/index_{$_GET['version']}.html");
			
			preg_match_all('!<td class="download-version">\s*([0-9.]+)!', $html, $versions);
			preg_match_all('!<a href="(https://maven.minecraftforge.net/net/minecraftforge/forge/[^"]*jar)">!', $html, $downloads);
			
			
			die(json_encode(array_map($callback, $versions[1], $downloads[1])));
		}
		catch(error $error)
		{
			die('[]');
		}
	}


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_config');
	$MKH ->mods('mc_client');
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
				line-height: 20px;
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
				display: flex;
				flex-direction: column;
				gap: 10px;
				margin-top: 20px;
				position: fixed;
				color: #00ff9d;
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

			.content .nested {
				padding: 20px;
				border-radius: 5px;
				background-color: #3c3c3c;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
			}

			reorder-container {
				display: flex;
				flex-direction: column;
				gap: 10px;
			}

			details {
				border-radius: 5px;
				background-color: #3c3c3c;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
			}

			details summary {
				display: grid;
				grid-template-columns: 1fr 100px 100px 200px;
				gap: 15px;
				border-radius: 5px;
				background-color: #444;
				user-select: none;
				padding: 10px 20px;
				font-size: 16px;
				cursor: pointer;
				color: #00ffff;
				list-style: none;
				line-height: 30px;
			}

			details[open] summary {
				border-radius: 5px 5px 0 0;
			}

			/* 自定义箭头样式 */
			details summary::after {
				content: "▶";
				position: absolute;
				right: 20px;
				transition: transform 0.2s;
			}

			details[open] summary::after {
				transform: rotate(90deg);
			}

			details .details-container {
				padding: 20px;
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

			/* 表单控件样式 */
			.form-group {
				position: relative;
				margin-bottom: 20px;
			}

			label {
				display: block;
				margin-bottom: 8px;
				font-size: 14px;
			}

			.title {
				margin: 10;
				padding: 15px;
				color: #fff;
				text-align: center;
				border-radius: 10px;
				background-color: #444;
			}

			.title-drag {
				text-align: center;
				color: #24cf2c;
			}

			/* 输入框聚焦时显示下拉列表 */
			input:focus + .list {
				opacity: 1;
				visibility: visible;
				transform: translateY(0);
			}

			/* 下拉列表样式 */
			input + .list {
				position: absolute;
				top: calc(100% + 8px);
				left: 0;
				z-index: 1;
				width: 100%;
				background-color: #555;
				border-radius: 5px;
				opacity: 0;
				visibility: hidden;
				transform: translateY(10px);
				transition: all 0.3s ease;
			}

			input + .list .scrollbar {
				margin: 10px;
				max-height: 200px;
				overflow-y: auto;
				scrollbar-width: thin;
				scrollbar-color: #4CAF50 #555;
			}

			/* 下拉列表项样式 */
			input + .list .scrollbar div {
				padding: 5px 10px;
				cursor: pointer;
				transition: all 0.2s ease;
			}

			input + .list .scrollbar div:hover {
				background-color: #444;
			}

			input[type="text"],
			input[type="number"],
			input[type="password"],
			textarea,
			select {
				width: 100%;
				padding: 10px;
				color: #00ff9d;
				font-size: 14px;
				background-color: #333;
				border: 1px solid #555;
				border-radius: 5px;
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
				background-color: #5555ff;
				color: #fff;
				padding: 10px 20px;
				border: none;
				border-radius: 5px;
				font-size: 16px;
				cursor: pointer;
				transition: background-color 0.3s ease;
			}

			.save-btn:hover {
				background-color: #3333ff;
			}
			
			.delete-btn {
				margin-left: 10px;
				background-color: #ff4444;
				color: #fff;
				padding: 10px 20px;
				border: none;
				border-radius: 5px;
				font-size: 16px;
				cursor: pointer;
				transition: background-color 0.3s ease;
			}

			.delete-btn:hover {
				background-color: #cc0000;
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
				<includes-confirm><?php include('includes/custom_confirm.html') ?></includes-confirm>


				<div class="menu">
					<button onclick="window.location.href='index.php'">返回首页</button>
					
					<div>
						<button class="menuButton" onclick="showContent(1)">客户端</button>
						<button class="menuButton" onclick="showContent(2)">网站</button>
						<button class="menuButton" onclick="showContent(3)">道具</button>
						<button class="menuButton" onclick="showContent(4)">秘钥</button>
					</div>
				</div>


				<div class="content">
					<form class="nested" action="/weiw/index.php?mods=mc_client_add" method="GET">
						<div class="form-inline">
							<div class="form-group">
								<label>名称</label>
								<input type="text" name="name" required placeholder="请输入名称" />
							</div>
							
							<div class="form-group">
								<label>版本</label>
								<input type="text" name="version" id="version" required onfocus="versions()" placeholder="请输入版本" />
								<div class="list">
									<div class="scrollbar" id="versions">
									</div>
								</div>
							</div>
						</div>

						<div class="form-inline">
							<div class="form-group">
								<label>加载器类型</label>
								<input type="text" value="none" name="loaderType" id="loaderType" readonly placeholder="请输入加载器类型" autocomplete="off" onfocus="document.getElementById('loaderValue').value = ''" />
								<div class="list">
									<div class="scrollbar">
										<div onclick="document.getElementById('loaderType').value = this.textContent">none</div>
										<div onclick="document.getElementById('loaderType').value = this.textContent">fabric</div>
										<div onclick="document.getElementById('loaderType').value = this.textContent">forge</div>
										<div onclick="document.getElementById('loaderType').value = this.textContent">neoforge</div>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label>加载器版本或安装器下载地址</label>
								<input type="text" value="{echo:var.value.extensionValue}" name="loaderValue" id="loaderValue" placeholder="请输入加载器版本或安装器下载地址" onfocus="extensions()" />
								<div class="list">
									<div class="scrollbar" id="loaderValues">
									</div>
								</div>
							</div>
						</div>

						<button type="submit" class="save-btn">添加配置</button>
					</form>
					
					<h3 class="title-drag">将要启用的配置项拖动至最顶</h3>
					
					<reorder-container>
						<details foreach(var.mc_client,var.key,var.value) id="{echo:var.value.id}">
							<summary>
								<span>{echo:var.value.name}</span>
								<span>v{echo:var.value.version}</span>
								<span>{echo:var.value.extensionType}</span>
								<span>ID:{echo:var.value.id}</span>
							</summary>
							
							<form class="details-container" action="/weiw/index.php?mods=mc_client_update&id={echo:var.value.id}" method="POST">
								<div class="form-inline">
									<div class="form-group">
										<label>我的世界服务器地址</label>
										<input type="text" name="address" value="{echo:var.value.address}" placeholder="请输入服务器地址">
									</div>

									<div class="form-group">
										<label>认证模块下载地址</label>
										<input type="text" name="authModule" value="{echo:var.value.authModule}" placeholder="请输入认证模块下载地址">
									</div>
								</div>
								
								
								<div class="form-group">
									<label>Java虚拟机参数</label>
									<textarea name="jvm" rows="3">{echo:var.value.jvm}</textarea>
								</div>

								<h1 class="title">rcon</h1>
								<div class="form-inline">
									<div class="form-group">
										<label>地址</label>
										<input type="text" name="rconHost" value="{echo:var.value.rcon.host}" placeholder="请输入RCON地址">
									</div>

									<div class="form-group">
										<label>端口</label>
										<input type="number" name="rconPost" value="{echo:var.value.rcon.post}" placeholder="请输入端口">
									</div>
								</div>

								<div class="form-inline">
									<div class="form-group">
										<label>密码</label>
										<input type="password" name="rconPassword" value="{echo:var.value.rcon.password}" placeholder="请输入密码">
									</div>

									<div class="form-group">
										<label>超时时间</label>
										<input type="number" name="rconTime" value="{echo:var.value.rcon.time}" placeholder="请输入超时时间">
									</div>
								</div>

								<h1 class="title">文件下载列表</h1>
								<div class="form-group">
									<textarea name="downloads" rows="15" placeholder="每行一个地址">{echo:var.value.downloads}</textarea>
								</div>

								<h1 class="title">道具</h1>
								<div class="form-group">
									<textarea name="items" rows="15">{echo:var.value.items}</textarea>
								</div>

								<button type="submit" class="save-btn">保存设置</button>
								<button type="button" class="delete-btn" onclick="deleteClient('{echo:var.value.id}', '{echo:var.value.name}')">删除</button>
							</form>
						</details>
					</reorder-container>
				</div>


				<div class="content">
					<form class="nested" action="/weiw/index.php?mods=mc_config_save&type=config" method="GET">
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
					<form class="nested" action="/weiw/index.php?mods=mc_config_save&type=items" method="GET">
						<div class="form-group">
							<label>编辑道具内容</label>
							<textarea name="value" rows="20">{echo:var.mc_config.items}</textarea>
						</div>
						
						<button type="submit" class="save-btn">保存设置</button>
					</form>
				</div>


				<div class="content">
					<form class="nested" action="/weiw/index.php?mods=mc_config_save&type=rsa" method="GET">
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
		
		
		<script src="js/Sortable.min.js"></script>
		<script src="js/main.js"></script>
		<script>
			const container = document.querySelector('reorder-container');
			new Sortable(container, {
				animation: 150,
				handle: 'summary',
				onUpdate: function(e) {
					fetch(`/weiw/index.php?mods=mc_client_reorder&id=${e.item.id}&newIndex=${e.newIndex}`);
				}
			});
			
			function deleteClient(id, name)
			{
				customConfirm(`你确定删除"${name}"吗？`, function(result) {
					if (result) {
						fetch(`/weiw/index.php?mods=mc_client_delete&id=${id}`)
							.then(response => response.json())
							.then(data => {
								if (data.error === 'ok') {
									document.getElementById(id).remove();
								} else {
									showMessage(data.error);
								}
							});
					}
				});
			}
			
			function versions()
			{
				const v = document.getElementById("version");
				const versions = document.getElementById("versions");
				const loaderType = document.getElementById("loaderType");
				const loaderValue = document.getElementById("loaderValue");
				
				
				fetch('https://launchermeta.mojang.com/mc/game/version_manifest.json')
					.then(response => response.json())
					.then(data => {
						for(const version of data.versions) {
							if (version.type === 'release') {
								const newDiv = document.createElement('div');
								newDiv.onclick = (event) => v.value = version.id;
								newDiv.textContent = version.id;
								versions.appendChild(newDiv);
							}
						}
					});
				
				
				versions.innerHTML = '';
				loaderType.value = 'none';
				loaderValue.value = '';
			}
			
			function extensions(inputElement)
			{
				const v = document.getElementById("version");
				const loaderType = document.getElementById("loaderType");
				const loaderValue = document.getElementById("loaderValue");
				const loaderValues = document.getElementById("loaderValues");
				
				
				const addDiv = function (textContent, value)
				{
					const newDiv = document.createElement('div');
					newDiv.onclick = (event) => loaderValue.value = value;
					newDiv.textContent = textContent;
					loaderValues.appendChild(newDiv);
				}
				
				if (v.value === "")
				{
					return;
				}
				
				if (loaderType.value === 'fabric')
				{
					fetch('https://meta.fabricmc.net/v2/versions/loader/'+v.value)
						.then(response => response.json())
						.then(data => {
							for(const version of data) {
								addDiv(version.loader.version, version.loader.version);
							}
						});
				}
				
				if (loaderType.value === 'forge')
				{
					fetch('config.php?version='+v.value)
						.then(response => response.json())
						.then(data => {
							for(const version of data) {
								addDiv(version.version, version.download);
							}
						});
				}
				
				if (loaderType.value === 'neoforge')
				{
					fetch('https://maven.neoforged.net/api/maven/versions/releases/net/neoforged/neoforge')
						.then(response => response.json())
						.then(data => {
							for(const version of data.versions.reverse()) {
								if (version.startsWith(v.value.slice(2))) {
									addDiv(version, `https://maven.neoforged.net/releases/net/neoforged/neoforge/${version}/neoforge-${version}-installer.jar`);
								}
							}
						});
				}
				
				loaderValues.innerHTML = '';
			}
			
			
			handleFormSubmit("form", (fetch) => {
				fetch.then((data) => {
					if (data.error === 'ok') {
						location.reload();
					} else {
						showMessage(data.error);
						document.querySelector('section').scrollTop = 0;
					}
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