<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_items');
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<style>
			main {
				margin: 0 auto;
				padding: 10px;
				color: white;
			}
			button {
				user-select: none;
			}
			
			.container {
				padding: 20px;
				border-radius: 10px;
				background: rgba(255, 255, 255, 0.1);
				box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
				animation: fadeIn 1s ease-out;
			}

			h1 {
				text-align: center;
				font-size: 2em;
				margin-bottom: 30px;
				text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
			}

			.item {
				display: flex;
				justify-content: space-between;
				align-items: center;
				background: rgba(255, 255, 255, 0.2);
				margin: 15px 0;
				padding: 15px;
				border-radius: 8px;
				opacity: 0;
				animation: fadeInUp 0.5s forwards;
				transition: transform 0.3s ease, background-color 0.3s ease;
			}

			@keyframes fadeIn {
				from { opacity: 0; }
				to { opacity: 1; }
			}

			@keyframes fadeInUp {
				from { opacity: 0; transform: translateY(20px); }
				to { opacity: 1; transform: translateY(0); }
			}

			.item:nth-child(even) {
				animation-delay: 0.2s;
			}

			.item:nth-child(odd) {
				animation-delay: 0.4s;
			}

			/* 鼠标经过时的动画 */
			.item:hover {
				background: rgba(255, 255, 255, 0.3);
				box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
				transform: translateY(-5px);
			}

			.item-name {
				font-size: 1em;
				font-weight: 100;
				flex-grow: 1; /* 让名称部分占据剩余空间 */
			}

			.item-price {
				font-size: 1em;
				margin-right: 20px;
				text-align: right; /* 确保价格在右边 */
			}

			.buy-btn {
				background: #ff5722;
				color: white;
				padding: 10px 20px;
				border: none;
				border-radius: 5px;
				cursor: pointer;
				transition: background 0.3s ease, transform 0.3s ease;
			}

			.buy-btn:hover {
				background: #ff7043;
				transform: scale(1.2);
			}

			.item-price, .buy-btn {
				margin-left: 10px;
			}
		</style>
	</head>
	<body>
		<main>
			<includes-message><?php include('includes/message.html') ?></includes-message>
			<includes-scrollbar><?php include('includes/scrollbar.html') ?></includes-scrollbar>
			
			<div class="container">
				<h1>道具列表</h1>

				<div foreach(var.mc_items,var.key,var.value) id="{echo:var.value.name}" class="item">
					<div class="item-name">{echo:var.value.name}</div>
					<div class="item-price">¥{echo:var.value.price}</div>
					<button class="buy-btn" onclick="determine('{echo:var.value.name}','{echo:var.value.name}','{echo:var.value.price}')">购买</button>
				</div>
			</div>
		</main>
		
		
		<script>
			function determine(id,name,price)
			{
				window.parent.customConfirm(`你确定要花费 ${price} 购买 ${name} 吗？`, function(result) {
					if (result) {
						fetch(`/weiw/index.php?mods=mc_items_purchase&id=${id}`, {
							method: 'GET',
						})
						.then(response => response.json())
						.then(data => {
							window.parent.setMoney(data.money);
							showMessage(data.error);
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