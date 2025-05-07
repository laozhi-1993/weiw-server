<?php defined('__MKHDIR__') or die(http_response_code(403)) ?><!DOCTYPE html>
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

			h1 {
				margin: 10;
				padding: 15px;
				color: #fff;
				text-align: center;
				border-radius: 10px;
				background-color: #444;
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
				<includes-scrollbar>	<style>
		::-webkit-scrollbar {width: 10px}
		::-webkit-scrollbar {height: 10px}
		::-webkit-scrollbar-track {border-radius: 5px}
		::-webkit-scrollbar-track {background-color: #606060}
		::-webkit-scrollbar-thumb {border-radius: 5px}
		::-webkit-scrollbar-thumb {background-color: #9393ff}
	</style></includes-scrollbar>
				<includes-message>	<script>
		function showMessage(text) {
			const messageId = Date.now();  // 使用 Date.now() 获取当前时间戳作为唯一 ID
			let messageHtml = document.querySelector(".result data").innerHTML;
			
			// 使用正则替换占位符
			messageHtml = messageHtml.replace(/{id}/g, messageId);
			messageHtml = messageHtml.replace(/{error}/g, text);
			
			// 滚动到页面顶部
			document.documentElement.scrollTop = 0;
			document.body.scrollTop = 0;
			document.querySelector(".result").insertAdjacentHTML('beforeend', messageHtml);

			// 延时3秒后移除消息
			setTimeout(function() {
				removeMessage(messageId);
			}, 3000);
		}
		
		function removeMessage(id) {
			const messageElement = document.getElementById(id);
			if (messageElement) {
				messageElement.classList.add('remove');

				// 动画结束后移除元素
				setTimeout(function() {
					messageElement.remove();
				}, 500);
			}
		}
	</script>
	<style>
        @keyframes remove {
            0% {
                transform: scale(1);
				opacity: 1;
            }
            100% {
                transform: scale(0);
				opacity: 0;
            }
        }
		
		.result {
			position: relative;
			top: 0;
			left: 0;
			z-index: 1;
		}
		.result .remove {
			animation: remove 0.51s cubic-bezier(0.25, 1, 0.5, 1);
        }
		.result data {
			display: none;
		}
		.result div {
			margin-bottom: 8px;
			position: relative;
			padding: 10px;
			padding-right: 30px;
			background-color: #f4d03f;
			border-radius: 5px;
		}
		.result div span:first-child {
			color: #000;
			font-size: 14px;
		}
		.result div span:last-child {
			position: absolute;
			top: 0;
			right: 5px;
			display: inline-block;
			cursor: pointer;
			padding: 10px;
			color: #ff0000;
		}
	</style>
	<div class="result">
		<data>
			<div id="{id}">
				<span>{error}</span>
				<span title="关闭" onclick="removeMessage({id})">X</span>
			</div>
		</data>
	</div></includes-message>
				<includes-confirm>	<script>
		function customConfirm(message, callback) {
			const modal          = document.getElementById('custom-confirm');
			const messageElement = document.getElementById('confirm-message');
			const yesButton      = document.getElementById('confirm-yes');
			const noButton       = document.getElementById('confirm-no');

			
			messageElement.innerHTML = message;
            modal.classList.toggle('show');
			
			
			yesButton.onclick = function() {
				modal.classList.toggle('show');
				callback(true);
			};
			
			noButton.onclick = function() {
				modal.classList.toggle('show');
				callback(false);
			};
		}
	</script>
	<style>
        @keyframes scaleUp {
            0% {
                transform: scale(0); /* 开始时小 */
				opacity: 0;
            }
            40% {
                transform: scale(1.2); /* 放大到 1.2x */
            }
            60% {
                transform: scale(0.9); /* 略微缩小 */
            }
            100% {
                transform: scale(1); /* 最终恢复到原始大小 */
				opacity: 1;
            }
        }
		
		.confirm {
			position: fixed;
			top:   0;
			right: 0;
			z-index: 99;
			user-select: none;
			width: 	100%;
			height: 100%;
			background-color: rgba(0,0,0,0.5);
			visibility: hidden;
		}
		.confirm.show {
			visibility: visible;
		}
		.confirm.show .margin {
			animation: scaleUp 0.5s ease-in-out forwards;
        }
		.confirm .margin {
			background-color: #fff;
			border-radius: 10px;
			position: relative;
			top: 50%;
			x-index: 1;
			text-align: center;
			overflow: hidden;
			margin: -150px auto 0 auto;
			max-width: 500px;
		}
		.confirm .margin .message {
			padding: 50px 10px;
		}
		.confirm .margin .button {
			font-size: 0;
			height: 40px;
			line-height: 40px;
		}
		.confirm .margin .button span {
			background-color: #494A5F;
			box-sizing: border-box;
			width: 50%;
			display: inline-block;
			font-size: 16px;
			color: #FFFFFF;
			cursor: pointer;
		}
		.confirm .margin .button span:hover {
			color: #86d688;
		}
		.confirm .margin .button span:first-child {
			border-right: 1px solid #7b817b;
		}
		.confirm .margin .button span:last-child {
			border-left: 1px solid #7b817b;
		}
	</style>
	<div class="confirm fade" id="custom-confirm">
		<div class="margin">
			<div class="message" id="confirm-message"></div>
			<div class="button">
				<span id="confirm-yes">确定</span>
				<span id="confirm-no">取消</span>
			</div>
		</div>
	</div></includes-confirm>


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
								<input type="text" value="<?php if(isset($this->Unified['value']['extensionValue'])): ?><?php echo $this->Unified['value']['extensionValue'] ?><?php endif; ?>" name="loaderValue" id="loaderValue" placeholder="请输入加载器版本或安装器下载地址" onfocus="extensions()" />
								<div class="list">
									<div class="scrollbar" id="loaderValues">
									</div>
								</div>
							</div>
						</div>

						<button type="submit" class="save-btn">添加配置</button>
					</form>
					
					<reorder-container>
						<?php if(isset($this->Unified['mc_client']) && count($this->Unified['mc_client'])): ?><?php foreach($this->Unified['mc_client'] as $this->Unified['key']=>$this->Unified['value']): ?><details id="<?php if(isset($this->Unified['value']['id'])): ?><?php echo $this->Unified['value']['id'] ?><?php endif; ?>">
							<summary>
								<span><?php if(isset($this->Unified['value']['name'])): ?><?php echo $this->Unified['value']['name'] ?><?php endif; ?></span>
								<span>v<?php if(isset($this->Unified['value']['version'])): ?><?php echo $this->Unified['value']['version'] ?><?php endif; ?></span>
								<span><?php if(isset($this->Unified['value']['extensionType'])): ?><?php echo $this->Unified['value']['extensionType'] ?><?php endif; ?></span>
								<span>ID:<?php if(isset($this->Unified['value']['id'])): ?><?php echo $this->Unified['value']['id'] ?><?php endif; ?></span>
							</summary>
							
							<form class="details-container" action="/weiw/index.php?mods=mc_client_update&id=<?php if(isset($this->Unified['value']['id'])): ?><?php echo $this->Unified['value']['id'] ?><?php endif; ?>" method="POST">
								<div class="form-inline">
									<div class="form-group">
										<label>我的世界服务器地址</label>
										<input type="text" name="address" value="<?php if(isset($this->Unified['value']['address'])): ?><?php echo $this->Unified['value']['address'] ?><?php endif; ?>" placeholder="请输入服务器地址">
									</div>

									<div class="form-group">
										<label>认证模块下载地址</label>
										<input type="text" name="authModule" value="<?php if(isset($this->Unified['value']['authModule'])): ?><?php echo $this->Unified['value']['authModule'] ?><?php endif; ?>" placeholder="请输入认证模块下载地址">
									</div>
								</div>
								
								
								<div class="form-group">
									<label>Java虚拟机参数</label>
									<textarea name="jvm" rows="3"><?php if(isset($this->Unified['value']['jvm'])): ?><?php echo $this->Unified['value']['jvm'] ?><?php endif; ?></textarea>
								</div>

								<h1>rcon</h1>
								<div class="form-inline">
									<div class="form-group">
										<label>地址</label>
										<input type="text" name="rconHost" value="<?php if(isset($this->Unified['value']['rcon']['host'])): ?><?php echo $this->Unified['value']['rcon']['host'] ?><?php endif; ?>" placeholder="请输入RCON地址">
									</div>

									<div class="form-group">
										<label>端口</label>
										<input type="number" name="rconPost" value="<?php if(isset($this->Unified['value']['rcon']['post'])): ?><?php echo $this->Unified['value']['rcon']['post'] ?><?php endif; ?>" placeholder="请输入端口">
									</div>
								</div>

								<div class="form-inline">
									<div class="form-group">
										<label>密码</label>
										<input type="password" name="rconPassword" value="<?php if(isset($this->Unified['value']['rcon']['password'])): ?><?php echo $this->Unified['value']['rcon']['password'] ?><?php endif; ?>" placeholder="请输入密码">
									</div>

									<div class="form-group">
										<label>超时时间</label>
										<input type="number" name="rconTime" value="<?php if(isset($this->Unified['value']['rcon']['time'])): ?><?php echo $this->Unified['value']['rcon']['time'] ?><?php endif; ?>" placeholder="请输入超时时间">
									</div>
								</div>

								<h1>文件下载列表</h1>
								<div class="form-group">
									<textarea name="downloads" rows="15" placeholder="地址格式[<文件夹名>]<下载链接地址>，比如[mods]https...，换行进行分隔。"><?php if(isset($this->Unified['value']['downloads'])): ?><?php echo $this->Unified['value']['downloads'] ?><?php endif; ?></textarea>
								</div>

								<h1>道具</h1>
								<div class="form-group">
									<textarea name="items" rows="15"><?php if(isset($this->Unified['value']['items'])): ?><?php echo $this->Unified['value']['items'] ?><?php endif; ?></textarea>
								</div>

								<button type="submit" class="save-btn">保存设置</button>
								<button type="button" class="delete-btn" onclick="deleteClient('<?php if(isset($this->Unified['value']['id'])): ?><?php echo $this->Unified['value']['id'] ?><?php endif; ?>', '<?php if(isset($this->Unified['value']['name'])): ?><?php echo $this->Unified['value']['name'] ?><?php endif; ?>')">删除</button>
							</form>
						</details><?php endforeach; ?><?php endif; ?>
					</reorder-container>
				</div>


				<div class="content">
					<form class="nested" action="/weiw/index.php?mods=mc_config_save&type=config" method="GET">
						<div class="form-inline">
							<div class="form-group">
								<label>网站名字</label>
								<input type="text" name="serverName" value="<?php if(isset($this->Unified['mc_config']['config']['serverName'])): ?><?php echo $this->Unified['mc_config']['config']['serverName'] ?><?php endif; ?>" placeholder="请输入网站名字">
							</div>

							<div class="form-group">
								<label>网站域名</label>
								<input type="text" name="domain" value="<?php if(isset($this->Unified['mc_config']['config']['domain'])): ?><?php echo $this->Unified['mc_config']['config']['domain'] ?><?php endif; ?>" placeholder="请输入网站域名">
							</div>
						</div>

						<div class="form-inline">
							<div class="form-group">
								<label>认证地址</label>
								<input type="text" name="authUrl" value="<?php if(isset($this->Unified['mc_config']['config']['authUrl'])): ?><?php echo $this->Unified['mc_config']['config']['authUrl'] ?><?php endif; ?>" placeholder="留空将自动获取">
							</div>

							<div class="form-group">
								<label>下载地址</label>
								<input type="text" name="download" value="<?php if(isset($this->Unified['mc_config']['config']['download'])): ?><?php echo $this->Unified['mc_config']['config']['download'] ?><?php endif; ?>" placeholder="请输入下载地址">
							</div>
						</div>

						<div class="form-inline">
							<div class="form-group">
								<label>初始金钱</label>
								<input type="number" name="defaultMoney" value="<?php if(isset($this->Unified['mc_config']['config']['defaultMoney'])): ?><?php echo $this->Unified['mc_config']['config']['defaultMoney'] ?><?php endif; ?>" placeholder="请输入初始金钱">
							</div>

							<div class="form-group">
								<label>签到金钱</label>
								<input type="number" name="checkinMoney" value="<?php if(isset($this->Unified['mc_config']['config']['checkinMoney'])): ?><?php echo $this->Unified['mc_config']['config']['checkinMoney'] ?><?php endif; ?>" placeholder="请输入签到金钱">
							</div>
						</div>

						<button type="submit" class="save-btn">保存设置</button>
					</form>
				</div>


				<div class="content">
					<form class="nested" action="/weiw/index.php?mods=mc_config_save&type=items" method="GET">
						<div class="form-group">
							<label>编辑道具内容</label>
							<textarea name="value" rows="20"><?php if(isset($this->Unified['mc_config']['items'])): ?><?php echo $this->Unified['mc_config']['items'] ?><?php endif; ?></textarea>
						</div>
						
						<button type="submit" class="save-btn">保存设置</button>
					</form>
				</div>


				<div class="content">
					<form class="nested" action="/weiw/index.php?mods=mc_config_save&type=rsa" method="GET">
						<div class="form-inline">
							<div class="form-group">
								<label>私钥</label>
								<textarea name="private" rows="20" placeholder="请输入私钥"><?php if(isset($this->Unified['mc_config']['rsa']['private'])): ?><?php echo $this->Unified['mc_config']['rsa']['private'] ?><?php endif; ?></textarea>
							</div>

							<div class="form-group">
								<label>公钥</label>
								<textarea name="public" rows="20" placeholder="请输入公钥"><?php if(isset($this->Unified['mc_config']['rsa']['public'])): ?><?php echo $this->Unified['mc_config']['rsa']['public'] ?><?php endif; ?></textarea>
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