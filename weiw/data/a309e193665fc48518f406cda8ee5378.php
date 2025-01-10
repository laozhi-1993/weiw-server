<?php defined('__MKHDIR__') or die(http_response_code(403)) ?><!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<script src="js/skinview3d.bundle.js"></script>
		<script src="js/home.js"></script>
		<style>
			body {
				padding: 0;
				margin: 0;
				height: 100vh;
			}
			includes-message {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
			}
			.settexture {
				padding: 10px;
				position: absolute;
				top: 0;
				left: 0;
				z-index: 1;
				box-sizing: border-box;
				user-select: none;
				width: 100%;
				opacity: 0;
				visibility: hidden;
				transform: scale(0.8);
				transition: opacity 0.5s ease, transform 0.5s ease, visibility 0s 0.5s;
			}
			.settexture.show {
				opacity: 1;
				visibility: visible;
				transform: scale(1);
				transition: opacity 0.5s ease, transform 0.5s ease;
			}
			.settexture .content {
				font-size: 0;
				width: 500px;
				margin: auto;
				padding: 0 10px;
				box-shadow: 0 2px 2px 2px #333;
				border-radius: 10px;
				border: 1px solid #888;
				background-color: #666;
			}
			.settexture .content .tid {
				display: inline-block;
				vertical-align: top;
				overflow: hidden;
				margin: 9px;
				width: calc(100% - 68px);
				border-radius: 5px;
				border: 1px solid #888;
			}
			.settexture .content .tid input {
				font-size: 15px;
				padding: 0 10px;
				width: calc(100% - 50px);
				height: 28px;
				color: #333;
				box-sizing: border-box;
				border: none;
				background-color: #fff;
			}
			.settexture .content .tid input:focus {
				border-radius: 5px 0 0 5px;
			}
			.settexture .content .tid span {
				display: inline-block;
				font-size: 12px;
				cursor: pointer;
				color: #ddd;
				text-align: center;
				width: 50px;
				height: 28px;
				line-height: 28px;
				background-color: #888;
			}
			.settexture .content .tid span:hover {
				background-color: #808080;
			}
			.settexture .content .tid span:active {
				color: #fff;
			}
			.settexture .content .close {
				display: inline-block;
				cursor: pointer;
				width: 30px;
				height: 30px;
				margin: 9px;
				padding: 4px;
				box-sizing: border-box;
			}
			.settexture .content .close:hover {
				border-radius: 5px;
				background-color: #808080;
			}
			.settexture .content .close:active svg path {
				fill: #fff;
			}
			.settexture .content .close svg {
				width: 20px;
				height: 20px;
			}
			.settexture .content .close svg path
			{
				fill: #ddd;
			}
			.texture {
				position: relative;
				padding: 0;
				height: calc(100% - 100px);
				user-select: none;
			}
			.texture #canvas {
				vertical-align: bottom;
				overflow: hidden;
				border-radius: 5px;
				height: 100%;
				background-color: rgba(255, 255, 255, 0.1);
			}
			.texture .action {
				margin-top: 5px;
				padding: 15px 0;
				height: 65px;
				font-size: 0;
				text-align: center;
				border-radius: 5px;
				background-color: #FFFFE0;
			}
			.texture .action div {
				width: 130px;
				font-size: medium;
				display: inline-block;
			}
			.texture .action div span {
				border-radius: 5px;
				background-color: #343541;
				padding: 5px;
				margin: 0 5px;
				font-size: 12px;
				line-height: 20px;
				cursor: pointer;
				color: #FFFFFF;
				display: block;
			}
			.texture .action div span:active {
				background-color: #FDC500;
				color: #FFFFFF;
			}
		</style>
	</head>
	<body>
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
		
		<div class="settexture">
			<div class="content">
				<div class="tid">
					<input type="number" min="1" placeholder="TID"/>
					<span onclick="texture(1)">确定</span>
				</div>
				
				<div class="close" onclick="texture(2)">
					<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h1024v1024H0z" fill="#FF0033" fill-opacity="0"></path><path d="M240.448 168l2.346667 2.154667 289.92 289.941333 279.253333-279.253333a42.666667 42.666667 0 0 1 62.506667 58.026666l-2.133334 2.346667-279.296 279.210667 279.274667 279.253333a42.666667 42.666667 0 0 1-58.005333 62.528l-2.346667-2.176-279.253333-279.253333-289.92 289.962666a42.666667 42.666667 0 0 1-62.506667-58.005333l2.154667-2.346667 289.941333-289.962666-289.92-289.92a42.666667 42.666667 0 0 1 57.984-62.506667z" fill="#111111"></path></svg>
				</div>
			</div>
		</div>
		
		<div class="texture">
			<div id="canvas">
				<canvas id="skinContainer"></canvas>
			</div>
			
			<div class="action">
				<div onclick="action(4)"><span>旋转</span></div>
				<div onclick="action(1)"><span>漫步</span></div>
				<div onclick="action(2)"><span>跑步</span></div>				
				<div onclick="action(3)"><span>飞行</span></div>
				<div onclick="action(5)"><span>鞘翅</span></div>
				<div onclick="texture(3)"><span>使用材质</span></div>
				<div onclick="texture(0)"><span>重置材质</span></div>
			</div>
		</div>
	</body>
</html>