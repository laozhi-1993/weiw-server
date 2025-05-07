<?php defined('__MKHDIR__') or die(http_response_code(403)) ?><!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<style>
			body {
				margin: 0;
				padding: 0;
			}
			section {
				border-radius: 10px;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
				background-color: #1a1a1a;
				overflow: hidden;
				color: #e0e0e0;
				font-family: 'Arial', sans-serif;
				margin: 10px;
			}
			header {
				background-color: #2a2a2a;
				padding: 20px;
				text-align: center;
				box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
			}
			header h1 {
				margin: 0;
				font-size: 2.5em;
				color: #4CAF50;
			}
			main {
				padding: 20px;
			}
			.search-bar {
				margin: 20px auto;
				max-width: 600px;
				display: flex;
				gap: 10px;
			}
			.search-bar input {
				width: calc(100% - 20px);
				padding: 10px;
				border: none;
				border-radius: 5px;
				background-color: #333;
				color: #e0e0e0;
				font-size: 1em;
				flex: 1;
			}
			.search-bar input::placeholder {
				color: #888;
			}
			.search-bar button {
				padding: 10px 20px;
				border: none;
				border-radius: 5px;
				background-color: #333;
				color: #e0e0e0;
				font-size: 1em;
				cursor: pointer;
				transition: background-color 0.2s;
			}
			.search-bar button:hover {
				background-color: #555;
			}
			.skin-grid {
				display: grid;
				grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
				gap: 20px;
				max-width: 2200px;
				margin: 20px auto;
			}
			.skin-card {
				background-color: #2a2a2a;
				border-radius: 10px;
				overflow: hidden;
				transition: transform 0.3s, box-shadow 0.3s;
			}
			.skin-card:hover {
				transform: translateY(-5px);
				box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7);
			}
			.skin-image {
				display: flex;
				cursor: pointer;
				align-items: center;
				justify-content: center;
				overflow: hidden;
				background-color: #333;
				height: 280px;
			}
			.skin-card img {
				width: 100%;
			}
			.skin-card button {
				display: block;
				width: calc(100% - 20px);
				margin: 10px auto;
				padding: 8px;
				background-color: #4CAF50;
				color: #fff;
				border: none;
				border-radius: 5px;
				cursor: pointer;
				font-size: 0.9em;
				transition: background-color 0.3s;
			}
			.skin-card button:hover {
				background-color: #45a049;
			}
			.load-more {
				display: block;
				width: 300px;
				margin: 20px auto;
				padding: 10px 20px;
				background-color: #4CAF50;
				color: #fff;
				border: none;
				border-radius: 5px;
				cursor: pointer;
				font-size: 1em;
				transition: background-color 0.3s;
			}
			.load-more:hover {
				background-color: #45a049;
			}
			.load-more.hidden {
				display: none;
			}
			footer {
				background-color: #2a2a2a;
				text-align: center;
				padding: 10px;
				color: #888;
				cursor: pointer;
				margin-top: 20px;
			}
		</style>
	</head>
	<body>
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
		<includes-scrollbar>	<style>
		::-webkit-scrollbar {width: 10px}
		::-webkit-scrollbar {height: 10px}
		::-webkit-scrollbar-track {border-radius: 5px}
		::-webkit-scrollbar-track {background-color: #606060}
		::-webkit-scrollbar-thumb {border-radius: 5px}
		::-webkit-scrollbar-thumb {background-color: #9393ff}
	</style></includes-scrollbar>
		
		<section>
			<header>
				<h1>Minecraft 皮肤库</h1>
			</header>
			
			<main>
				<loading-container>
					<div class="skin-grid" id="cardContainer">
						<?php if(isset($this->Unified['mc_textures']['data']) && count($this->Unified['mc_textures']['data'])): ?><?php foreach($this->Unified['mc_textures']['data'] as $this->Unified['key']=>$this->Unified['value']): ?><div class="skin-card">
							<div class="skin-image">
								<img src="https://mcskin.com.cn/preview/<?php if(isset($this->Unified['value']['tid'])): ?><?php echo $this->Unified['value']['tid'] ?><?php endif; ?>?height=150" onerror="this.onerror=null; this.src='/images/placeholder.png';" />
							</div>
							
							<button onclick="settexture('<?php if(isset($this->Unified['value']['tid'])): ?><?php echo $this->Unified['value']['tid'] ?><?php endif; ?>')">使用</button>
						</div><?php endforeach; ?><?php endif; ?>
					</div>
				</loading-container>
				<button class="load-more"  onclick="loadingContainer()">加载更多</button>
			</main>
			
			<footer onclick="window.parent.openApi('https://mcskin.com.cn/')">
				<p>声明：材质来源于我的世界红石皮肤站（mcskin），版权归原作者所有。</p>
			</footer>
		</section>
		
		
		<script src="js/main.js"></script>
		<script>
			let count = 2;
			
			function loadingContainer() {
				fetchAndAppendHtml(`textures.php?findId=cardContainer&page=${count}`, "loading-container", () => { count++ });
			}
			
			function settexture(id)
			{
				fetch(`/weiw/index.php?mods=mc_texture&id=${id}`, {
					method: 'GET',
				})
				.then(response => response.json())
				.then(data => {
					showMessage('使用成功');
				})
				.catch(error => {
					showMessage(error);
				});
			}
		</script>
	</body>
</html>