<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_verify_access');
	$MKH ->mods('mc_client_list');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>客户端列表</title>
		<style>
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
				font-family: 'Segoe UI', system-ui, sans-serif;
			}
			
			body {
				background-color: #333;
				color: #f0f0f0;
				line-height: 1.6;
				padding: 10px;
				min-height: 100vh;
			}
			
			.container {
				margin: 0 auto;
				margin-top: 70px;
			}
			
			header {
				position: fixed;
				top: 0;
				z-index: 99;
				width: calc(100% - 20px);
				margin-bottom: 30px;
				padding-bottom: 15px;
				border-bottom: 1px solid #444;
				background-color: #333;
			}
			
			.header-controls {
				display: flex;
				align-items: center;
				justify-content: space-between;
			}
			
			.search-container {
				position: relative;
				width: calc(100% - 280px);
			}
			
			.search-container svg {
				position: absolute;
				left: 12px;
				top: 50%;
				transform: translateY(-50%);
				width: 18px;
			}
			
			.search-container path {
				fill: #888;
			}
			
			#search-input {
				width: 100%;
				padding: 12px 12px 12px 40px;
				border-radius: 8px;
				border: 1px solid #555;
				background-color: #444;
				color: #fff;
				font-size: 15px;
				transition: all 0.3s;
			}
			
			#search-input:focus {
				outline: none;
				border-color: #4a9eff;
				box-shadow: 0 0 0 2px rgba(74, 158, 255, 0.2);
			}
			
			.client-count {
				text-align: center;
				background-color: #444;
				color: #36BBA7;
				padding: 10px;
				border-radius: 25px;
				font-weight: 500;
				font-size: 15px;
				width: 250px;
				white-space: nowrap;
			}
			
			.client-count svg {
				vertical-align: middle;
				margin-bottom: 2.5px;
				width: 18px;
			}
			
			.client-count path {
				fill: #36BBA7;
			}
			
			main {
				min-height: calc(100vh - 170px);
			}
			
			
			.list-header {
				display: grid;
				grid-template-columns: 2fr 0.5fr 0.5fr 0.5fr;
				padding: 15px 20px;
				margin-bottom: 20px;
				background: #3a3a3a;
				border-radius: 8px 8px 0 0;
				border-bottom: 1px solid #555;
				font-weight: 600;
				color: #46ECD5;
				border-top: 3px solid #F5B027;
			}
			
			.list-header div:last-child {
				text-align: right;
			}
			
			.entries-list {
				display: flex;
				flex-direction: column;
				gap: 12px;
			}
			.entries-list.hidden {
				display: none;
			}
			
			.entry-item {
				display: grid;
				grid-template-columns: 2fr 0.5fr 0.5fr 0.5fr;
				background: #3a3a3a;
				padding: 15px 20px;
				border-radius: 8px;
				transition: all 0.3s;
				border-left: 4px solid #4a6fa5;
				border-right: 4px solid #4a6fa5;
			}
			
			.entry-item div:last-child {
				text-align: right;
			}
			
			.entry-item:hover {
				background: #444;
				transform: translateY(-2px);
				box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
			}
			
			.entry-name {
				font-size: 1rem;
				font-weight: 500;
				color: #8EC5FF;
				line-height: 40px;
			}
			
			.entry-name svg {
				vertical-align: middle;
				margin-right: 5px;
				width: 25px;
			}
			
			.entry-name path {
				fill: #4a9c5f;
			}
			
			.entry-name div:last-child {
				text-align: right;
			}
			
			.entry-version {
				display: flex;
				align-items: center;
			}
			
			.version-badge {
				padding: 3px 15px;
				color: #ff934a;
				border-radius: 4px;
				background: #444;
				font-size: 0.9rem;
				font-weight: 500;
			}
			
			.entry-loader {
				display: flex;
				align-items: center;
				gap: 8px;
			}
			
			.loader-badge {
				padding: 3px 15px;
				color: #8a7bff;
				border-radius: 5px;
				background: #444;
				font-size: 0.9rem;
				font-weight: 500;
			}
			
			.launch-btn {
				background: #4a6bff;
				color: white;
				border: none;
				padding: 10px 30px;
				border-radius: 6px;
				cursor: pointer;
				font-size: 1rem;
				font-weight: 500;
				transition: all 0.2s;
				max-width: 140px;
			}
			
			.launch-btn:hover {
				background: #4a9bff;
				transform: scale(1.05);
			}
			
			.launch-btn:active {
				transform: scale(0.98);
			}
			
			
			.empty-state {
				display: flex;
				align-items: center;
				justify-content: center;
				text-align: center;
				padding: 60px 20px;
				color: #aaa;
				user-select: none;
				height: calc(100vh - 250px);
				background: #3a3a3a;
				border-radius: 10px;
			}
			
			.empty-state svg {
				height: 60px;
				margin-bottom: 15px;
			}
			
			.empty-state path {
				fill: #666;
			}
			
			.empty-state h3 {
				font-style: italic;
				font-size: 20px;
				margin-bottom: 10px;
			}
			
			footer {
				background: #3a3a3a;
				border-radius: 0 0 8px 8px;
				border-top: 1px solid #555;
				margin-top: 20px;
				text-align: center;
				color: #36BBA7;
				min-height: 60px;
				font-size: 14px;
				padding: 20px;
				border-top: 1px solid #555;
				border-bottom: 3px solid #F5B027;
			}
			
			.overlay-container {
				display: flex;
				align-items: center;
				justify-content: center;
				text-align: center;
				user-select: none;
				height: calc(100vh - 250px);
				background: #3a3a3a;
				border-radius: 10px;
			}
			.overlay-container.hidden {
				display: none;
			}
			
			.game-status {
				font-size: 4.5rem;
				color: #4CAF50;
				margin-bottom: 20px;
				text-shadow: 0 0 15px rgba(76, 175, 80, 0.5);
				font-weight: bold;
			}
			
			.close-btn {
				background: linear-gradient(135deg, #f44336, #c62828);
				color: white;
				border: none;
				padding: 10px 30px;
				font-size: 1rem;
				font-weight: bold;
				border-radius: 12px;
				cursor: pointer;
				transition: all 0.3s ease;
				box-shadow: 0 6px 0 #8B0000, 0 0 0 rgba(0, 0, 0, 0.3);
				margin-top: 20px;
				margin-bottom: 100px;
			}
			
			.close-btn:hover {
				transform: translateY(-3px);
				box-shadow: 0 9px 0 #8B0000, 0 12px 25px rgba(0, 0, 0, 0.4);
			}
			
			.close-btn:active {
				transform: translateY(2px);
				box-shadow: 0 4px 0 #8B0000, 0 6px 15px rgba(0, 0, 0, 0.3);
			}
		</style>
	</head>
	<body>
		<includes-message><?php include('includes/message.html') ?></includes-message>
		<includes-scrollbar><?php include('includes/scrollbar.html') ?></includes-scrollbar>
		
		<div class="container">
			<header>
				<div class="header-controls">
					<div class="search-container">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M415.59889935 818.40673751c-103.69194019 0-207.38388041-39.48836529-286.31642412-118.42090898-157.86508737-157.87981634-157.86508737-414.78248979 0-572.66230613 157.85035841-157.85035841 414.76776082-157.90927428 572.64757719 0 157.86508737 157.87981634 157.86508737 414.78248979 0 572.66230613-78.93254368 78.93254368-182.63921287 118.42090898-286.33115307 118.42090898z m0-725.22496474c-82.09927197 0-164.21327292 31.25487175-226.70828746 93.74988629-125.00475803 125.00475803-125.00475803 328.44127481 0 453.44603281 125.01948701 124.9753001 328.41181686 125.03421596 453.43130386 0 125.00475803-125.00475803 125.00475803-328.44127481 0-453.44603281-62.5097435-62.49501453-144.60901547-93.74988627-226.7230164-93.74988629z" fill="#2c2c2c"></path><path d="M973.48804978 1013.69813456c-10.78160515 0-21.57793927-4.10938229-29.79670383-12.34287584L658.31757585 715.95203069c-16.46698708-16.46698708-16.46698708-43.14114955 0-59.60813666s43.14114955-16.46698708 59.60813665 0l285.37377009 285.38849908c16.46698708 16.46698708 16.46698708 43.14114955 0 59.60813663a42.07329932 42.07329932 0 0 1-29.81143281 12.35760482z" fill="#2c2c2c"></path></svg>
						<input type="text" id="search-input" placeholder="搜索客户端名称、版本或加载器类型...">
					</div>
					<div class="client-count">
						<svg viewBox="0 0 1096 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M1025.803074 589.061324a70.661019 70.661019 0 0 1-70.661019 69.442726H141.322039a70.661019 70.661019 0 0 1-70.66102-69.442726V136.465312A70.661019 70.661019 0 0 1 141.322039 67.022586h813.820016a70.661019 70.661019 0 0 1 70.661019 69.442726zM990.472565 0.016447H105.991529A104.164089 104.164089 0 0 0 0 102.353096v595.136344a102.945795 102.945795 0 0 0 105.991529 101.118355h884.481036A102.945795 102.945795 0 0 0 1096.464094 697.48944V102.353096A104.164089 104.164089 0 0 0 990.472565 0.016447z m-282.644078 953.314615v-89.544568H389.244753v92.590301l-64.569552 33.50307s-21.320135 34.721363 10.355494 34.112216h426.402703s29.239042-14.010375 14.619522-28.629896a487.317375 487.317375 0 0 0-68.224433-42.031123z" fill="#616682"></path></svg>
						<span id="total-clients">0</span>
						<span>个客户端</span>
					</div>
				</div>
			</header>
			
			<main>
				<div class="list-header">
					<div>客户端名称</div>
					<div>版本</div>
					<div>加载器类型</div>
					<div>操作</div>
				</div>
				
				<div class="entries-list" id="client-list">
					<!-- 客户端列表将通过JavaScript动态生成 -->
				</div>
				
				<div class="overlay-container">
					<div>
						<div class="game-status">已启动我的世界</div>
						<button class="close-btn" onclick="start();playCloseSound()">结束游戏</button>
					</div>
				</div>
			</main>
			
			<footer>
				<p></p>
			</footer>
		</div>
		
		
		<script>
			// 模拟启动音效
			function playStartSound() {
				// 在实际应用中，这里会播放音频文件
				console.log('播放启动音效...');
				
				// 创建简单的音频上下文音效
				try {
					const audioContext = new (window.AudioContext || window.webkitAudioContext)();
					const oscillator = audioContext.createOscillator();
					const gainNode = audioContext.createGain();
					
					oscillator.connect(gainNode);
					gainNode.connect(audioContext.destination);
					
					oscillator.frequency.setValueAtTime(523.25, audioContext.currentTime); // C5
					oscillator.frequency.setValueAtTime(659.25, audioContext.currentTime + 0.1); // E5
					oscillator.frequency.setValueAtTime(783.99, audioContext.currentTime + 0.2); // G5
					
					gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
					gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
					
					oscillator.start(audioContext.currentTime);
					oscillator.stop(audioContext.currentTime + 0.5);
				} catch (e) {
					console.log('音频上下文不支持或已禁用');
				}
			}
			
			// 模拟关闭音效
			function playCloseSound() {
				console.log('播放关闭音效...');
				
				try {
					const audioContext = new (window.AudioContext || window.webkitAudioContext)();
					const oscillator = audioContext.createOscillator();
					const gainNode = audioContext.createGain();
					
					oscillator.connect(gainNode);
					gainNode.connect(audioContext.destination);
					
					oscillator.frequency.setValueAtTime(783.99, audioContext.currentTime); // G5
					oscillator.frequency.setValueAtTime(659.25, audioContext.currentTime + 0.1); // E5
					oscillator.frequency.setValueAtTime(523.25, audioContext.currentTime + 0.2); // C5
					
					gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
					gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
					
					oscillator.start(audioContext.currentTime);
					oscillator.stop(audioContext.currentTime + 0.5);
				} catch (e) {
					console.log('音频上下文不支持或已禁用');
				}
			}
			
			
			// 客户端数据
			const clients = {json: var.mc_client_list};
			
			// 渲染客户端列表
			function renderClientList(filteredClients = clients) {
				const clientList = document.getElementById('client-list');
				
				// 更新客户端数量
				document.getElementById('total-clients').textContent = filteredClients.length;
				
				if (filteredClients.length === 0) {
					clientList.innerHTML = `
						<div class="empty-state">
							<div>
								<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M415.59889935 818.40673751c-103.69194019 0-207.38388041-39.48836529-286.31642412-118.42090898-157.86508737-157.87981634-157.86508737-414.78248979 0-572.66230613 157.85035841-157.85035841 414.76776082-157.90927428 572.64757719 0 157.86508737 157.87981634 157.86508737 414.78248979 0 572.66230613-78.93254368 78.93254368-182.63921287 118.42090898-286.33115307 118.42090898z m0-725.22496474c-82.09927197 0-164.21327292 31.25487175-226.70828746 93.74988629-125.00475803 125.00475803-125.00475803 328.44127481 0 453.44603281 125.01948701 124.9753001 328.41181686 125.03421596 453.43130386 0 125.00475803-125.00475803 125.00475803-328.44127481 0-453.44603281-62.5097435-62.49501453-144.60901547-93.74988627-226.7230164-93.74988629z" fill="#2c2c2c"></path><path d="M973.48804978 1013.69813456c-10.78160515 0-21.57793927-4.10938229-29.79670383-12.34287584L658.31757585 715.95203069c-16.46698708-16.46698708-16.46698708-43.14114955 0-59.60813666s43.14114955-16.46698708 59.60813665 0l285.37377009 285.38849908c16.46698708 16.46698708 16.46698708 43.14114955 0 59.60813663a42.07329932 42.07329932 0 0 1-29.81143281 12.35760482z" fill="#2c2c2c"></path></svg>
								<h3>未找到匹配的客户端</h3>
								<p>请尝试其他搜索词或检查输入是否正确</p>
							</div>
						</div>
					`;
					return;
				}
				
				clientList.innerHTML = filteredClients.map((client, index) => {
					return `
						<div class="entry-item" data-id="${client.id}">
							<div class="entry-name">
								<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M838.4 325.12L554.24 479.36C528 493.44 512 521.6 512 552.96V851.2c0 32 31.36 53.12 57.6 38.4l284.16-154.24c25.6-14.08 42.24-42.24 42.24-73.6v-297.6c0-32.64-31.36-53.12-57.6-39.04z m-432.64 153.6L121.6 325.12c-26.24-14.08-57.6 6.4-57.6 38.4v299.52c0 31.36 16 59.52 42.24 73.6l284.16 153.6c26.24 14.08 57.6-7.04 57.6-39.04V552.32c0-31.36-16-59.52-42.24-73.6z m406.4-223.36c13.44-7.04 19.84-19.2 18.56-30.72 1.28-12.16-5.12-23.68-18.56-30.72L522.88 42.88c-12.8-7.04-28.16-10.24-43.52-10.24-15.36 0-30.72 3.2-43.52 10.24l-289.28 150.4c-13.44 7.04-19.2 19.2-18.56 30.72-0.64 12.16 5.12 24.32 18.56 31.36l289.28 150.4C448.64 412.8 464 416 479.36 416c15.36 0 30.72-3.2 43.52-10.24l289.28-150.4z"></path></svg>
								<span>${client.name}</span>
							</div>
							<div class="entry-version">
								<span class="version-badge">${client.version}</span>
							</div>
							<div class="entry-loader">
								<span class="loader-badge">${client.extensionType}</span>
							</div>
							<div class="entry-actions">
								<button class="launch-btn" onclick="start(${index});playStartSound()">
									<span>启动</span>
								</button>
							</div>
						</div>
					`;
				}).join('');
			}
			
			// 搜索功能
			function setupSearch() {
				const searchInput = document.getElementById('search-input');
				
				searchInput.addEventListener('input', function() {
					const searchTerm = this.value.toLowerCase().trim();
					
					if (!searchTerm) {
						renderClientList(clients);
						return;
					}
					
					const filteredClients = clients.filter(client => {
						return (
							client.name.toLowerCase().includes(searchTerm) ||
							client.version.toLowerCase().includes(searchTerm) ||
							client.extensionType.toLowerCase().includes(searchTerm)
						);
					});
					
					renderClientList(filteredClients);
				});
			}
			
			function start(id) {
				if (clients[id]) {
					window.parent.start(clients[id]);
					return;
				}
				
				window.parent.start();
			}
			
			
			// 页面加载完成后初始化
			document.addEventListener('DOMContentLoaded', () => {
				// 渲染初始客户端列表
				renderClientList();
				
				// 设置搜索功能
				setupSearch();
			});
			window.parent.addEventListener("start", () => {
				document.querySelector(".overlay-container").classList.remove("hidden");
				document.querySelector(".entries-list").classList.add("hidden");
			});
			window.parent.addEventListener("exit", () => {
				document.querySelector(".overlay-container").classList.add("hidden");
				document.querySelector(".entries-list").classList.remove("hidden");
			});
		</script>
	</body>
</html>