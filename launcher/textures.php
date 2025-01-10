<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_textures');
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<style>
			main {
				max-width: 1200px;
				margin: 0 auto;
				padding: 10px;
				color: white;
				text-align: center;
			}
			button {
				user-select: none;
			}
			
			/* 页头信息容器 */
			.header-info {
				background-color: rgba(255, 255, 255, 0.1);
				padding: 20px;
				border-radius: 10px;
				margin-bottom: 30px;
				cursor: pointer;
				opacity: 0;
				animation: fadeIn 1s forwards;
			}

			.header-info p {
				font-size: 18px;
				margin: 0;
				color: #ddd;
			}

			/* 皮肤库标题样式 */
			h1 {
				font-size: 36px;
				margin-bottom: 40px;
				text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
				opacity: 0;
				animation: fadeIn 1s forwards;
			}

			/* 容器样式 */
			.card-container {
				display: grid;
				grid-template-columns: repeat(4, 1fr);
				gap: 20px;
				padding: 20px;
				margin-top: 20px;
				background-color: rgba(255, 255, 255, 0.1);
				border-radius: 10px;
				box-sizing: border-box;
				opacity: 0;
				animation: fadeIn 1s forwards; /* 添加容器动画 */
			}

			/* 每个皮肤卡片样式 */
			.card {
				display: flex;
				flex-direction: column;
				gap: 20px;
				background-color: rgba(255, 255, 255, 0.2);
				border-radius: 10px;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
				padding: 15px;
				opacity: 0;
				animation: fadeInCard 0.5s ease-out forwards; /* 给每个卡片添加动画 */
				transition: transform 0.3s ease, box-shadow 0.3s ease; /* 添加鼠标经过时的动画 */
			}

			.card:hover {
				transform: scale(1.05); /* 鼠标悬停时轻微放大 */
				box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3); /* 增加阴影效果 */
			}

			.card img {
				width: 100%;
				object-fit: cover;
				border-radius: 10px;
			}

			.card .use-skin-btn {
				margin-top: auto;
				padding: 10px 20px;
				background-color: #4CAF50;
				color: white;
				border: none;
				border-radius: 5px;
				cursor: pointer;
				transition: background-color 0.3s;
				width: 100%; /* 按钮宽度 100% */
			}

			.card .use-skin-btn:hover {
				background-color: #45a049;
			}

			.load-more-btn {
				width: 100%;
				padding: 12px 25px;
				background-color: #007BFF;
				color: white;
				border: none;
				border-radius: 5px;
				font-size: 18px;
				cursor: pointer;
				margin-top: 20px;
				transition: background-color 0.3s;
				opacity: 0; /* 初始透明 */
				animation: fadeInLoadMore 1s forwards; /* 添加加载更多按钮动画 */
			}

			.load-more-btn:hover {
				background-color: #0056b3;
			}

			/* 动画效果 */
			@keyframes fadeIn {
				from {
					opacity: 0;
				}
				to {
					opacity: 1;
				}
			}

			@keyframes fadeInCard {
				from {
					opacity: 0;
					transform: translateY(30px); /* 卡片从下方渐显 */
				}
				to {
					opacity: 1;
					transform: translateY(0); /* 卡片最终位置 */
				}
			}

			@keyframes fadeInLoadMore {
				from {
					opacity: 0;
					transform: translateY(30px); /* 按钮从下方渐显 */
				}
				to {
					opacity: 1;
					transform: translateY(0); /* 按钮最终位置 */
				}
			}
		</style>
	</head>
	<body>
		<main>
			<includes-message><?php include('includes/message.html') ?></includes-message>
			<includes-scrollbar><?php include('includes/scrollbar.html') ?></includes-scrollbar>
			
			<!-- 页头信息容器 -->
			<div class="header-info" onclick="window.parent.openApi('https://mcskin.com.cn/')">
				<p>材质来源于我的世界红石皮肤站。</p>
			</div>
			
			<!-- 皮肤库标题 -->
			<h1>皮肤库</h1>

			<!-- 皮肤卡片容器 -->
			<loading-container>
				<div id="cardContainer" class="card-container">
					<div foreach(var.mc_textures.data,var.key,var.value) class="card">
						<img src="https://mcskin.com.cn/preview/{echo:var.value.tid}?height=150">
						<button class="use-skin-btn" onclick="settexture('{echo:var.value.tid}')">使用皮肤</button>
					</div>
				</div>
			</loading-container>

			<!-- 加载更多按钮 -->
			<button class="load-more-btn" onclick="loadingContainer()">加载更多</button>
		</main>
		
		
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
					if (data.type != "cape") {
						window.parent.document.querySelector("#avatar img").src = `/weiw/index_auth.php/avatar/${data.hash}/48`;
					}
					
					showMessage('使用成功');
				})
				.catch(error => {
					showMessage(error);
				});
			}
		</script>
	</body>
</html>