<?php defined('__MKHDIR__') or die(http_response_code(403)) ?><!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<title>文件管理器</title>
		<style>
			::-webkit-scrollbar {width: 10px}
			::-webkit-scrollbar {height: 10px}
			::-webkit-scrollbar-track {border-radius: 5px}
			::-webkit-scrollbar-track {background-color: #606060}
			::-webkit-scrollbar-thumb {border-radius: 5px}
			::-webkit-scrollbar-thumb {background-color: #9393ff}
			
			body {
				padding-top: 30px;
				margin: 0;
				height: 100vh;
				box-sizing: border-box;
				background-color: #2e2e2e;
			}
			
			h1 {
				text-align: center;
				color: #fff;
			}
			
			section {
				margin: 0 10px;
				padding: 25px;
				overflow: auto;
				height: calc(100% - 10px);
				box-sizing: border-box;
			}
			section a {
				text-decoration: none;
				color: inherit;
				outline: none;
			}
			section .pointer {
				cursor: pointer;
			}
			section .svg-icon {
				display: inline-block;
				vertical-align: middle;
				width: 25px;
				height: 25px;
			}
			section .icon {
				font-size: 25px;
			}
			
			.upload-container {
				background-color: #333;
				border-radius: 10px;
				padding: 20px;
				margin-bottom: 30px;
				text-align: center;
				box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
				user-select: none;
			}
			
			.upload-container progress {
				width: 100%;
			}

			.upload-container p {
				margin: 10px 0;
				font-size: 14px;
				color: #aaa;
			}

			.upload-area {
				border: 2px dashed #888;
				padding: 40px;
				font-size: 16px;
				color: #ccc;
				cursor: pointer;
			}

			.upload-area.dragover  {
				border: 2px dashed #fbff00;
				color: #fbff00;
			}
			
			.upload-area:hover {
				background-color: #444;
			}

			.upload-area:active {
				border-color: #66bb6a;
			}

			.path-container {
				background: 
					linear-gradient(90deg, #666 0%, #666 100%), 
					radial-gradient(at top, rgba(255, 255, 255, 0.50) 0%, rgba(0, 0, 0, 0.55) 100%), 
					radial-gradient(at top, rgba(255, 255, 255, 0.50) 0%, rgba(0, 0, 0, 0.08) 63%);
				background-blend-mode: multiply, screen;
				padding: 15px 20px;
				border-radius: 10px;
				margin-bottom: 20px;
				font-size: 16px;
				display: flex;
				justify-content: space-between;
				align-items: center;
				box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* 阴影 */
			}

			.path-container span {
				color: #ddd;
				font-size: 14px;
				font-weight: bold;
				flex-grow: 1;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
			}

			.path-container .icon {
				color: #aaa;
				font-size: 25px;
				margin-right: 10px;
			}

			.path-container .back-home-btn {
				background-color: #444;
				color: #fff;
				padding: 10px 20px;
				border-radius: 5px;
				cursor: pointer;
				border: none;
				transition: background-color 0.3s ease;
				user-select: none;
			}

			.path-container .back-home-btn:hover {
				background-color: #66bb6a;
			}
			
			table {
				width: 100%;
				border-collapse: collapse;
				margin-top: 20px;
				background-color: #333;
				border-radius: 5px;
			}

			th, td {
				padding: 15px;
				text-align: left;
				font-size: 14px;
				color: #e1e1e1;
				border-bottom: 1px solid #444;
			}

			th {
				background-color: #444;
				font-weight: bold;
			}

			th:last-child, td:last-child {
				text-align: right;
			}
			
			tr {
				opacity: 0;
				transform: translateY(30px);
				animation: fadeInUp 0.5s forwards;
			}

			tr:nth-child(odd) {
				animation-delay: 0.2s;
			}

			tr:nth-child(even) {
				animation-delay: 0.4s;
			}

			tr:hover {
				background-color: #444;
			}

			.file-actions button {
				background-color: #444;
				color: #fff;
				border: none;
				padding: 8px 16px;
				margin-left: 10px;
				cursor: pointer;
				border-radius: 5px;
				user-select: none;
			}

			.file-actions button:hover {
				background-color: #66bb6a;
			}

			@keyframes fadeInUp {
				to {
					opacity: 1;
					transform: translateY(0);
				}
			}
		</style>
	</head>
	<body>
		<section>
			<main>
				<includes-header>	<window-header>
		<style>
			window-header {
				position: fixed;
				top: 0;
				left: 0;
				z-index: 99;
				width: 100%;
				min-height: 28px;
				font-size: 0;
				text-align: right;
				user-select: none;
				-webkit-app-region: drag;
			}
			window-header div {
				display: inline-block;
				width:  28px;
				height: 28px;
				text-align: center;
				-webkit-app-region: no-drag;
			}
			window-header div svg {
				position: relative;
				top: 5px;
				width: 	16px;
				height: 16px;
				vertical-align: top;
			}
			window-header div svg path {
				fill: #00ffff;
			}
			window-header #minimize:hover {
				background-color: #777777;
			}
			window-header #minimize:hover svg path {
				fill: #FFFFFF;
			}
			window-header #maximize:hover {
				background-color: #777777;
			}
			window-header #maximize:hover svg path {
				fill: #FFFFFF;
			}
			window-header #restore:hover {
				background-color: #777777;
			}
			window-header #restore:hover svg path {
				fill: #FFFFFF;
			}
			window-header #close:hover {
				background-color: #cc0000;
			}
			window-header #close:hover svg path {
				fill: #FFFFFF;
			}
		</style>
		<div id="minimize"><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3730"><path d="M128 448h768v128H128z" p-id="3731"></path></svg></svg></div>
		<div id="maximize"><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3389"><path d="M199.111111 256v512h625.777778v-512z m56.888889 455.111111v-341.333333h512v341.333333z" p-id="3390"></path></svg></div>
		<div id="restore" ><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3132"><path d="M512 1255.489906M865.682191 310.085948l-554.675195 0c-14.634419 0-26.403358 11.973616-26.403358 26.710374L284.603638 423.681791l-92.309414 0c-14.634419 0-26.403358 11.973616-26.403358 26.710374l0 349.998001c0 14.634419 11.768939 26.505697 26.403358 26.505697l554.675195 0c14.634419 0 26.710374-11.871277 26.710374-26.505697L773.679792 713.30002l92.002399 0c14.634419 0 26.710374-11.871277 26.710374-26.505697l0-349.998001C892.392564 322.059564 880.31661 310.085948 865.682191 310.085948zM728.65081 781.86688 210.817509 781.86688 210.817509 468.710774l517.8333 0L728.65081 781.86688zM847.363582 668.271037l-73.68379 0L773.679792 450.392165c0-14.634419-12.075954-26.710374-26.710374-26.710374L329.530282 423.681791l0-68.56686 517.8333 0L847.363582 668.271037z" p-id="3133"></path></svg></div>
		<div id="close"   ><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1501"><path d="M557.311759 513.248864l265.280473-263.904314c12.54369-12.480043 12.607338-32.704421 0.127295-45.248112-12.512727-12.576374-32.704421-12.607338-45.248112-0.127295L512.127295 467.904421 249.088241 204.063755c-12.447359-12.480043-32.704421-12.54369-45.248112-0.063647-12.512727 12.480043-12.54369 32.735385-0.063647 45.280796l262.975407 263.775299-265.151458 263.744335c-12.54369 12.480043-12.607338 32.704421-0.127295 45.248112 6.239161 6.271845 14.463432 9.440452 22.687703 9.440452 8.160624 0 16.319527-3.103239 22.560409-9.311437l265.216826-263.807983 265.440452 266.240344c6.239161 6.271845 14.432469 9.407768 22.65674 9.407768 8.191587 0 16.352211-3.135923 22.591372-9.34412 12.512727-12.480043 12.54369-32.704421 0.063647-45.248112L557.311759 513.248864z" fill="#575B66" p-id="1502"></path></svg></div>
	</window-header></includes-header>
				<includes-confirm>	<script>
		function customConfirm(message, callback) {
			const modal          = document.getElementById('custom-confirm');
			const messageElement = document.getElementById('confirm-message');
			const yesButton      = document.getElementById('confirm-yes');
			const noButton       = document.getElementById('confirm-no');

			
			messageElement.innerHTML = message;
            modal.classList.toggle('show');
			
			
			yesButton.onclick = function() {
				modal.classList.toggle('show');
				callback(true);
			};
			
			noButton.onclick = function() {
				modal.classList.toggle('show');
				callback(false);
			};
		}
	</script>
	<style>
        @keyframes scaleUp {
            0% {
                transform: scale(0); /* 开始时小 */
				opacity: 0;
            }
            40% {
                transform: scale(1.2); /* 放大到 1.2x */
            }
            60% {
                transform: scale(0.9); /* 略微缩小 */
            }
            100% {
                transform: scale(1); /* 最终恢复到原始大小 */
				opacity: 1;
            }
        }
		
		.confirm {
			position: fixed;
			top:   0;
			right: 0;
			z-index: 99;
			user-select: none;
			width: 	100%;
			height: 100%;
			background-color: rgba(0,0,0,0.5);
			visibility: hidden;
		}
		.confirm.show {
			visibility: visible;
		}
		.confirm.show .margin {
			animation: scaleUp 0.5s ease-in-out forwards;
        }
		.confirm .margin {
			background-color: #fff;
			border-radius: 10px;
			position: relative;
			top: 50%;
			x-index: 1;
			text-align: center;
			overflow: hidden;
			margin: -150px auto 0 auto;
			max-width: 500px;
		}
		.confirm .margin .message {
			padding: 50px 10px;
		}
		.confirm .margin .button {
			font-size: 0;
			height: 40px;
			line-height: 40px;
		}
		.confirm .margin .button span {
			background-color: #494A5F;
			box-sizing: border-box;
			width: 50%;
			display: inline-block;
			font-size: 16px;
			color: #FFFFFF;
			cursor: pointer;
		}
		.confirm .margin .button span:hover {
			color: #86d688;
		}
		.confirm .margin .button span:first-child {
			border-right: 1px solid #7b817b;
		}
		.confirm .margin .button span:last-child {
			border-left: 1px solid #7b817b;
		}
	</style>
	<div class="confirm fade" id="custom-confirm">
		<div class="margin">
			<div class="message" id="confirm-message"></div>
			<div class="button">
				<span id="confirm-yes">确定</span>
				<span id="confirm-no">取消</span>
			</div>
		</div>
	</div></includes-confirm>
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
				
				<div class="upload-container">
					<p>将文件拖拽到此区域进行上传</p>
					<div id="drop-zone" class="upload-area">拖拽文件至此</div>
					<progress id="progress" value="0" max="0"></progress>
				</div>
				
				<div class="path-container">
					<div class="icon"><a href="<?php if(isset($this->Unified['index'])): ?><?php echo $this->Unified['index'] ?><?php endif; ?>">🏠</a></div>
					<?php if(isset($this->Unified['file_list']['pathArray']) && count($this->Unified['file_list']['pathArray'])): ?><?php foreach($this->Unified['file_list']['pathArray'] as $this->Unified['key']=>$this->Unified['value']): ?><span>
						<span>/</span>
						<a href="?p=<?php if(isset($this->Unified['value']['path'])): ?><?php echo $this->Unified['value']['path'] ?><?php endif; ?>"><?php if(isset($this->Unified['value']['name'])): ?><?php echo $this->Unified['value']['name'] ?><?php endif; ?></a>
					</span><?php endforeach; ?><?php endif; ?>
					<button class="back-home-btn" onclick="window.location.href='index.php'">返回首页</button>
				</div>
				
				<h1>文件列表</h1>
				
				<table>
					<thead>
						<tr>
							<th>文件名</th>
							
							<th>大小</th>
							
							<th>修改时间</th>
							
							<th>操作</th>
						</tr>
					</thead>
					
					<tbody>
						<?php if((isset($this->Unified['file_list']['parent'])) && ($this->Unified['file_list']['parent'] !== '')): ?><tr>
							<td>
								<svg class="svg-icon" viewBox="0 0 1029 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path d="M697.95 5.095H331.144c-179.837 0-326.05 145.703-326.05 326.05V697.95c0 179.837 146.213 326.05 326.05 326.05H697.95C877.787 1024 1024 877.787 1024 697.95V331.144c0-180.346-146.213-326.05-326.05-326.05z m59.097 728.517s-4.076 12.227-10.699 0c0 0-73.36-223.14-253.198-167.61v69.286s-2.547 39.227-38.209 13.755l-176.78-152.327s-36.68-20.378 2.547-47.888l179.837-153.345s25.982-18.85 32.605 12.226v74.89s333.182 16.302 263.897 351.013z m83.55-433.035c-28.02 0-50.945-22.925-50.945-50.945s22.925-50.945 50.945-50.945 50.945 22.925 50.945 50.945-22.925 50.945-50.945 50.945z" fill="#DD6572"></path>
								</svg>
								<a href="?p=<?php if(isset($this->Unified['file_list']['parent'])): ?><?php echo $this->Unified['file_list']['parent'] ?><?php endif; ?>">上一级目录</a>
							</td>
							
							<td></td>
							
							<td></td>
							
							<td></td>
						</tr><?php endif; ?>
						
						<?php if(isset($this->Unified['file_list']['directoryList']) && count($this->Unified['file_list']['directoryList'])): ?><?php foreach($this->Unified['file_list']['directoryList'] as $this->Unified['key']=>$this->Unified['value']): ?><tr>
							<?php if((isset($this->Unified['value']['type'])) && ($this->Unified['value']['type'] === 'file')): ?><td>
								<span class="icon">📄</span>
								<a><?php if(isset($this->Unified['value']['name'])): ?><?php echo $this->Unified['value']['name'] ?><?php endif; ?></a>
							</td><?php endif; ?>
							
							<?php if((isset($this->Unified['value']['type'])) && ($this->Unified['value']['type'] === 'dir')): ?><td>
								<span class="icon">📂</span>
								<a href="?p=<?php if(isset($this->Unified['value']['path'])): ?><?php echo $this->Unified['value']['path'] ?><?php endif; ?>"><?php if(isset($this->Unified['value']['name'])): ?><?php echo $this->Unified['value']['name'] ?><?php endif; ?></a>
							</td><?php endif; ?>
							
							<td><?php if(isset($this->Unified['value']['size'])): ?><?php echo $this->Unified['value']['size'] ?><?php endif; ?></td>
							
							<td><?php if(isset($this->Unified['value']['date'])): ?><?php echo $this->Unified['value']['date'] ?><?php endif; ?></td>
							
							<td class="file-actions">
								<svg class="svg-icon pointer" onclick="fileDelete('<?php if(isset($this->Unified['value']['name'])): ?><?php echo $this->Unified['value']['name'] ?><?php endif; ?>', '<?php if(isset($this->Unified['value']['path'])): ?><?php echo $this->Unified['value']['path'] ?><?php endif; ?>')" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path d="M563.2 712.32h51.2V451.84h-51.2zM896 0H128a128 128 0 0 0-128 128v768a128 128 0 0 0 128 128h768a128 128 0 0 0 128-128V128a128 128 0 0 0-128-128z m-179.2 764.8H307.2c0 8.32 0-11.52 0 0v-364.8h409.6v364.8c8.96 0 0 8.32 0 0zM256 348.16l13.44-57.6a20.48 20.48 0 0 1 15.36-22.4h101.12L460.8 192h102.4l81.28 76.16h101.12c12.16 0 15.36 13.44 15.36 22.4l7.04 57.6z m204.8-104.32l-51.2 51.84h204.8l-51.2-51.84z m-51.2 468.48h51.2V451.84h-51.2z" fill="#9393ff"></path>
								</svg>
								
								<svg class="svg-icon pointer" onclick="copyToClipboard('<?php if(isset($this->Unified['value']['url'])): ?><?php echo $this->Unified['value']['url'] ?><?php endif; ?>')" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path d="M903.872912 0H120.127088A120.127088 120.127088 0 0 0 0 120.127088v783.745824a120.127088 120.127088 0 0 0 120.127088 120.127088h783.745824a120.127088 120.127088 0 0 0 120.127088-120.127088V120.127088A120.127088 120.127088 0 0 0 903.872912 0z m-314.082281 714.923014l-174.768228 174.768228a198.543381 198.543381 0 1 1-280.713645-280.713645l174.768228-174.768228a35.037067 35.037067 0 0 1 50.052953 49.635845l-175.185336 174.768228a128.052138 128.052138 0 1 0 181.024847 181.024847l174.768228-174.768228a35.037067 35.037067 0 1 1 49.635845 49.635845z m-153.495723-175.185336l99.688799-99.688798A35.037067 35.037067 0 0 1 583.95112 489.684725l-99.688798 99.688798a35.037067 35.037067 0 1 1-49.635845-49.635845z m453.396334-125.132383l-174.768228 174.768228a35.037067 35.037067 0 0 1-50.052953-49.635845l174.768228-174.768228a128.052138 128.052138 0 0 0 0-181.024847 128.052138 128.052138 0 0 0-181.024847 0L483.845214 358.712831a35.037067 35.037067 0 1 1-49.635845-49.635845l174.768228-174.768228a198.543381 198.543381 0 0 1 280.713645 280.713645z" fill="#9393ff"></path>
								</svg>
							</td>
						</tr><?php endforeach; ?><?php endif; ?>
					</tbody>
				</table>
			</main>
		</section>
		
		
		<script>
			const dropZone = document.getElementById("drop-zone");
			const progressBar = document.getElementById("progress");

			let total  = 0;
			let loaded = 0;
			
			// 阻止默认的浏览器行为
			["dragenter", "dragover", "dragleave", "drop"].forEach(eventName => {
				dropZone.addEventListener(eventName, e => e.preventDefault());
			});

			// 当目录拖拽到区域时，添加样式
			dropZone.addEventListener("dragenter", () => dropZone.classList.add("dragover"));
			dropZone.addEventListener("dragleave", () => dropZone.classList.remove("dragover"));
			dropZone.addEventListener("drop",      () => dropZone.classList.remove("dragover"));

			// 处理拖拽目录
			dropZone.addEventListener("drop", event => {
				const items = event.dataTransfer.items;
				const files = []; // 用于存储所有文件
				total  = 0;
				loaded = 0;

				for (const item of items) {
					const entry = item.webkitGetAsEntry();
					if (entry) {
						traverseDirectory(entry, '', files); // 获取文件并存储在files数组中
					}
				}

				// 在所有文件读取完成后，调用上传函数
				setTimeout(async () => {
					for (const file of files) {
						await uploadFile(file);
					}
					
					location.reload();
				}, 500);
			});

			// 递归遍历目录结构
			function traverseDirectory(fileOrFolder, path, files) {
				const fullPath = `${path}/${fileOrFolder.name}`;
				
				if (fileOrFolder.isDirectory) {
					fileOrFolder.createReader().readEntries(entries => {
						for (const entry of entries) {
							traverseDirectory(entry, fullPath, files);
						}
					});
					
					return;
				}
				
				if (fileOrFolder.isFile) {
					fileOrFolder.file(file => {
						total += file.size;
						files.push({ file, path: fullPath })
					});
				}
			}
			
			// 上传单个文件
			function uploadFile({ file, path }) {
				return new Promise((resolve, reject) => {
					const formData = new FormData();
					const xhr = new XMLHttpRequest();
					formData.append("file", file, path);

					xhr.upload.addEventListener("progress", function (e) {
						if (e.lengthComputable) {
							progressBar.value = loaded+e.loaded;
							progressBar.max = total;
							
							if (e.loaded === e.total) {
								loaded += e.total;
							}
						}
					});

					xhr.addEventListener("load", function () {
						if (xhr.status === 200) {
							resolve("文件上传成功");
						} else {
							reject("文件上传失败");
						}
					});

					xhr.addEventListener("error", function () {
						reject("文件上传失败");
					});

					xhr.open("POST", `/weiw/index.php?mods=file_upload&p=<?php if(isset($this->Unified['file_list']['current'])): ?><?php echo $this->Unified['file_list']['current'] ?><?php endif; ?>`, true);
					xhr.send(formData);
				});
			}
			
			function fileDelete(name, path) {
				customConfirm(`你确定要 删除 文件吗？<br>${name}`, async function(result) {
					path = encodeURIComponent(path);
					
					if (result) {
						try {
							const response = await fetch(`/weiw/index.php?mods=file_delete&p=${path}`);
							if (!response.ok) {
								throw new Error('Network response was not ok');
							}
							const data = await response.json();
							location.reload();
							console.log(data);
						} catch (error) {
							console.error('There was a problem with the fetch operation:', error);
						}
					}
				});
			}
			
			function copyToClipboard(text) {
				const textArea = document.createElement('textarea');
				textArea.value = text;
				document.body.appendChild(textArea);
			  
				textArea.select();
				textArea.setSelectionRange(0, 99999);
			  
				document.execCommand('copy');
				document.body.removeChild(textArea);
				document.querySelector('section').scrollTop = 0;
			  
				showMessage('已将链接地址复制到剪切板');
			}
		</script>
	</body>
</html>