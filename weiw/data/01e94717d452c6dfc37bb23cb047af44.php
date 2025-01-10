<?php defined('__MKHDIR__') or die(http_response_code(403)) ?><!DOCTYPE html>
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
		body {overflow-y: scroll}
		body {padding-right: 5px}
		body {margin: 0}
	</style></includes-scrollbar>
			
			<div class="container">
				<h1>道具列表</h1>

				<?php if(isset($this->Unified['mc_items']) && count($this->Unified['mc_items'])): ?><?php foreach($this->Unified['mc_items'] as $this->Unified['key']=>$this->Unified['value']): ?><div id="<?php if(isset($this->Unified['value']['name'])): ?><?php echo $this->Unified['value']['name'] ?><?php endif; ?>" class="item">
					<div class="item-name"><?php if(isset($this->Unified['value']['name'])): ?><?php echo $this->Unified['value']['name'] ?><?php endif; ?></div>
					<div class="item-price">¥<?php if(isset($this->Unified['value']['price'])): ?><?php echo $this->Unified['value']['price'] ?><?php endif; ?></div>
					<button class="buy-btn" onclick="determine('<?php if(isset($this->Unified['value']['name'])): ?><?php echo $this->Unified['value']['name'] ?><?php endif; ?>','<?php if(isset($this->Unified['value']['name'])): ?><?php echo $this->Unified['value']['name'] ?><?php endif; ?>','<?php if(isset($this->Unified['value']['price'])): ?><?php echo $this->Unified['value']['price'] ?><?php endif; ?>')">购买</button>
				</div><?php endforeach; ?><?php endif; ?>
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