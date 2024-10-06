<?php defined('__MKHDIR__') or die(http_response_code(403)) ?><!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<script src="js/jquery.min.js"></script>
		<script src="js/command.js"></script>
		<style>
			body {
				padding: 0;
				overflow: hidden !important;
				height: 100vh;
			}
			.rcon {
				position: relative;
				height: 100%;
			}
			.rcon .output {
				height: calc(100% - 50px);
				overflow-y: scroll;
			}
			.rcon .output pre {
				background: radial-gradient(#666,#555);
				border-radius: 5px;
				box-sizing: border-box;
				margin: 0;
				margin-right: 5px;
				min-height: 100%;
				padding: 10px;
			}
			.rcon .output pre div {
				margin: 0;
				margin-top: 5px;
				margin-bottom: 5px;
			}
			.rcon .output pre .send {
				color: #bde619;
				font-size: 18px;
			}
			.rcon .output pre .return {
				border-radius: 5px;
				background-color: #343541;
				padding: 15px;
				color: #a9e5ed;
				font-size: 16px;
			}
			.rcon .operate {
				position: relative;
				font-size: 0;
			}
			.rcon .operate input {
				width: calc(100% - 315px);
				height: 35px;
				padding: 5px 10px;
				margin: 5px 0;
				color: #fff;
				font-size: 16px;
				box-sizing: border-box;
				border: 2px solid #666;
				border-radius: 5px;
				background-color: #555;
			}
			.rcon .operate input::placeholder {
				color: #bbb;
			}
			.rcon .operate button {
				padding: 15px;
				padding-top: 5px;
				padding-bottom: 5px;
				margin-left: 5px;
				width: 100px;
				height: 35px;
				cursor: pointer;
				color: #fff;
				font-size: 12px;
				box-sizing: border-box;
				border: none;
				border-radius: 5px;
				background: radial-gradient(#666,#555);
			}
			.rcon .operate button:hover {
				color: #ff8033;
			}
		</style>
	</head>
	<body>
		<includes-message>	<script src="js/message.js"></script>
	<div class="result">
		<style>
			.result {
				position: relative;
				top: 0;
				left: 0;
				z-index: 1;
				width: 100%;
			}
			.result data {
				display: none;
			}
			.result div {
				margin-bottom: 10px;
				position: relative;
				padding: 10px;
				padding-right: 30px;
				background-color: #FFFFFF;
				border-radius: 5px;
			}
			.result div span:first-child {
				color: #52808C;
			}
			.result div span:last-child {
				position: absolute;
				top: 0;
				right: 5px;
				display: inline-block;
				cursor: pointer;
				padding: 10px;
				color: #52808C;
			}
		</style>
		<data>
			<div id="{id}">
				<span>{error}</span>
				<span title="关闭" onclick="removeMessage({id})">X</span>
			</div>
		</data>
	</div></includes-message>
		<includes-scrollbar>	<style>
		::-webkit-scrollbar {width: 6px}
		::-webkit-scrollbar {height: 6px}
		::-webkit-scrollbar-track {border-radius: 3px}
		::-webkit-scrollbar-track {background-color: #fff}
		::-webkit-scrollbar-thumb {border-radius: 3px}
		::-webkit-scrollbar-thumb {background-color: #999}
		body {overflow-y: scroll}
		body {padding-right: 5px}
		body {margin: 0}
	</style></includes-scrollbar>
		<div class="rcon">
			<div class="output">
				<pre></pre>
			</div>
			<div class="operate">
				<input type="text" placeholder="Ctrl+V 粘贴" id="command" />
				<button onclick="command()" id="button">发送命令</button>
				<button onclick="command('broadcast')">发送公告</button>
				<button onclick="$('#command').val('changepassword [旧密码] [新密码] [确认新密码]')">更改密码</button>
			</div>
		</div>
	</body>
</html>