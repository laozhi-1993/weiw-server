<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>控制台</title>
		<style>
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
				font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
			}
			
			body {
				background-color: #2e2e2e;
				color: #f0f0f0;
				min-height: 100vh;
				padding: 0 10px;
				display: flex;
				flex-direction: column;
				align-items: center;
				justify-content: center;
			}
			
			.container {
				width: 100%;
			}
			
			.status-indicator {
				display: flex;
				align-items: center;
				gap: 8px;
				font-size: 10px;
				padding: 5px 12px;
				border-radius: 6px;
				background-color: #3a3a3a;
				border: 1px solid #4a4a4a;
			}
			
			.status-dot {
				width: 10px;
				height: 10px;
				border-radius: 50%;
				background-color: #ff6b6b;
			}
			
			.status-dot.connected {
				background-color: #51cf66;
				animation: pulse 2s infinite;
			}
			
			@keyframes pulse {
				0% { opacity: 1; }
				50% { opacity: 0.5; }
				100% { opacity: 1; }
			}
			
			.console-container {
				background-color: #1e1e1e;
				border-radius: 10px;
				overflow: hidden;
				box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
				border: 1px solid #3a3a3a;
			}
			
			.console-header {
				background-color: #2d2d2d;
				padding: 15px 20px;
				display: flex;
				justify-content: space-between;
				align-items: center;
				border-bottom: 1px solid #3a3a3a;
			}
			
			.console-title {
				display: flex;
				align-items: center;
				gap: 10px;
				font-weight: 500;
				color: #e9ecef;
			}
			
			.console-title svg {
				height: 25px;
			}
			
			.console-title path {
				fill: #8F2FEE;
			}
			
			.console-controls {
				display: flex;
				gap: 15px;
			}
			
			.console-controls span {
				vertical-align: bottom;
			}
			
			.console-controls svg {
				vertical-align: top;
				height: 16px;
			}
			
			.console-controls path {
				fill: #fff;
			}
			
			.control-btn {
				padding: 8px 16px;
				background-color: #3a3a3a;
				color: #f0f0f0;
				border: 1px solid #4a4a4a;
				border-radius: 6px;
				cursor: pointer;
				font-size: 14px;
				font-weight: 500;
				display: flex;
				align-items: center;
				gap: 8px;
				transition: all 0.2s ease;
			}
			
			.control-btn:hover {
				background-color: #4a4a4a;
				transform: translateY(-2px);
			}
			
			.control-btn:active {
				transform: translateY(0);
			}
			
			.control-home {
				background-color: #228be6;
				border-color: #1c7ed6;
			}
			
			.control-home:hover {
				background-color: #1c7ed6;
			}
			
			.control-clear {
				background-color: #fa5252;
				border-color: #e03131;
			}
			
			.control-clear:hover {
				background-color: #e03131;
			}
			
			.console-body {
				padding: 20px;
				height: calc(100vh - 66px);
				overflow-y: auto;
				display: flex;
				flex-direction: column;
			}
			
			.console-output {
				flex: 1;
				overflow-y: auto;
				margin-bottom: 20px;
				font-size: 15px;
				line-height: 1.5;
			}
			
			.console-line {
				margin-bottom: 8px;
				padding: 2px 0;
				word-break: break-word;
			}
			
			.command {
				color: #4dabf7;
			}
			
			.command::before {
				content: "> ";
				font-weight: bold;
			}
			
			.output {
				color: #B0E2FF;
			}
			
			.error {
				color: #ff6b6b;
			}
			
			.success {
				color: #51cf66;
			}
			
			.info {
				color: #ff922b;
			}
			
			.prompt {
				display: flex;
				align-items: center;
				background-color: #252525;
				border-radius: 6px;
				padding: 10px 15px;
				border: 1px solid #3a3a3a;
			}
			
			.prompt-prefix {
				color: #51cf66;
				font-weight: bold;
				margin-right: 10px;
				white-space: nowrap;
			}
			
			#command-input {
				flex: 1;
				background: transparent;
				border: none;
				color: #f0f0f0;
				font-size: 15px;
				outline: none;
				caret-color: #4dabf7;
			}
			
			#send-btn {
				background-color: #228be6;
				color: white;
				border: none;
				border-radius: 4px;
				padding: 8px 16px;
				cursor: pointer;
				font-weight: 500;
				margin-left: 10px;
				transition: background-color 0.2s;
			}
			
			#send-btn:hover {
				background-color: #1c7ed6;
			}
			
			#send-btn span {
				vertical-align: bottom;
			}
			
			#send-btn svg {
				vertical-align: top;
				height: 18px;
			}
			
			#send-btn path {
				fill: #fff;
			}
			
			.history-hint {
				color: #868e96;
				font-size: 13px;
				margin-top: 10px;
				text-align: center;
			}
			
			.history-hint kbd {
				background-color: #3a3a3a;
				padding: 2px 6px;
				border-radius: 4px;
				border: 1px solid #4a4a4a;
				margin: 0 2px;
			}
			
			/* 滚动条样式 */
			::-webkit-scrollbar {
				width: 10px;
			}
			
			::-webkit-scrollbar-track {
				background: #2d2d2d;
				border-radius: 5px;
			}
			
			::-webkit-scrollbar-thumb {
				background: #4a4a4a;
				border-radius: 5px;
			}
			
			::-webkit-scrollbar-thumb:hover {
				background: #5a5a5a;
			}
			
			@media (max-width: 768px) {
				.console-body {
					padding: 15px;
				}
				
				.console-controls {
					gap: 10px;
				}
				
				.control-btn {
					padding: 6px 12px;
					font-size: 13px;
				}
				
				.prompt {
					flex-wrap: wrap;
				}
				
				#send-btn {
					margin-top: 10px;
					margin-left: 0;
					width: 100%;
				}
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="console-container">
				<div class="console-header">
					<div class="console-title">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M972.8 0H51.2a51.2 51.2 0 0 0-51.2 51.2v358.4a51.2 51.2 0 0 0 51.2 51.2h921.6a51.2 51.2 0 0 0 51.2-51.2V51.2a51.2 51.2 0 0 0-51.2-51.2zM102.4 179.2h102.4v102.4H102.4v-102.4z m799.232 102.4h-512v-102.4h512v102.4zM972.8 563.2H51.2a51.2 51.2 0 0 0-51.2 51.2v358.4a51.2 51.2 0 0 0 51.2 51.2h921.6a51.2 51.2 0 0 0 51.2-51.2v-358.4a51.2 51.2 0 0 0-51.2-51.2zM102.4 742.4h102.4v102.4H102.4v-102.4z m799.232 102.4h-512v-102.4h512v102.4z" fill="#9A9DAE"></path></svg>
						<span id="name">控制台 - </span>
						
						<div class="status-indicator">
							<div class="status-dot" id="status-dot"></div>
							<span id="status-text">无</span>
						</div>
					</div>
					<div class="console-controls">
						<button class="control-btn control-clear" id="clear-btn">
							<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M695.04 618.154667c15.189333 15.146667 17.493333 38.869333 5.418667 56.576L644.693333 757.333333l-45.482666 68.778667-18.901334 29.184-16.298666 25.685333-17.792 28.885334-7.168 12.117333-8.661334 15.274667-4.352 8.277333-3.2 6.698667c-0.426667 1.024-0.853333 1.92-1.152 2.816l-1.493333 4.394666c-6.954667 27.306667-29.994667 24.064-37.546667 16.597334l-52.138666-51.84a22.229333 22.229333 0 0 1-4.224-25.813334l56.362666-112.042666-95.829333 68.053333a22.613333 22.613333 0 0 1-28.970667-2.389333l-9.813333-9.770667a22.272 22.272 0 0 1-6.144-20.181333l13.525333-67.285334-49.066666 24.405334a22.613333 22.613333 0 0 1-26.026667-4.224l-7.893333-7.850667a22.229333 22.229333 0 0 1-3.413334-27.306667l38.698667-64.042666-82.218667 27.221333a22.613333 22.613333 0 0 1-23.04-5.418667l-26.410666-26.24a22.229333 22.229333 0 0 1-4.181334-25.813333l24.533334-48.810667-67.712 13.482667a22.613333 22.613333 0 0 1-20.309334-6.101333l-59.136-58.752c-15.018667-14.933333-1.536-26.24 11.178667-31.744l5.717333-2.133334 2.56-0.682666c6.826667-1.706667 14.976-4.821333 24.533334-9.386667l12.117333-6.229333 13.397333-7.68c7.082667-4.138667 14.634667-8.832 22.656-14.037334l16.768-11.136 18.048-12.544 19.413334-13.952 20.693333-15.36 22.058667-16.768 23.381333-18.176 24.704-19.541333 39.509333-32 13.866667-11.392a45.184 45.184 0 0 1 60.586667 2.773333l294.570666 292.778667z m251.178667-540.586667a118.570667 118.570667 0 0 1-10.581334 177.749333L756.906667 395.136l57.898666 57.6c29.013333 28.8 30.08 75.178667 2.432 105.301333l-33.536 36.48a22.613333 22.613333 0 0 1-31.786666 1.450667l-326.314667-324.266667a22.272 22.272 0 0 1-2.602667-28.544l2.944-3.413333 36.992-33.834667a76.714667 76.714667 0 0 1 105.728 2.133334l57.984 57.6 140.672-177.536a120.32 120.32 0 0 1 178.858667-10.538667zM892.714667 131.413333c-8.618667-8.533333-20.053333-13.226667-32.128-13.269333a45.098667 45.098667 0 0 0-32.042667 77.141333c8.618667 8.533333 20.053333 13.269333 32.213333 13.269334a45.226667 45.226667 0 0 0 45.354667-45.141334c0-12.074667-4.778667-23.424-13.397333-32z"></path></svg>
							<span>清屏</span>
						</button>
					</div>
				</div>
				
				<div class="console-body">
					<div class="console-output" id="console-output">
						<div class="console-line info">----------------------------------------</div>
						<div class="console-line info">欢迎使用命令行控制台</div>
						<div class="console-line info">输入命令并按回车发送到服务器</div>
						<div class="console-line info">----------------------------------------</div>
					</div>
					
					<div class="prompt">
						<div class="prompt-prefix">$</div>
						<input type="text" id="command-input" autocomplete="off" placeholder="输入命令并按回车发送...">
						<button id="send-btn">
							<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M915.515273 142.819385 98.213046 458.199122c-46.058539 17.772838-44.90475 43.601756 2.348455 57.622994l197.477685 58.594874 80.292024 238.91085c10.51184 31.277988 37.972822 37.873693 61.462483 14.603752l103.584447-102.611545 204.475018 149.840224c26.565749 19.467242 53.878547 9.222132 61.049613-23.090076l149.210699-672.34491C965.264096 147.505054 946.218922 130.971848 915.515273 142.819385zM791.141174 294.834331l-348.61988 310.610267c-6.268679 5.58499-11.941557 16.652774-12.812263 24.846818l-15.390659 144.697741c-1.728128 16.24808-7.330491 16.918483-12.497501 1.344894l-67.457277-203.338603c-2.638691-7.954906 0.975968-17.705389 8.022355-21.931178l442.114555-265.181253C812.67481 268.984974 815.674251 272.975713 791.141174 294.834331z"></path></svg>
							<span>发送</span>
						</button>
					</div>
					
					<div class="history-hint">
						提示：使用 <kbd>↑</kbd> <kbd>↓</kbd> 箭头键浏览命令历史记录
					</div>
				</div>
			</div>
		</div>

		<script>
			document.addEventListener('DOMContentLoaded', function() {
				const urlParams = new URLSearchParams(window.location.search);
				// 元素引用
				const commandInput = document.getElementById('command-input');
				const sendButton = document.getElementById('send-btn');
				const consoleOutput = document.getElementById('console-output');
				const clearButton = document.getElementById('clear-btn');
				const statusDot = document.getElementById('status-dot');
				const statusText = document.getElementById('status-text');
				
				// 命令历史和当前历史索引
				let commandHistory = [
					'kill',
					'stop',
					'start',
				];
				let historyIndex = commandHistory.length;
				
				// WebSocket连接
				let socket = null;
				const websocketUrl = '/websocket?name=' + urlParams.get('name');
				document.getElementById('name').append(urlParams.get('name'));
				
				// 初始化WebSocket连接
				function connectWebSocket() {
					try {
						// 创建WebSocket连接
						socket = new WebSocket(websocketUrl);
						
						
						// WebSocket事件处理
						socket.onopen = function(event) {
							addOutputLine('success', '✓ 连接已建立');
						};
						
						socket.onmessage = function(event) {
							addOutputLine('output', event.data);
						};
						
						socket.onerror = function(event) {
							addOutputLine('error', 'WebSocket连接错误');
						};
						
						socket.onclose = function(event) {
							if (event.wasClean) {
								addOutputLine('info', `连接已关闭，代码: ${event.code}, 原因: ${event.reason}`);
							} else {
								addOutputLine('error', '连接意外中断');
							}
							
							// 尝试重新连接
							setTimeout(connectWebSocket, 3000);
						};
						
					} catch (error) {
						addOutputLine('error', `连接失败: ${error.message}`);
						
						// 尝试重新连接
						setTimeout(connectWebSocket, 3000);
					}
				}
				
				// 添加输出行到控制台
				function addOutputLine(type, content) {
					const line = document.createElement('div');
					line.className = `console-line ${type}`;
					
					// 如果内容是命令，添加命令样式
					if (type === 'command') {
						line.innerHTML = `<span class="command">${content}</span>`;
					} else {
						if (content === '{start}') {
							statusDot.className = 'status-dot';
							statusDot.classList.add('connected');
							statusText.textContent = '服务器已启动';
							return;
						}
						
						if (content === '{stop}') {
							statusDot.className = 'status-dot';
							statusText.textContent = '服务器未启动';
							return;
						}
						
						line.textContent = content;
					}
					
					consoleOutput.appendChild(line);
					
					// 滚动到底部
					consoleOutput.scrollTop = consoleOutput.scrollHeight;
				}
				
				// 发送命令
				function sendCommand() {
					const command = commandInput.value.trim();
					
					if (!command) {
						return;
					}
					
					// 添加到命令历史
					commandHistory.push(command);
					historyIndex = commandHistory.length;
					
					// 显示命令
					addOutputLine('command', command);
					
					// 通过WebSocket发送命令
					if (socket && socket.readyState === WebSocket.OPEN) {
						socket.send(command);
					} else {
						addOutputLine('error', '无法发送命令：WebSocket连接未就绪');
					}
					
					// 清空输入框
					commandInput.value = '';
					
					// 重新聚焦到输入框
					commandInput.focus();
				}
				
				// 清屏功能
				function clearConsole() {
					consoleOutput.innerHTML = '';
					addOutputLine('info', '控制台已清空');
				}
				
				// 浏览命令历史
				function navigateHistory(direction) {
					if (commandHistory.length === 0) return;
					
					if (direction === 'up') {
						// 向上浏览历史
						if (historyIndex > 0) {
							historyIndex--;
						}
					} else if (direction === 'down') {
						// 向下浏览历史
						if (historyIndex < commandHistory.length - 1) {
							historyIndex++;
						} else {
							// 如果已经在最新，清空输入框
							historyIndex = commandHistory.length;
							commandInput.value = '';
							return;
						}
					}
					
					// 如果索引在有效范围内，设置输入框的值
					if (historyIndex >= 0 && historyIndex < commandHistory.length) {
						commandInput.value = commandHistory[historyIndex];
					}
				}
				
				// 事件监听器
				commandInput.addEventListener('keydown', function(e) {
					// 回车发送命令
					if (e.key === 'Enter') {
						sendCommand();
					}
					
					// 上箭头浏览历史
					if (e.key === 'ArrowUp') {
						e.preventDefault();
						navigateHistory('up');
					}
					
					// 下箭头浏览历史
					if (e.key === 'ArrowDown') {
						e.preventDefault();
						navigateHistory('down');
					}
				});
				
				sendButton.addEventListener('click', sendCommand);
				
				clearButton.addEventListener('click', clearConsole);
				
				// 初始化连接
				connectWebSocket();
				
				// 聚焦到输入框
				commandInput.focus();
			});
		</script>
	</body>
</html>