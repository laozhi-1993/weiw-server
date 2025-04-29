<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_textures');
?>
<!DOCTYPE html>
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
			}
			.search-bar input {
				width: calc(100% - 20px);
				padding: 10px;
				border: none;
				border-radius: 5px;
				background-color: #333;
				color: #e0e0e0;
				font-size: 1em;
			}
			.search-bar input::placeholder {
				color: #888;
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
				cursor: pointer;
			}
			.skin-card:hover {
				transform: translateY(-5px);
				box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7);
			}
			.skin-card img {
				width: 100%;
				height: 280px;
				object-fit: contain;
				background-color: #333;
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
		<includes-message><?php include('includes/message.html') ?></includes-message>
		<includes-scrollbar><?php include('includes/scrollbar.html') ?></includes-scrollbar>
		
		<section>
			<header>
				<h1>Minecraft 皮肤库</h1>
			</header>
			
			<main>
				<div class="search-bar">
					<input type="text" id="searchInput" placeholder="搜索皮肤...">
				</div>
				<loading-container>
					<div class="skin-grid" id="cardContainer">
						<div foreach(var.mc_textures.data,var.key,var.value) class="skin-card">
							<img src="https://mcskin.com.cn/preview/{echo:var.value.tid}?height=150" />
							<button onclick="settexture('{echo:var.value.tid}')">使用</button>
						</div>
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