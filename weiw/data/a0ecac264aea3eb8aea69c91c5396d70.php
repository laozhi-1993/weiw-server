<?php defined('__MKHDIR__') or die(http_response_code(403)) ?><!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<style>
			body {
				font-family: 'Arial', sans-serif;
				user-select: none;
				margin: 0;
			}

			section {
				margin: 10px;
			}

			.header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 15px;
				padding: 15px;
				border-radius: 10px;
				box-shadow: 0 0 10px rgba(0, 150, 255, 0.2);
				background: 
					linear-gradient(90deg, #3d3d3d 0%, #3d3d3d 100%), 
					radial-gradient(at top, rgba(255, 255, 255, 0.50) 0%, rgba(0, 0, 0, 0.55) 100%), 
					radial-gradient(at top, rgba(255, 255, 255, 0.50) 0%, rgba(0, 0, 0, 0.08) 63%);
				background-blend-mode: multiply, screen;
			}

			.user {
				display: flex;
				justify-content: space-between;
				align-items: center;
				gap: 10px;
			}

			.user h2 {
				margin: 0;
				color: #00ff9d;
				text-shadow: 0 0 8px #00ff9d33;
			}

			.user .avatar {
				width: 60px;
				height: 60px;
				border-radius: 50%;
				border: 2px solid #00ff9d;
				box-shadow: 0 0 10px #00ff9d33;
				overflow: hidden;
				transition: transform 0.3s;
			}

			.user .avatar:hover {
				transform: rotate(15deg);
			}

			.user .money {
				color: #ffd700;
				font-size: 15px;
				font-weight: bold;
				text-shadow: 0 0 8px #ffd70066;
			}

			.preview-container {
				display: flex;
				flex-direction: column;
				gap: 10px;
				background: #2d2d2d;
				padding: 20px;
				border-radius: 10px;
				border: 1px solid #3a3a3a;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
			}

			.header-container {
				display: flex;
				justify-content: space-between;
			}

			.header-container div {
				display: flex;
				justify-content: space-between;
				align-items: center;
				gap: 10px;
			}

			.character-preview {
				width: 100%;
				height: calc(100vh - 220px);
				background: #333;
				border-radius: 5px;
				position: relative;
				overflow: hidden;
			}

			.character-preview canvas {
				position: relative;
				z-index: 1;
			}

			@keyframes rotate {
				from { transform: rotate(0deg); }
				to { transform: rotate(360deg); }
			}

			.button-container {
				display: flex;
				gap: 10px;
				justify-content: center;
			}

			.game-button {
				padding: 12px 40px;
				font-size: 18px;
				border: none;
				border-radius: 5px;
				cursor: pointer;
				transition: all 0.3s;
				position: relative;
				overflow: hidden;
				background: #2d2d2d;
				color: #fff;
				border: 1px solid #3a3a3a;
			}

			.game-button span {
				display: none;
			}

			.game-button::before {
				content: '';
				position: absolute;
				top: -50%;
				left: -50%;
				width: 200%;
				height: 200%;
				background: linear-gradient(
					45deg,
					transparent,
					rgba(255,255,255,0.2),
					transparent
				);
				transform: rotate(45deg);
				transition: all 0.5s;
			}

			.game-button:hover {
				transform: translateY(-2px);
				box-shadow: 0 5px 15px rgba(0, 150, 255, 0.4);
			}

			.game-button:active {
				transform: translateY(0px);
				box-shadow: 0 3px 10px rgba(0, 180, 216, 0.2);
			}

			.game-button:hover::before {
				left: 150%;
			}

			.start-game {
				border-color: #00ff9d;
				text-shadow: 0 0 8px #00ff9d66;
			}

			.check-in {
				border-color: #00b8ff;
				text-shadow: 0 0 8px #00b8ff66;
			}


			.uninstall-button {
				padding: 8px 20px;
				border: none;
				border-radius: 3px;
				cursor: pointer;
				font-size: 12px;
				line-height: 16px;
				transition: background-color 0.3s;
			}

			.uninstall-cape {
				background-color: #ff5555;
				color: white;
			}

			.uninstall-cape:hover {
				background-color: #ff3333;
			}

			.uninstall-skin {
				background-color: #5555ff;
				color: white;
			}

			.uninstall-skin:hover {
				background-color: #3333ff;
			}

			/* 基础按钮样式 */
			.state-button {
				padding: 8px 20px;
				border: none;
				border-radius: 3px;
				height: 32px;
				cursor: pointer;
				font-size: 12px;
				line-height: 16px;
				transition: all 0.3s ease;
			}

			/* 不同状态样式 */
			.state-default {
				background: #3a3a3a;
				color: #fff;
				box-shadow: 0 2px 8px rgba(0,0,0,0.1);
			}

			.state-run {
				background: linear-gradient(135deg, #00b4d8, #0077b6);
				color: white;
				box-shadow: 0 4px 15px rgba(0, 180, 216, 0.3);
			}

			.state-fly {
				background: linear-gradient(135deg, #ffd60a, #ff6d00);
				color: #2d2d2d;
				box-shadow: 0 4px 15px rgba(255, 214, 10, 0.3);
			}

			.checkbox-item {
				display: flex;
				align-items: center;
				justify-content: center;
				font-size: 0;
				cursor: pointer;
				width: 32px;
				height: 32px;
				border-radius: 3px;
				background: #5555ff;
				transition: all 0.3s ease;
			}

			.checkbox-item:hover {
				background: #3333ff;
				box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
			}

			.checkbox-item:active {
				transform: translateY(1px);
				box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
			}

			.checkbox-item input {
				display: none;
			}

			.checkbox-item input:checked + svg path {
				fill: #00ff00;
				filter: drop-shadow(0 0 4px rgba(255, 204, 0, 0.7));
			}

			.checkbox-item input:checked ~ svg {
				transform: scale(1.1);
			}

			.checkbox-item svg {
				width: 20px;
				height: 20px;
				transition: all 0.3s ease;
			}

			.checkbox-item svg path {
				fill: #ffffff;
				transition: all 0.3s ease;
			}
		</style>
	</head>
	<body>
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

		<section>
			<header class="header">
				<div class="user">
					<img src="/weiw/index_auth.php/avatar/<?php if(isset($this->Unified['mc_user']['SKIN']['hash'])): ?><?php echo $this->Unified['mc_user']['SKIN']['hash'] ?><?php endif; ?>/48" alt="玩家头像" class="avatar" />
					<div>
						<h2><?php if(isset($this->Unified['mc_user']['name'])): ?><?php echo $this->Unified['mc_user']['name'] ?><?php endif; ?></h2>
						<div class="money">金币：<span><?php if(isset($this->Unified['mc_user']['money'])): ?><?php echo $this->Unified['mc_user']['money'] ?><?php endif; ?></span></div>
					</div>
				</div>

				<div class="button-container">
					<button class="game-button check-in"><span>📅 每日签到</span><span>✅ 已签到</span></button>
					<button class="game-button start-game"><span>🎮 启动游戏</span><span>🎮 关闭游戏</span></button>
				</div>
			</header>

			<main class="preview-container">
				<div class="header-container">
					<div>
						<label class="checkbox-item">
							<input type="checkbox" id="elytra" />
							<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M512 64a128 128 0 0 1 84.672 224h54.336a128 128 0 0 1 117.952 78.336L992 896l-162.88-46.528a128 128 0 0 0-112 20.672L588.8 966.4a128 128 0 0 1-153.6 0l-128.32-96.256a128 128 0 0 0-112-20.672L32 896l223.04-529.664A128 128 0 0 1 372.992 288h54.336A128 128 0 0 1 512 64z" fill="#040404"></path></svg>
						</label>
						<label class="checkbox-item">
							<input type="checkbox" id="rotate" />
							<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M887.488 609.088c8.384-32.576 11.008-110.208 8.384-145.28-18.688-253.504-306.752-377.92-511.104-326.016 153.856 53.376 310.336 198.784 311.488 371.008 0.128 21.184-1.536 41.92-4.672 62.272L526.4 553.664l107.072 124.16 107.008 124.224 138.176-88.256 138.176-88.128L887.488 609.088z" fill="#7F7F7F"></path><path d="M136.128 422.144C126.848 454.4 122.368 532.032 124.032 567.104c12.224 253.952 297.088 385.536 502.656 338.88-152.512-57.344-305.216-206.592-302.016-378.752 0.448-21.184 2.624-41.92 6.272-62.08l164.672 21.376-103.808-126.72L288 232.896 147.648 317.504 7.232 402.24 136.128 422.144z" fill="#7F7F7F"></path></svg>
						</label>
						<button class="state-button state-default" id="multiStateBtn">
							<span>当前状态：漫步</span>
						</button>
					</div>
					
					<div>
						<button class="uninstall-button uninstall-cape" onclick="resettingCape()">
							<span>卸载披风</span>
						</button>
						<button class="uninstall-button uninstall-skin" onclick="resettingTexture()">
							<span>卸载皮肤</span>
						</button>
					</div>
				</div>

				<div class="character-preview" id="canvas">
					<style>
						.background {
							width: 100%;
							height: 100%;
							background: #1a1a1a;
							overflow: hidden;
							position: absolute;
						}

						/* 渐变流动背景 */
						.gradient-bg {
							position: absolute;
							top: 0;
							left: 0;
							width: 100%;
							height: 100%;
							background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1);
							background-size: 400% 400%;
							animation: gradientFlow 15s ease infinite;
							opacity: 0.3;
						}

						/* 粒子效果 */
						.particles {
							position: absolute;
							width: 100%;
							height: 100%;
						}

						.particles::before,
						.particles::after {
							content: '';
							position: absolute;
							width: 4px;
							height: 4px;
							background: rgba(255, 255, 255, 0.5);
							border-radius: 50%;
							animation: particleAnim 3s linear infinite;
						}

						.particles::before {
							top: 20%;
							left: 30%;
							box-shadow: 80px 120px rgba(255,255,255,0.5),
										-160px 200px rgba(255,255,255,0.6),
										240px 80px rgba(255,255,255,0.4);
						}

						.particles::after {
							top: 60%;
							left: 70%;
							box-shadow: -120px 80px rgba(255,255,255,0.5),
										200px 160px rgba(255,255,255,0.6),
										-80px -120px rgba(255,255,255,0.4);
						}

						/* 波浪效果 */
						.wave-container {
							display: flex;
							gap: 8px;
							position: absolute;
							bottom: 0;
							width: 100%;
							height: 100px;
						}

						.wave {
							flex: 1;
							background: rgba(255,255,255,0.1);
							border-radius: 40% 40% 0 0;
							animation: waveAnim 2s ease-in-out infinite;
						}

						/* 动画定义 */
						@keyframes gradientFlow {
							0% { background-position: 0% 50%; }
							50% { background-position: 100% 50%; }
							100% { background-position: 0% 50%; }
						}

						@keyframes particleAnim {
							50% { transform: translateY(-20px); }
							100% { transform: translateY(0); opacity: 0; }
						}

						@keyframes rotate {
							100% { transform: translate(-50%, -50%) rotate(360deg); }
						}

						@keyframes scale {
							0%, 100% { transform: scale(1) rotate(45deg); }
							50% { transform: scale(1.5) rotate(135deg); }
						}

						@keyframes waveAnim {
							0%, 100% {
								transform: translateY(0);
								border-radius: 40% 40% 0 0;
							}
							50% {
								transform: translateY(-30px);
								border-radius: 30% 30% 0 0;
							}
						}
					</style>
					<div class="background">
						<!-- 背景元素 -->
						<div class="gradient-bg"></div>
						<div class="particles"></div>
						
						<!-- 波浪效果 -->
						<div class="wave-container">
							<div class="wave" style="animation-delay: 0s"></div>
							<div class="wave" style="animation-delay: 0.2s"></div>
							<div class="wave" style="animation-delay: 0.4s"></div>
							<div class="wave" style="animation-delay: 0.6s"></div>
						</div>
					</div>
					<canvas id="skinContainer"></canvas>
				</div>
			</main>
		</section>
		
		
		<script src="js/skinview3d.bundle.js"></script>
		<script>
			const skinContainer = document.getElementById("skinContainer");
			const rotate = document.getElementById('rotate');
			const elytra = document.getElementById('elytra');
			
			const skinUrl = "/weiw/index_auth.php/texture/<?php if(isset($this->Unified['mc_user']['SKIN']['hash'])): ?><?php echo $this->Unified['mc_user']['SKIN']['hash'] ?><?php endif; ?>";
			const capeUrl = "/weiw/index_auth.php/texture/<?php if(isset($this->Unified['mc_user']['CAPE']['hash'])): ?><?php echo $this->Unified['mc_user']['CAPE']['hash'] ?><?php endif; ?>";
			
			const skinViewer = new skinview3d.SkinViewer({
				canvas: skinContainer,
				skin: skinUrl,
				cape: capeUrl,
			});
			
			const resize = function() {
				skinViewer.width  = document.getElementById("canvas").offsetWidth;
				skinViewer.height = document.getElementById("canvas").offsetHeight;
				
				return resize;
			}
			
			elytra.addEventListener('change', function() {
				if (elytra.checked)
				{
					skinViewer.loadCape(capeUrl, { backEquipment: "elytra" });
				}
				else
				{
					skinViewer.loadCape(capeUrl);
				}
			});
			rotate.addEventListener('change', () => skinViewer.autoRotate = rotate.checked);
			action(0);
			window.onresize = resize();
			
			
			
			function action(type)
			{
				//IdleAnimation     动胳膊
				//WalkingAnimation  走步
				//RunningAnimation  跑步
				//FlyingAnimation   飞行
				//CrouchAnimation   蹲下
				//WaveAnimation     挥手
				
				if(type === 0)
				{
					skinViewer.animation = new skinview3d.WalkingAnimation();
					skinViewer.animation.speed = 1;
				}
				else if(type === 1)
				{
					skinViewer.animation = new skinview3d.RunningAnimation();
					skinViewer.animation.speed = 0.5;
				}
				else if(type === 2)
				{
					skinViewer.animation = new skinview3d.FlyingAnimation();
					skinViewer.animation.speed = 1;
				}
				else if(type === 3)
				{
					skinViewer.animation = new skinview3d.IdleAnimation();
					skinViewer.animation.speed = 1;
				}
			}
			
			
			// 多状态按钮逻辑
			const states = [
				{ 
					name: '当前状态：漫步',
					style: 'state-default'
				},
				{
					name: '当前状态：跑步',
					style: 'state-run'
				},
				{
					name: '当前状态：飞行',
					style: 'state-fly'
				}
			];
			
			let currentState = 0;
			const multiStateBtn = document.getElementById('multiStateBtn');
			
			multiStateBtn.addEventListener('click', () => {
				currentState = (currentState + 1) % states.length;
				action(currentState);
				
				multiStateBtn.className = `state-button ${states[currentState].style}`;
				multiStateBtn.querySelector('span:last-child').textContent = states[currentState].name;
			});
			
			
			function resettingCape()
			{
				fetch('/weiw/index.php?mods=mc_cape_resetting').then(() => location.reload()).catch(error => showMessage(error));
			}
			
			function resettingTexture()
			{
				fetch('/weiw/index.php?mods=mc_texture_resetting').then(() => location.reload()).catch(error => showMessage(error));
			}
			
			
			function maincheckin()
			{
				document.querySelector(".check-in").querySelectorAll('span')[0].style.display = 'inline';
				document.querySelector(".check-in").querySelectorAll('span')[1].style.display = 'none';
				
				fetch("/weiw/index.php?mods=mc_checkin")
					.then(response => response.json())
					.then(result => {
						if (result.count_down !== 0)
						{
							document.querySelector(".check-in").querySelectorAll('span')[0].style.display = 'none';
							document.querySelector(".check-in").querySelectorAll('span')[1].style.display = 'inline';
						}
					});
				
				return function () {
					fetch("/weiw/index.php?mods=mc_checkin&checkin=1")
						.then(response => response.json())
						.then(result => {
							if (result.error === "ok") {
								document.querySelector(".money span").innerHTML = result.money;
								document.querySelector(".check-in").querySelectorAll('span')[0].style.display = 'none';
								document.querySelector(".check-in").querySelectorAll('span')[1].style.display = 'inline';
							}
						});
				}
			}
			
			document.querySelector('.check-in').onclick = maincheckin();
			document.querySelector(".start-game").onclick = function() {
				const client = <?php echo json_encode($this->Unified['mc_client_data']) ?>;
				
				if (client) {
					window.parent.start(client);
				} else {
					window.parent.customConfirm('没有客户端配置', () => {});
				}
			}
			
			window.parent.addEventListener("start", () => {
				document.querySelector(".start-game").querySelectorAll('span')[0].style.display = 'none';
				document.querySelector(".start-game").querySelectorAll('span')[1].style.display = 'inline';
			});
			window.parent.addEventListener("exit", () => {
				document.querySelector(".start-game").querySelectorAll('span')[0].style.display = 'inline';
				document.querySelector(".start-game").querySelectorAll('span')[1].style.display = 'none';
			});
		</script>
	</body>
</html>