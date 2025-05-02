<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('file_list');
?>
<!DOCTYPE html>
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
				margin: 0 5px;
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

			.header-container {
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

			.header-container .path {
				display: flex;
				align-items: center;
			}

			.header-container .path span {
				color: #ddd;
				font-size: 14px;
				font-weight: bold;
				flex-grow: 1;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
			}

			.header-container .path .icon {
				color: #aaa;
				font-size: 25px;
				margin-right: 10px;
			}

			.header-container .back-home-btn {
				background-color: #444;
				color: #fff;
				padding: 10px 20px;
				border-radius: 5px;
				cursor: pointer;
				border: none;
				transition: background-color 0.3s ease;
				user-select: none;
			}

			.header-container .back-home-btn:hover {
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
				<includes-header><?php include('includes/window-header.html') ?></includes-header>
				<includes-confirm><?php include('includes/custom_confirm.html') ?></includes-confirm>
				<includes-message><?php include('includes/message.html') ?></includes-message>
				
				<div class="upload-container">
					<p>将文件拖拽到此区域进行上传</p>
					<div id="drop-zone" class="upload-area">拖拽文件至此</div>
					<progress id="progress" value="0" max="0"></progress>
				</div>
				
				<div class="header-container">
					<div class="path">
						<div class="icon"><a href="{echo:var.index}">🏠</a></div>
						<span foreach(var.file_list.pathArray,var.key,var.value)>
							<span>/</span>
							<a href="?p={echo:var.value.path}">{echo:var.value.name}</a>
						</span>
					</div>
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
						<tr if(var.file_list.parent,!==,'')>
							<td>
								<svg class="svg-icon" viewBox="0 0 1029 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path d="M697.95 5.095H331.144c-179.837 0-326.05 145.703-326.05 326.05V697.95c0 179.837 146.213 326.05 326.05 326.05H697.95C877.787 1024 1024 877.787 1024 697.95V331.144c0-180.346-146.213-326.05-326.05-326.05z m59.097 728.517s-4.076 12.227-10.699 0c0 0-73.36-223.14-253.198-167.61v69.286s-2.547 39.227-38.209 13.755l-176.78-152.327s-36.68-20.378 2.547-47.888l179.837-153.345s25.982-18.85 32.605 12.226v74.89s333.182 16.302 263.897 351.013z m83.55-433.035c-28.02 0-50.945-22.925-50.945-50.945s22.925-50.945 50.945-50.945 50.945 22.925 50.945 50.945-22.925 50.945-50.945 50.945z" fill="#DD6572"></path>
								</svg>
								<a href="?p={echo:var.file_list.parent}">上一级目录</a>
							</td>
							
							<td></td>
							
							<td></td>
							
							<td></td>
						</tr>
						
						<tr foreach(var.file_list.directoryList,var.key,var.value)>
							<td if(var.value.type,===,'file')>
								<span class="icon">📄</span>
								<a>{echo:var.value.name}</a>
							</td>
							
							<td if(var.value.type,===,'dir')>
								<span class="icon">📂</span>
								<a href="?p={echo:var.value.path}">{echo:var.value.name}</a>
							</td>
							
							<td>{echo:var.value.size}</td>
							
							<td>{echo:var.value.date}</td>
							
							<td class="file-actions">
								<svg class="svg-icon pointer" onclick="fileDelete('{echo:var.value.name}', '{echo:var.value.path}')" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path d="M563.2 712.32h51.2V451.84h-51.2zM896 0H128a128 128 0 0 0-128 128v768a128 128 0 0 0 128 128h768a128 128 0 0 0 128-128V128a128 128 0 0 0-128-128z m-179.2 764.8H307.2c0 8.32 0-11.52 0 0v-364.8h409.6v364.8c8.96 0 0 8.32 0 0zM256 348.16l13.44-57.6a20.48 20.48 0 0 1 15.36-22.4h101.12L460.8 192h102.4l81.28 76.16h101.12c12.16 0 15.36 13.44 15.36 22.4l7.04 57.6z m204.8-104.32l-51.2 51.84h204.8l-51.2-51.84z m-51.2 468.48h51.2V451.84h-51.2z" fill="#9393ff"></path>
								</svg>
								
								<svg class="svg-icon pointer" onclick="copyToClipboard('{echo:var.value.url}')" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path d="M903.872912 0H120.127088A120.127088 120.127088 0 0 0 0 120.127088v783.745824a120.127088 120.127088 0 0 0 120.127088 120.127088h783.745824a120.127088 120.127088 0 0 0 120.127088-120.127088V120.127088A120.127088 120.127088 0 0 0 903.872912 0z m-314.082281 714.923014l-174.768228 174.768228a198.543381 198.543381 0 1 1-280.713645-280.713645l174.768228-174.768228a35.037067 35.037067 0 0 1 50.052953 49.635845l-175.185336 174.768228a128.052138 128.052138 0 1 0 181.024847 181.024847l174.768228-174.768228a35.037067 35.037067 0 1 1 49.635845 49.635845z m-153.495723-175.185336l99.688799-99.688798A35.037067 35.037067 0 0 1 583.95112 489.684725l-99.688798 99.688798a35.037067 35.037067 0 1 1-49.635845-49.635845z m453.396334-125.132383l-174.768228 174.768228a35.037067 35.037067 0 0 1-50.052953-49.635845l174.768228-174.768228a128.052138 128.052138 0 0 0 0-181.024847 128.052138 128.052138 0 0 0-181.024847 0L483.845214 358.712831a35.037067 35.037067 0 1 1-49.635845-49.635845l174.768228-174.768228a198.543381 198.543381 0 0 1 280.713645 280.713645z" fill="#9393ff"></path>
								</svg>
							</td>
						</tr>
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

					xhr.open("POST", `/weiw/index.php?mods=file_upload&p={echo:var.file_list.current}`, true);
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