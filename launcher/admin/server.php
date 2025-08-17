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
		<title>服务端</title>
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
				position: relative;
				color: #00ff9d;
			}

			main .nested {
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
		</style>
	</head>
	<body>
		<section>
			<main>
				<includes-header><?php include('../includes/window-header.html') ?></includes-header>
				<includes-scrollbar><?php include('../includes/scrollbar.html') ?></includes-scrollbar>
				<includes-message><?php include('../includes/message.html') ?></includes-message>
				<includes-menu><?php include('menu.html') ?></includes-menu>
				
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
			</main>
		</section>
		
		
		<script src="../js/main.js"></script>
		<script>
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
		</script>
	</body>
</html>