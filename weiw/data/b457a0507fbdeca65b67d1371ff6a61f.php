<?php defined('__MKHDIR__') or die(http_response_code(403)) ?><!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<title>终端</title>
		<style>
			:root {
				--terminal-bg: #1a1a1a;
				--text-color: #00ff9d;
				--accent-color: #00cc77;
				--border-color: #2d2d2d;
			}

			body {
				height: 100vh;
				margin: 0;
				display: flex;
				align-items: center;
				justify-content: center;
				font-family: 'Fira Code', 'Courier New', monospace;
				color: var(--text-color);
			}

			.terminal-container {
				overflow: hidden;
				width: 100%;
				height: 100%;
				box-sizing: border-box;
				border-radius: 8px;
				border: 1px solid var(--border-color);
				background: var(--terminal-bg);
			}

			.terminal-header {
				background: #232323;
				padding: 10px;
			}

			.history {
				height: calc(100% - 143px);
				padding: 20px;
				overflow-y: auto;
				scrollbar-width: thin;
				scrollbar-color: var(--accent-color) var(--terminal-bg);
			}

			.history::-webkit-scrollbar {
				width: 6px;
			}

			.history::-webkit-scrollbar-track {
				background: var(--terminal-bg);
			}

			.history::-webkit-scrollbar-thumb {
				background-color: var(--accent-color);
				border-radius: 3px;
			}

			.input-container {
				display: flex;
				align-items: center;
				padding: 15px 20px;
				background: #212121;
				border-top: 1px solid var(--border-color);
			}

			.prompt {
				color: var(--accent-color);
				margin-right: 10px;
			}

			input {
				flex: 1;
				background: transparent;
				border: none;
				color: var(--text-color);
				font-family: inherit;
				font-size: 1em;
				outline: none;
				caret-color: var(--accent-color);
			}

			button {
				background: var(--accent-color);
				border: none;
				color: #1a1a1a;
				padding: 8px 15px;
				border-radius: 4px;
				margin-left: 10px;
				cursor: pointer;
				transition: all 0.3s ease;
				display: flex;
				align-items: center;
				gap: 8px;
			}

			button:hover {
				background: #00ff9d;
				transform: translateY(-1px);
			}

			.command {
				margin: 8px 0;
				padding: 5px;
				border-left: 2px solid var(--accent-color);
			}

			.response {
				color: #8a8a8a;
				margin-bottom: 15px;
				padding-left: 20px;
			}

			@keyframes cursor-blink {
				0% { opacity: 0; }
				50% { opacity: 1; }
				100% { opacity: 0; }
			}

			.cursor {
				display: inline-block;
				width: 8px;
				height: 1em;
				background: var(--accent-color);
				vertical-align: middle;
				margin-left: 2px;
				animation: cursor-blink 1s infinite;
			}
		</style>
	</head>
	<body>
		<div class="terminal-container">
			<div class="terminal-header">
				<center>༺࿈终端࿈༻</center>
			</div>
			<div class="history">

			</div>
			<form class="input-container" action="/weiw/index.php?mods=mc_console" method="GET">
				<span class="prompt">></span>
				<input type="text" name="command" placeholder="Ctrl+V 粘贴" required />
				<div class="cursor"></div>
				<button>
					<span>发送</span>
				</button>
				<button type="button" onClick="changepassword()">
					<span>更改密码</span>
				</button>
			</form>
		</div>

		<script src="js/main.js"></script>
		<script>
			const history = document.querySelector('.history');
			const input = document.querySelector('input');
			
			handleFormSubmit("form", function(fetch, form) {
				const input = form.querySelector('input');
				
				history.insertAdjacentHTML("beforeend", "<div class='command'><span class='prompt'>></span><span>"+input.value+"</span></div>");
				history.scrollTop = history.scrollHeight;
				input.value = '';
				
				fetch.then((data) => {
					if(data.error !== '\u0000\u0000')
					{
						history.insertAdjacentHTML("beforeend", "<pre class='response'>"+data.error+"</pre>");
						history.scrollTop = history.scrollHeight;
					}
				}).catch((error) => {
					history.insertAdjacentHTML("beforeend", "<div class='response'>"+error+"</div>");
					history.scrollTop = history.scrollHeight;
				});
			});
			
			function changepassword() {
				document.querySelector('input').value = "changepassword [旧密码] [新密码] [确认新密码]";
			}
			
			document.addEventListener('click', () => input.focus());
		</script>
	</body>
</html>