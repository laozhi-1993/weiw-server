<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_textures');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<style>
			* {
				margin: 0;
				padding: 0;
			}

			body {
				background-color: #333;
				color: #fff;
				font-family: Arial, sans-serif;
				margin: 0;
				padding: 0;
			}

			section {
				margin: 0;
				padding: 10px;
			}

			header {
				text-align: center;
				margin: 0;
				margin-bottom: 3rem;
				position: relative;
				padding: 2rem 0;
				border-radius: 10px;
				box-shadow: 0 4px 15px rgba(0,0,0,0.3);
				background: linear-gradient(45deg, #2c3e50, #3498db);
				background: 
					linear-gradient(90deg, #3498db 0%, #3498db 100%), 
					radial-gradient(at top, rgba(255, 255, 255, 0.50) 0%, rgba(0, 0, 0, 0.55) 100%), 
					radial-gradient(at top, rgba(255, 255, 255, 0.50) 0%, rgba(0, 0, 0, 0.08) 63%);
				background-blend-mode: multiply, screen;
			}

			header h1 {
				font-size: 30px;
				letter-spacing: 2px;
				text-shadow: 2px 2px 5px rgba(0,0,0,0.5);
				color: #fff;
				margin-bottom: 0.5rem;
			}

			header::after {
				content: '';
				position: absolute;
				bottom: -20px;
				left: 50%;
				transform: translateX(-50%);
				width: 100px;
				height: 5px;
				background: #4CAF50;
				border-radius: 2px;
			}

			main {
				margin: 0 auto;
			}
			
			main loading-container {
				display: grid;
				grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
				gap: 20px;
			}

			.texture-item {
				background: #3d3d3d;
				border-radius: 10px;
				padding: 15px;
				transition: transform 0.3s ease;
			}

			.texture-item:hover {
				box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7);
				transform: translateY(-5px);
			}

			.texture-image {
				display: flex;
				align-items: center;
				justify-content: center;
				height: 300px;
				margin-bottom: 10px;
				overflow: hidden;
				border-radius: 8px;
				background: #555;
			}
			
			.texture-image img {
				width: 100%;
			}

			.texture-name {
				font-size: 1.2rem;
				margin-bottom: 8px;
				color: #4CAF50;
			}

			.texture-description {
				font-size: 0.9rem;
				margin-bottom: 12px;
				color: #ccc;
			}

			.use-button {
				background-color: #4CAF50;
				color: white;
				border: none;
				padding: 8px 20px;
				border-radius: 5px;
				cursor: pointer;
				transition: background-color 0.3s;
				width: 100%;
			}

			.use-button:hover {
				background-color: #45a049;
			}

			.use-button:active {
				background-color: #3d8b40;
			}
			
			footer {
				text-align: center;
				padding: 20px;
				color: #888;
				cursor: pointer;
				margin-top: 40px;
				border-top: 1px solid #707070;
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
		</style>
	</head>
	<body>
		<section>
			<includes-message><?php include('includes/message.html') ?></includes-message>
			<includes-scrollbar><?php include('includes/scrollbar.html') ?></includes-scrollbar>
			
			<header>
				<h1>皮肤库</h1>
				<p>探索神秘力量，装备你的专属皮肤</p>
			</header>
			
			<main>
				<loading-container id="cardContainer">
					<div foreach(var.mc_textures.data,var.key,var.value) class="texture-item">
						<div class="texture-image">
							<img src="https://mcskin.com.cn/preview/{echo:var.value.tid}?height=150" onerror="this.onerror=null; this.src='/images/placeholder.png';" />
						</div>
						
						<button class="use-button" onclick="settexture('{echo:var.value.tid}')">使用</button>
					</div>
				</loading-container>
				
				<button class="load-more" onclick="loading()">加载更多</button>
			</main>
			
			<footer onclick="window.parent.openApi('https://mcskin.com.cn/')">
				<p>声明：材质来源于我的世界红石皮肤站（mcskin），版权归原作者所有。</p>
			</footer>
		</section>
		
		
		<script>
			let count = 2;
			
			function loading() {
				fetch(`textures.php?findId=cardContainer&page=${count}`)
					.then(response => response.text())
					.then(html => {
						html = html.replace('<loading-container id="cardContainer">', '');
						html = html.replace('</loading-container>', '');
						
						count++;
						document.querySelector('loading-container').insertAdjacentHTML('beforeend', html);
					});
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