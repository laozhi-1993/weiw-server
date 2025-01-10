<?php defined('__MKHDIR__') or die(http_response_code(403)) ?><!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<style>
			::-webkit-scrollbar {width: 10px}
			::-webkit-scrollbar {height: 10px}
			::-webkit-scrollbar-track {border-radius: 5px}
			::-webkit-scrollbar-track {background-color: #606060}
			::-webkit-scrollbar-thumb {border-radius: 5px}
			::-webkit-scrollbar-thumb {background-color: #9393ff}
			
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
			main {
				max-width: 1200px;
				margin: 0 auto;
			}
			
			.container {
				color: white;
				padding: 30px;
				background-color: #333;
				border-radius: 10px;
				animation: fadeIn 1s ease-out;
			}

			.header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 20px;
			}

			.header button {
				padding: 10px 20px;
				background-color: #FF6F61;
				color: white;
				border: none;
				border-radius: 5px;
				cursor: pointer;
				transition: background-color 0.3s;
			}

			.header button:hover {
				background-color: #FF4B3A;
			}

			.total {
				font-size: 18px;
			}

			.user-list {
				margin-top: 20px;
				animation: slideUp 0.8s ease-out;
			}

			table {
				width: 100%;
				border-collapse: collapse;
				border-radius: 8px;
				overflow: hidden;
				animation: fadeInTable 1s ease-out;
			}

			table th, table td {
				padding: 15px;
				text-align: left;
				border-bottom: 1px solid #444;
			}

			table th {
				background-color: #444;
			}

			table th:last-child {
				text-align: right;
			}

			table td:last-child {
				text-align: right;
			}

			table td {
				background-color: #555;
			}

			table tr {
				opacity: 0;
				transform: translateY(30px);
				animation: fadeInUp 0.5s forwards;
			}

			table tr:nth-child(odd) {
				animation-delay: 0.2s;
			}

			table tr:nth-child(even) {
				animation-delay: 0.4s;
			}

			.pagination {
				display: flex;
				justify-content: space-between;
				margin-top: 20px;
				font-size: 16px;
			}

			.pagination .page-info {
				color: #bbb;
			}

			.load-more {
				width: 100%;
				display: block;
				margin: 30px auto;
				padding: 10px 20px;
				background-color: #FF6F61;
				color: white;
				border: none;
				border-radius: 5px;
				cursor: pointer;
				text-align: center;
				transition: background-color 0.3s;
			}

			.load-more:hover {
				background-color: #FF4B3A;
			}

			.load-more:focus {
				outline: none;
			}

			@keyframes fadeIn {
				0% {
					opacity: 0;
					transform: translateY(-20px);
				}
				100% {
					opacity: 1;
					transform: translateY(0);
				}
			}

			@keyframes slideUp {
				0% {
					transform: translateY(30px);
					opacity: 0;
				}
				100% {
					transform: translateY(0);
					opacity: 1;
				}
			}

			@keyframes fadeInTable {
				0% {
					opacity: 0;
				}
				100% {
					opacity: 1;
				}
			}

			@keyframes fadeInUp {
				to {
					opacity: 1;
					transform: translateY(0);
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
				
				<div class="container">
					<div class="header">
						<button onclick="window.location.href='index.php'">返回首页</button>
						<div class="total">总共 <?php if(isset($this->Unified['mc_users']['number'])): ?><?php echo $this->Unified['mc_users']['number'] ?><?php endif; ?> 个用户</div>
					</div>


					<loading-container>
						<div id="userList" class="user-list">
							<table>
								<thead>
									<tr>
										<th>用户名</th>
										<th>金币数</th>
										<th>登陆时间</th>
										<th>注册时间</th>
									</tr>
								</thead>
								
								
								<tbody>
									<?php if(isset($this->Unified['mc_users']['users']) && count($this->Unified['mc_users']['users'])): ?><?php foreach($this->Unified['mc_users']['users'] as $this->Unified['key']=>$this->Unified['value']): ?><tr>
										<td><?php if(isset($this->Unified['value']['name'])): ?><?php echo $this->Unified['value']['name'] ?><?php endif; ?></td>
										<td><?php if(isset($this->Unified['value']['money'])): ?><?php echo $this->Unified['value']['money'] ?><?php endif; ?></td>
										<td><?php if(isset($this->Unified['value']['loginTime'])): ?><?php echo $this->Unified['value']['loginTime'] ?><?php endif; ?></td>
										<td><?php if(isset($this->Unified['value']['registerTime'])): ?><?php echo $this->Unified['value']['registerTime'] ?><?php endif; ?></td>
									</tr><?php endforeach; ?><?php endif; ?>
								</tbody>
							</table>


							<div class="pagination">
								<div class="page-info">第 <?php if(isset($this->Unified['mc_users']['page']['current'])): ?><?php echo $this->Unified['mc_users']['page']['current'] ?><?php endif; ?> 页 / 共 <?php if(isset($this->Unified['mc_users']['page']['total'])): ?><?php echo $this->Unified['mc_users']['page']['total'] ?><?php endif; ?> 页</div>
							</div>
						</div>
					</loading-container>


					<button class="load-more" onclick="loadingContainer()">加载更多</button>
				</div>
			</main>
		</section>

		<script src="js/main.js"></script>
		<script>
			let count = 2;
			
			
			function message(message) {
				showMessage(message);
				document.querySelector('section').scrollTop = 0;
			}
			function loadingContainer() {
				fetchAndAppendHtml(`users.php?findId=userList&current=${count}`, "loading-container", () => { count++ });
			}
		</script>
	</body>
</html>