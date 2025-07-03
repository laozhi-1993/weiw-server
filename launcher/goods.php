<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_items');
	$MKH ->mods('mc_user');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<style>
			body {
				margin: 0;
				padding: 0;
				font-family: 'Segoe UI', system-ui, sans-serif;
			}

			section {
				margin: 0 auto;
				padding: 10px;
			}

			header {
				padding-bottom: 20px;
				margin-bottom: 30px;
				position: relative;
			}
			header::after {
				content: '';
				position: absolute;
				bottom: 0;
				left: 50%;
				transform: translateX(-50%);
				width: 80%;
				height: 2px;
				background: linear-gradient(90deg, transparent 0%, #6C5CE7 50%, transparent 100%);
			}

			.gold-info {
				display: flex;
				justify-content: space-between;
				align-items: center;
				padding: 15px 25px;
				border-radius: 12px;
				border: 1px solid #404040;
				box-shadow: 0 0 10px rgba(0, 150, 255, 0.2);
				background: 
					linear-gradient(90deg, #3d3d3d 0%, #3d3d3d 100%), 
					radial-gradient(at top, rgba(255, 255, 255, 0.50) 0%, rgba(0, 0, 0, 0.55) 100%), 
					radial-gradient(at top, rgba(255, 255, 255, 0.50) 0%, rgba(0, 0, 0, 0.08) 63%);
				background-blend-mode: multiply, screen;
				animation: float 4s ease-in-out infinite;
			}

			.gold-info h1 {
				color: #7f5af0;
				font-size: 1.8em;
				letter-spacing: 2px;
				text-shadow: 2px 2px 5px rgba(0,0,0,0.5);
			}

			.current-gold {
				display: flex;
				align-items: center;
				color: #ffd700;
				font-weight: bold;
				font-size: 1.3em;
			}

			.current-gold::before {
				content: '🪙';
			}

			.items-container {
				display: grid;
				grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
				gap: 20px;
				margin: 40px 0;
			}

			.item-card {
				display: grid;
				overflow: hidden;
				padding: 20px;
				position: relative;
				background: linear-gradient(145deg, #444 0%, #1f1f1f 100%);
				border-radius: 10px;
				border: 1px solid #3d3d3d;
				transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
			}

			h4 {
				color: #e0e0e0;
			}

			.item-card:hover {
				transform: translateY(-8px);
				box-shadow: 0 12px 30px rgba(0, 0, 0, 0.4);
			}

			.item-icon {
				display: flex;
				align-items: center;
				justify-content: center;
				height: 200px;
				background: #4d4d4d;
				border-radius: 10px;
				margin-bottom: 15px;
				overflow: hidden;
			}

			.item-icon img {
				max-width: 80%;
				max-height: 80%;
				object-fit: cover;
				transition: transform 0.3s ease;
			}

			.item-name {
				color: #fff;
				font-size: 1.3em;
				margin: 10px 0;
				font-weight: 600;
			}

			.item-description {
				color: #b0b0b0;
				font-size: 0.95em;
				line-height: 1.5;
				min-height: 60px;
			}

			.item-footer {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-top: auto;
				padding-top: 15px;
				border-top: 1px solid #555;
			}

			.item-price {
				color: #ffd700;
				font-weight: bold;
				display: flex;
				align-items: center;
				gap: 6px;
			}

			.buy-button {
				background: linear-gradient(135deg, #7f5af0 0%, #6c42de 100%);
				border: none;
				border-radius: 5px;
				color: white;
				cursor: pointer;
				padding: 10px 25px;
				font-weight: 500;
				text-transform: uppercase;
				letter-spacing: 0.5px;
				transition: all 0.3s ease;
			}

			.buy-button:hover {
				box-shadow: 0 4px 15px rgba(127, 90, 240, 0.3);
			}

			.buy-button:active {
				transform: translateY(0);
				filter: brightness(0.9);
			}

			footer {
				text-align: center;
				padding: 20px;
				color: #888;
				margin-top: 40px;
				border-top: 1px solid #707070;
			}

			@keyframes float {
				0%, 100% { transform: translateY(0); }
				50% { transform: translateY(-5px); }
			}
		</style>
	</head>
	<body>
		<section>
			<includes-message><?php include('includes/message.html') ?></includes-message>
			<includes-scrollbar><?php include('includes/scrollbar.html') ?></includes-scrollbar>

			<header>
				<div class="gold-info">
					<h1>村民商店</h1>
					<div class="current-gold">{echo:var.mc_user.money}</div>
				</div>
			</header>

			<main class="items-container">
				<div foreach(var.mc_items,var.key,var.value) id="{echo:var.value.name}" class="item-card">
					<div class="item-icon">
						<img src="{echo:var.value.icon}" />
					</div>
					<h4>{echo:var.value.name}</h4>
					
					<div class="item-footer">
						<span class="item-price">价格: {echo:var.value.price}</span>
						<button class="buy-button" onclick="determine('{echo:var.value.name}','{echo:var.value.name}','{echo:var.value.price}')">购买</button>
					</div>
				</div>
			</main>

			<footer>
				<p>村民商店 - 禁忌的知识需要代价</p>
			</footer>
		</section>


		<script>
			function determine(id,name,price)
			{
				window.parent.showConfirm(`你确定要花费 ${price} 购买 ${name} 吗？`, function(result) {
					if (result) {
						fetch(`/weiw/index.php?mods=mc_items_purchase&id=${id}`, {
							method: 'GET',
						})
						.then(response => response.json())
						.then(data => {
							showMessage(data.error);
							if (data.money) document.querySelector(".current-gold").innerHTML = data.money;
						})
						.catch(error => {
							showMessage(error);
						});
					}
				});
			}
		</script>
	</body>
</html>