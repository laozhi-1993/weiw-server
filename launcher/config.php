<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");

	if ($_SERVER['PATH_INFO'] === '/forge') {
		die(file_get_contents("https://files.minecraftforge.net/net/minecraftforge/forge/maven-metadata.json"));
	}


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_server');
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
				border-top: 3px solid #FF5800;
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
				grid-template-columns: 1fr 150px 150px 200px;
				gap: 35px;
				align-items: center;
				border-radius: 5px;
				background-color: #444;
				user-select: none;
				padding: 15px 20px;
				font-size: 16px;
				font-family: 'Segoe UI', 'Microsoft YaHei', sans-serif;
				cursor: grab;
				color: #4FACFE;
				list-style: none;
				line-height: 35px;
			}

			details summary a {
				text-decoration: none;
				color: inherit;
				outline: none;
			}

			details summary .name {
				color: #fff;
				font-size: 1rem;
			}

			details summary .version {
				color: #52BE64;
				text-align: center;
				padding: 0 20px;
				background-color: #2A2A2A;
				border-radius: 20px;
			}

			details summary .type {
				color: #40B3FF;
				text-align: center;
				padding: 0 20px;
				border-radius: 5px;
				background-color: #3D5463;
			}

			details summary .id {
				color: #aaaaaa;
				font-size: 0.9rem;
				font-family: monospace;
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
				padding: 10px;
				color: #fff;
				font-size: 20px;
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

			input + .list .scrollbar center {
				display: flex;
				justify-content: center;
				align-items: center;
				color: #fff;
				height: 50px;
			}

			/* 下拉列表项样式 */
			input + .list .scrollbar div {
				padding: 5px 10px;
				cursor: pointer;
				transition: all 0.3s ease;
			}

			input + .list .scrollbar div:hover {
				background-color: #444;
			}

			input,
			textarea,
			select {
				width: 100%;
				padding: 13px;
				color: #00ff9d;
				outline: none;
				font-size: 16px;
				background-color: #333;
				border: 1px solid #555;
				border-radius: 5px;
				box-sizing: border-box;
				scrollbar-width: thin;
				scrollbar-color: #4CAF50 #333;
				transition: all 0.3s ease;
			}

			input:focus,
			textarea:focus,
			select:focus {
				border-color: #ff7b00;
				box-shadow: 0 0 0 3px rgba(255, 123, 0, 0.2), inset 0 2px 10px rgba(0,0,0,0.2);
			}

			input::placeholder,
			textarea::placeholder,
			select::placeholder {
				color: #888;
			}

			textarea {
				resize: vertical;
				min-height: 200px;
			}


			.addContainer {
				padding: 20px;
				border-top: 3px solid #FF5800;
				border-radius: 5px;
				background-color: #3c3c3c;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
			}

			.addContainer .extension .buttons {
				display: flex;
				justify-content: space-between;
				gap: 20px;
				margin: 20px 0;
			}

			.addContainer .extension .buttons button {
				width: 100%;
				height: 50px;
				font-size: 18px;
				cursor: pointer;
				color: #fff;
				border: none;
				border-radius: 5px;
				background-color: #5555ff;
				transition: all 0.3s ease;
			}
			.addContainer .extension .buttons button:hover {
				background-color: #3333ff;
				transform: translateY(2px);
			}

			.addContainer .extension .buttons button:active {
				transform: translateY(0);
			}

			.addContainer .extension .list {
				background-color: #4B4B4B;
				border-radius: 5px;
				height: 150px;
				padding: 10px;
			}

			.addContainer .extension .list .scrollbar {
				height: 100%;
				overflow-y: auto;
				scrollbar-width: thin;
				scrollbar-color: #4CAF50 #4B4B4B;
			}

			.addContainer .extension .list .scrollbar center {
				display: flex;
				justify-content: center;
				align-items: center;
				color: #fff;
				height: 100%;
				font-size: 25px;
			}

			.addContainer .extension .list .scrollbar div {
				padding: 5px 10px;
				cursor: pointer;
				transition: all 0.3s ease;
			}

			.addContainer .extension .list .scrollbar div:hover {
				background-color: #555;
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
				transition: all 0.3s ease;
			}

			.delete-btn:hover {
				background-color: #cc0000;
			}


			.loader {
				position: relative;
				width: 85px;
				height: 50px;
				background-repeat: no-repeat;
				background-image: linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0);
				background-position: 0px center, 15px center, 30px center, 45px center, 60px center, 75px center, 90px center;
				animation: rikSpikeRoll 0.65s linear infinite alternate;
			}


			@keyframes rikSpikeRoll {
			  0% { background-size: 10px 3px;}
			  16% { background-size: 10px 50px, 10px 3px, 10px 3px, 10px 3px, 10px 3px, 10px 3px}
			  33% { background-size: 10px 30px, 10px 50px, 10px 3px, 10px 3px, 10px 3px, 10px 3px}
			  50% { background-size: 10px 10px, 10px 30px, 10px 50px, 10px 3px, 10px 3px, 10px 3px}
			  66% { background-size: 10px 3px, 10px 10px, 10px 30px, 10px 50px, 10px 3px, 10px 3px}
			  83% { background-size: 10px 3px, 10px 3px,  10px 10px, 10px 30px, 10px 50px, 10px 3px}
			  100% { background-size: 10px 3px, 10px 3px, 10px 3px,  10px 10px, 10px 30px, 10px 50px}
			}
		</style>
	</head>
	<body>
		<section>
			<main>
				<includes-header><?php include('includes/window-header.html') ?></includes-header>
				<includes-scrollbar><?php include('includes/scrollbar.html') ?></includes-scrollbar>
				<includes-message><?php include('includes/message.html') ?></includes-message>
				<includes-dialog><?php include('includes/dialog.html') ?></includes-dialog>


				<div class="menu">
					<button onclick="window.location.href='index.php'">返回首页</button>
					
					<div>
						<button class="menuButton" onclick="showContent(1)">客户端</button>
						<button class="menuButton" onclick="showContent(2)">服务端</button>
					</div>
				</div>


				<div class="content">
					<form class="addContainer" action="/weiw/index.php?mods=mc_client_add" method="GET">
						<div class="form-inline">
							<div class="form-group">
								<input type="text" name="name" required placeholder="请输入配置名称" />
							</div>
							
							<div class="form-group">
								<input type="text" name="version" id="version" required onfocus="versions()" placeholder="请输入版本" />
								<div class="list">
									<div class="scrollbar" id="versions"></div>
								</div>
							</div>
						</div>

						<div class="form-group extension">
							<div class="buttons">
								<button type="button" onclick="extension(this.textContent)">fabric</button>
								<button type="button" onclick="extension(this.textContent)">forge</button>
								<button type="button" onclick="extension(this.textContent)">neoforge</button>
								<button type="button" onclick="extension(this.textContent)">none</button>
							</div>

							<div class="list">
								<div class="scrollbar" id="extension-values"></div>
							</div>
						</div>

						<input type="hidden" name="extension-type" id="extension-type" />
						<input type="hidden" name="extension-value" id="extension-value" />
						<input type="hidden" name="server" value="127.0.0.1:25565" />
						<input type="hidden" name="auth-url" value="https://authlib-injector.yushi.moe/artifact/53/authlib-injector-1.2.5.jar" />
						<input type="hidden" name="jvm" id="jvm" />
						<input type="hidden" name="downloads" />

						<button type="submit" class="save-btn">添加配置</button>
					</form>
					
					<h3 class="title-drag">将要启用的配置项拖动至最顶</h3>
					
					<reorder-container>
						<details foreach(var.mc_client,var.key,var.value) id="{echo:var.value.id}">
							<summary>
								<span class="name">{echo:var.value.name}</span>
								<span class="version">v{echo:var.value.version}</span>
								<span class="type">{echo:var.value.extensionType}</span>
								<span class="id"><a href="javascript:copyToClipboard('{echo:var.value.id}')">ID:{echo:var.value.id}</a></span>
							</summary>
							
							<form class="details-container" action="/weiw/index.php?mods=mc_client_update&id={echo:var.value.id}" method="POST">
								<div class="form-inline">
									<div class="form-group">
										<label>服务器地址</label>
										<textarea name="server" rows="9" placeholder="每行一个地址" spellcheck="false">{echo:var.value.server}</textarea>
									</div>

									<div class="form-group">
										<label>虚拟机参数</label>
										<textarea name="jvm" rows="9" placeholder="每行一个参数" spellcheck="false">{echo:var.value.jvm}</textarea>
									</div>
								</div>

								<h1 class="title">认证模块下载地址</h1>
								<div class="form-group">
									<input type="text" name="auth-url" value="{echo:var.value.authUrl}" placeholder="请输入认证模块下载地址">
								</div>

								<h1 class="title">rcon</h1>
								<div class="form-inline">
									<div class="form-group">
										<label>地址</label>
										<input type="text" name="rcon-host" value="{echo:var.value.rcon.host}" placeholder="请输入RCON地址">
									</div>

									<div class="form-group">
										<label>端口</label>
										<input type="number" name="rcon-post" value="{echo:var.value.rcon.post}" placeholder="请输入端口">
									</div>
								</div>

								<div class="form-inline">
									<div class="form-group">
										<label>密码</label>
										<input type="password" name="rcon-password" value="{echo:var.value.rcon.password}" placeholder="请输入密码">
									</div>

									<div class="form-group">
										<label>超时时间</label>
										<input type="number" name="rcon-time" value="{echo:var.value.rcon.time}" placeholder="请输入超时时间">
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
					<form class="nested" action="/weiw/index.php?mods=mc_server_update" method="GET">
						<div class="form-inline">
							<div class="form-group">
								<label>网站名字</label>
								<input type="text" name="name" value="{echo:var.mc_server.name}" placeholder="请输入网站名字">
							</div>

							<div class="form-group">
								<label>网站域名</label>
								<input type="text" name="domain" value="{echo:var.mc_server.domain}" placeholder="请输入网站域名">
							</div>
						</div>

						<div class="form-inline">
							<div class="form-group">
								<label>认证地址</label>
								<input type="text" name="auth-server-url" value="{echo:var.mc_server.authServerUrl}" placeholder="留空将自动获取">
							</div>

							<div class="form-group">
								<label>下载地址</label>
								<input type="text" name="download" value="{echo:var.mc_server.download}" placeholder="请输入下载地址">
							</div>
						</div>

						<div class="form-inline">
							<div class="form-group">
								<label>初始金钱</label>
								<input type="number" name="default-money" value="{echo:var.mc_server.defaultMoney}" placeholder="请输入初始金钱">
							</div>

							<div class="form-group">
								<label>签到金钱</label>
								<input type="number" name="checkin-money" value="{echo:var.mc_server.checkinMoney}" placeholder="请输入签到金钱">
							</div>
						</div>

						<h1 class="title">道具模板</h1>
						<div class="form-group">
							<textarea name="items" rows="20" spellcheck="false">{echo:var.mc_server.items}</textarea>
						</div>
						
						<h1 class="title">秘钥</h1>
						<div class="form-inline">
							<div class="form-group">
								<label>私钥</label>
								<textarea name="private" rows="20" placeholder="请输入私钥" spellcheck="false">{echo:var.mc_server.private}</textarea>
							</div>

							<div class="form-group">
								<label>公钥</label>
								<textarea name="public" rows="20" placeholder="请输入公钥" spellcheck="false">{echo:var.mc_server.public}</textarea>
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
			function getJson(url, container, onclick)
			{
				const addDiv = function(content, onclick) {
					const newDiv = document.createElement('div');
					
					newDiv.onclick = onclick;
					newDiv.textContent = content;
					
					container.appendChild(newDiv);
				}
				
				fetch(url)
					.then(response => response.json())
					.then(data => {
						container.innerHTML = '';
						onclick(data, addDiv);
						
						if (container.innerHTML.trim() === '') {
							container.innerHTML = '<center>没有数据</center>';
						}
					})
					.catch(() => {
						container.innerHTML = '<center>加载失败</center>';
					});
					
				container.innerHTML = '<center><span class="loader"></span></center>';
			}
			
			function versions()
			{
				const version = document.getElementById("version");
				const versions = document.getElementById("versions");
				const loaderType = document.getElementById("extension-type");
				const loaderValue = document.getElementById("extension-value");
				const loaderValues = document.getElementById("extension-values");
				
				getJson('https://launchermeta.mojang.com/mc/game/version_manifest.json', versions, (data, addDiv) => {
					for(const item of data.versions) {
						if (item.type === 'release') {
							addDiv(item.id, () => {
								version.value = item.id;
								
								loaderType.value = '';
								loaderValue.value = '';
								loaderValues.innerHTML = '';
							});
						}
					}
				});
			}
			
			function extension(type)
			{
				const version = document.getElementById("version");
				const loaderType = document.getElementById("extension-type");
				const loaderValue = document.getElementById("extension-value");
				const loaderValues = document.getElementById("extension-values");
				
				
				loaderType.value = '';
				loaderValue.value = '';
				loaderValues.innerHTML = '';
				
				
				if (!version.value) {
					return;
				}
				
				if (type === 'fabric')
				{
					getJson('https://meta.fabricmc.net/v2/versions/loader/'+(version.value), loaderValues, (data, addDiv) => {
						for(const item of data) {
							addDiv([type,item.loader.version].join('-'), () => {
								loaderType.value = type;
								loaderValue.value = item.loader.version;
								loaderValues.innerHTML = `<center>${type}-${item.loader.version}</center>`;
							});
						}
					});
				}
				
				if (type === 'forge')
				{
					getJson('config.php/forge', loaderValues, (data, addDiv) => {
						if (data[version.value]) {
							for(const item of data[version.value].reverse()) {
								addDiv([type,item].join('-'), () => {
									loaderType.value = type;
									loaderValue.value = item;
									loaderValues.innerHTML = `<center>${type}-${item}</center>`;
								});
							}
						}
					});
				}
				
				if (type === 'neoforge')
				{
					getJson('https://maven.neoforged.net/api/maven/versions/releases/net/neoforged/neoforge', loaderValues, (data, addDiv) => {
						const [ v1, v2, v3 ] = version.value.split('.');
						
						for(const item of data.versions.reverse()) {
							if (item.startsWith([v2,v3 ?? 0].join('.'))) {
								addDiv([type,item].join('-'), () => {
									loaderType.value = type;
									loaderValue.value = item;
									loaderValues.innerHTML = `<center>${type}-${item}</center>`;
								});
							}
						}
					});
				}
			}
			
			
			function deleteClient(id, name)
			{
				showDelete(`你确定删除 "${name}" 吗？`, function(result) {
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
			
			
			document.getElementById('version').addEventListener('input', function(event) {
				document.getElementById("extension-type").value = '';
				document.getElementById("extension-value").value = '';
				document.getElementById("extension-values").innerHTML = '';
			});
			
			
			window.addEventListener('jvm', function(data) {
				document.getElementById("jvm").value = data.detail.join('\r\n');
			});
			
			
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
			
			function copyToClipboard(text)
			{
				const textArea = document.createElement('textarea');
				textArea.value = text;
				document.body.appendChild(textArea);
				
				textArea.select();
				textArea.setSelectionRange(0, 99999);
				
				document.execCommand('copy');
				document.body.removeChild(textArea);
				document.querySelector('section').scrollTop = 0;
				
				showMessage('已将ID复制到剪切板');
			}
			
			const container = document.querySelector('reorder-container');
			new Sortable(container, {
				animation: 150,
				handle: 'summary',
				onUpdate: function(e) {
					fetch(`/weiw/index.php?mods=mc_client_reorder&id=${e.item.id}&newIndex=${e.newIndex}`);
				}
			});
			
			setTimeout(() => showContent(1), 10);
		</script>
	</body>
</html>