<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_capes');
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
				display: grid;
				grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
				gap: 20px;
				margin: 0 auto;
			}

			.cape-item {
				background: #3d3d3d;
				border-radius: 10px;
				padding: 15px;
				transition: transform 0.3s ease;
			}

			.cape-item:hover {
				box-shadow: 0 5px 15px rgba(0, 0, 0, 0.7);
				transform: translateY(-5px);
			}

			.cape-image {
				display: flex;
				align-items: center;
				justify-content: center;
				height: 300px;
				margin-bottom: 10px;
				overflow: hidden;
				border-radius: 8px;
				background: #555;
			}

			.cape-image img {
				object-fit: cover;
			}

			.cape-name {
				font-size: 1.2rem;
				margin-bottom: 8px;
				color: #4CAF50;
			}

			.cape-description {
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
				margin-top: 40px;
				border-top: 1px solid #707070;
			}
		</style>
	</head>
	<body>
		<includes-message><?php include('includes/message.html') ?></includes-message>
		<includes-scrollbar><?php include('includes/scrollbar.html') ?></includes-scrollbar>
		
		<section>
			<header>
				<h1>披风库</h1>
				<p>探索神秘力量，装备你的专属披风</p>
			</header>
			
			<main>
				<div foreach(var.mc_capes,var.key,var.value) class="cape-item">
					<div class="cape-image">
						<img src="/weiw/preview_cape.php/150/{echo:var.value}/" />
					</div>
					
					<button class="use-button" onclick="setcape('{echo:var.value}')">使用</button>
				</div>
			</main>
			
			<footer>
				<p>声明：本项目中使用的披风材质来自互联网，所有相关版权归原作者所有。如有侵权问题，请联系我们，我们将尽快处理。</p>
			</footer>
		</section>
		
		
		<script>
			function setcape(hash)
			{
				fetch(`/weiw/index.php?mods=mc_cape&hash=${hash}`, {
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