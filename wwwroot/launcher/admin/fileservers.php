<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_verify_access');
	$MKH ->mods('fileserver_list');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<title>文件管理器</title>
		<style>
			body {
				margin: 0;
				height: 100vh;
				box-sizing: border-box;
				background-color: #2e2e2e;
			}

			section {
				padding: 20px;
				padding-top: 0;
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
			section .pointer:hover {
				border-radius: 5px;
				background-color: #393939;
			}
			section .svg-icon {
				padding: 5px;
				display: inline-block;
				vertical-align: middle;
				width: 20px;
				height: 20px;
			}
			section .icon {
				font-size: 25px;
			}

			.header-container {
				background-color: #333;
				border-radius: 10px;
				padding: 20px;
				margin-bottom: 30px;
				box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
				user-select: none;
			}

			.header-container progress {
				width: 100%;
			}

			.header-container .page-header {
				display: flex;
				gap: 10px;
			}

			.header-container .page-header svg {
				height: 25px;
			}

			.header-container .breadcrumb {
				border-radius: 5px;
				border: 1px solid #666;
				color: #aaa;
				padding: 8px 10px;
				width: 100%;
			}

			.header-container .breadcrumb .home {
				font-size: 22px;
				line-height: 18px;
			}

			.header-container .refresh {
				border-radius: 5px;
				border: 1px solid #666;
				display: flex;
				align-items: center;
				padding: 0 8px;
				cursor: pointer;
			}

			.header-container .refresh svg {
				fill: #666;
			}

			.header-container .refresh:hover {
				background-color: #444;
			}

			.header-container .actions-header {
				display: flex;
				padding: 8px 0;
				border-top: 1px solid #666;
				border-bottom: 1px solid #666;
			}

			.header-container .buttons {
				display: flex;
				gap: 10px;
				color: #aaa;
			}

			.header-container .buttons:first-child {
				flex: 1;
			}

			.header-container .buttons svg {
				height: 20px;
				margin-right: 5px;
			}

			.header-container .buttons path {
				fill: #aaa;
			}

			.header-container .buttons .button {
				border-radius: 5px;
				background-color: #444;
				padding: 8px 15px;
				display: flex;
				align-items: center;
				font-size: 13px;
				font-weight: 400;
			}

			.header-container .buttons .button:hover {
				background-color: #555;
			}

			table {
				width: 100%;
				border-collapse: collapse;
				margin-top: 20px;
				background-color: #333;
				border-radius: 5px;
			}

			table th, td {
				padding: 15px;
				text-align: left;
				font-size: 14px;
				color: #e1e1e1;
				border-bottom: 1px solid #444;
			}

			table th {
				background-color: #444;
				font-weight: bold;
			}

			table th:last-child, td:last-child {
				text-align: right;
			}

			table tr {
				opacity: 0;
				transform: translateY(30px);
				animation: fadeInUp 0.5s forwards;
			}

			table tr:nth-child(odd) {
				animation-delay: 0.2s;
			}

			table tr:nth-child(even) {
				animation-delay: 0.4s;
			}

			table tr:hover {
				background-color: #444;
			}

			table .file-actions {
				font-size: 0;
			}

			table .file-actions button {
				background-color: #444;
				color: #fff;
				border: none;
				padding: 8px 16px;
				margin-left: 10px;
				cursor: pointer;
				border-radius: 5px;
				user-select: none;
			}

			table .file-actions button:hover {
				background-color: #66bb6a;
			}

			@keyframes fadeInUp {
				to {
					opacity: 1;
					transform: translateY(0);
				}
			}
			
			.upload-container {
				position: fixed;
				top: 0;
				z-index: 999;
				padding: 50px;
				width: 100%;
				height: 100%;
				background-color: #2e2e2e;
				box-sizing: border-box;
			}
			
			.upload-container.hidden {
				display: none;
			}
			
			.upload-container svg {
				width: 50px;
				fill: #888;
			}
			
			.upload-container div {
				border: 2px dashed #888;
				border-radius: 10px;
				width: 100%;
				height: 100%;
				display: flex;
				justify-content: center;
				align-items: center;
			}
		</style>
	</head>
	<body>
		<section>
			<includes-scrollbar><?php include('../includes/scrollbar.html') ?></includes-scrollbar>
			<includes-message><?php include('../includes/message.html') ?></includes-message>
			
			<div class="upload-container hidden">
				<div>
					<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
						<path d="M925.696 384q19.456 0 37.376 7.68t30.72 20.48 20.48 30.72 7.68 37.376q0 20.48-7.68 37.888t-20.48 30.208-30.72 20.48-37.376 7.68l-287.744 0 0 287.744q0 20.48-7.68 37.888t-20.48 30.208-30.72 20.48-37.376 7.68q-20.48 0-37.888-7.68t-30.208-20.48-20.48-30.208-7.68-37.888l0-287.744-287.744 0q-20.48 0-37.888-7.68t-30.208-20.48-20.48-30.208-7.68-37.888q0-19.456 7.68-37.376t20.48-30.72 30.208-20.48 37.888-7.68l287.744 0 0-287.744q0-19.456 7.68-37.376t20.48-30.72 30.208-20.48 37.888-7.68q39.936 0 68.096 28.16t28.16 68.096l0 287.744 287.744 0z"></path>
					</svg>
				</div>
			</div>
			
			<main>
				<div class="header-container">
					<div class="page-header">
						<div class="breadcrumb">
							<a class="home" href="{echo:var.index}" onclick="window.parent.loading()">🏠</a>
							<span foreach(var.fileserver_list.breadcrumb,var.key,var.value)>
								<span>></span>
								<a href="?p={echo:var.value}" onclick="window.parent.loading()">{echo:var.key}</a>
							</span>
						</div>
						<div class="refresh" onclick="location.reload();window.parent.loading()">
							<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
								<path d="M674.133333 750.933333c-51.2 34.133333-106.666667 55.466667-166.4 51.2h-29.866666c-4.266667 0-12.8 0-17.066667-4.266666-4.266667 0-8.533333 0-12.8-4.266667-4.266667 0-12.8-4.266667-17.066667-4.266667-4.266667 0-4.266667 0-8.533333-4.266666-8.533333-4.266667-12.8-4.266667-21.333333-8.533334h-4.266667c-8.533333 0-12.8-4.266667-21.333333-8.533333-25.6-12.8-46.933333-29.866667-64-51.2l-17.066667-17.066667-4.266667-4.266666c-38.4-51.2-64-115.2-64-183.466667h68.266667s4.266667 0 4.266667-4.266667v-4.266666l-110.933334-170.666667-4.266666-4.266667s-4.266667 0-4.266667 4.266667l-110.933333 170.666667v4.266666l4.266666 4.266667h68.266667c0 81.066667 25.6 153.6 68.266667 217.6v4.266667c4.266667 4.266667 8.533333 12.8 12.8 17.066666 0 4.266667 4.266667 4.266667 4.266666 8.533334 8.533333 8.533333 12.8 17.066667 21.333334 25.6v4.266666c25.6 25.6 55.466667 46.933333 85.333333 64h4.266667c4.266667 0 12.8 4.266667 25.6 8.533334 4.266667 0 4.266667 4.266667 8.533333 4.266666 8.533333 4.266667 17.066667 4.266667 25.6 8.533334 4.266667 0 8.533333 4.266667 12.8 4.266666 8.533333 4.266667 12.8 4.266667 21.333333 4.266667 4.266667 0 8.533333 4.266667 12.8 4.266667h4.266667c8.533333 0 12.8 0 21.333333 4.266666h46.933334c76.8 0 149.333333-25.6 213.333333-68.266666 21.333333-12.8 25.6-42.666667 12.8-64-17.066667-17.066667-46.933333-21.333333-68.266667-8.533334zM955.733333 512h-68.266666c0-81.066667-25.6-153.6-68.266667-217.6v-4.266667c-4.266667-8.533333-12.8-12.8-17.066667-21.333333v-4.266667c-38.4-46.933333-85.333333-85.333333-140.8-106.666666h-4.266666c-8.533333-4.266667-17.066667-8.533333-25.6-8.533334-4.266667 0-8.533333-4.266667-8.533334-4.266666-8.533333-4.266667-17.066667-4.266667-25.6-4.266667-4.266667 0-8.533333-4.266667-12.8-4.266667h-8.533333c-4.266667 0-12.8 0-17.066667-4.266666h-42.666666-4.266667c-76.8 0-149.333333 25.6-213.333333 68.266666-21.333333 12.8-29.866667 38.4-12.8 59.733334 12.8 21.333333 42.666667 25.6 64 12.8 51.2-34.133333 106.666667-51.2 166.4-51.2h34.133333c8.533333 0 12.8 0 21.333333 4.266666h8.533334c8.533333 0 12.8 4.266667 21.333333 4.266667h4.266667c8.533333 4.266667 12.8 4.266667 21.333333 8.533333h4.266667c42.666667 17.066667 81.066667 46.933333 106.666666 81.066667 42.666667 51.2 64 115.2 64 183.466667h-68.266666s-4.266667 0-4.266667 4.266666v4.266667l110.933333 170.666667 4.266667 4.266666s4.266667 0 4.266667-4.266666l110.933333-170.666667c0 4.266667 0 4.266667-4.266667 0 4.266667 0 0 0 0 0z"></path>
							</svg>
						</div>
					</div>
					
					<progress id="progress" value="0" max="0"></progress>
					<input type="file" id="fileInput" multiple hidden>
					<input type="file" id="folderInput" webkitdirectory multiple hidden>
					
					<div class="actions-header">
						<div class="buttons">
							<a class="button" href="javascript:document.getElementById('fileInput').click()"><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M640 170.666667H213.333333v682.666666h597.333334V341.333333h-170.666667V170.666667zM128 127.658667C128 104.277333 147.072 85.333333 170.581333 85.333333H682.666667l213.333333 213.333334v596.992A42.666667 42.666667 0 0 1 853.632 938.666667H170.368A42.666667 42.666667 0 0 1 128 896.341333V127.658667zM554.666667 512v170.666667h-85.333334v-170.666667H341.333333l170.666667-170.666667 170.666667 170.666667h-128z"></path></svg>上传文件</a>
							<a class="button" href="javascript:document.getElementById('folderInput').click()"><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M546.1504 153.6a51.2 51.2 0 0 1 30.72 10.24L665.6 230.4h204.8a51.2 51.2 0 0 1 51.2 51.2V819.2a51.2 51.2 0 0 1-51.2 51.2H153.6a51.2 51.2 0 0 1-51.2-51.2V204.8a51.2 51.2 0 0 1 51.2-51.2h392.5504z m-14.7456 76.8H179.2v563.2h665.6V307.2h-193.9456a51.2 51.2 0 0 1-30.72-10.24l-88.7296-66.56z m-44.7488 139.264a38.4 38.4 0 0 1 54.272 0l126.7712 126.72a38.4 38.4 0 0 1-54.272 54.272l-63.0272-62.976v163.84a38.4 38.4 0 1 1-76.8 0v-160.256l-59.3408 59.392a38.4 38.4 0 0 1-54.272-54.272z"></path></svg>上传文件夹</a>
						</div>
					</div>
				</div>
				
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
						<tr if(var.fileserver_list.path,!==,'')>
							<td>
								<svg class="svg-icon" viewBox="0 0 1029 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path d="M697.95 5.095H331.144c-179.837 0-326.05 145.703-326.05 326.05V697.95c0 179.837 146.213 326.05 326.05 326.05H697.95C877.787 1024 1024 877.787 1024 697.95V331.144c0-180.346-146.213-326.05-326.05-326.05z m59.097 728.517s-4.076 12.227-10.699 0c0 0-73.36-223.14-253.198-167.61v69.286s-2.547 39.227-38.209 13.755l-176.78-152.327s-36.68-20.378 2.547-47.888l179.837-153.345s25.982-18.85 32.605 12.226v74.89s333.182 16.302 263.897 351.013z m83.55-433.035c-28.02 0-50.945-22.925-50.945-50.945s22.925-50.945 50.945-50.945 50.945 22.925 50.945 50.945-22.925 50.945-50.945 50.945z" fill="#DD6572"></path>
								</svg>
								<a href="?p={echo:var.fileserver_list.parent}" onclick="window.parent.loading()">上一级目录</a>
							</td>
							
							<td></td>
							
							<td></td>
							
							<td></td>
						</tr>
						
						<tr foreach(var.fileserver_list.list,var.key,var.value)>
							<td if(var.value.is_dir,==,false)>
								<span class="icon">📄</span>
								<a>{echo:var.value.name}</a>
							</td>
							
							<td if(var.value.is_dir,==,true)>
								<span class="icon">📂</span>
								<a href="?p={echo:var.value.path}" onclick="window.parent.loading()">{echo:var.value.name}</a>
							</td>
							
							<td>{echo:var.value.size}</td>
							
							<td>{echo:var.value.time}</td>
							
							<td if(var.value.is_dir,==,false) class="file-actions">
								<svg class="svg-icon pointer" onclick="new TextEditor({echo:var.key})" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path d="M275.3 608.2c0 17.6 14.4 32.1 32.1 32.1h409.2c17.7 0 32.1-14.4 32.1-32.1 0-17.6-14.4-32.1-32.1-32.1H307.4c-17.6 0-32.1 14.4-32.1 32.1zM498.5 320H307.4c-17.6 0-32.1 14.4-32.1 32.1 0 17.6 14.4 32.1 32.1 32.1h191.1c17.7 0 32.2-14.4 32.1-32.1 0-17.6-14.4-32.1-32.1-32.1zM848.9 132.5L579.8 401.6c-12.5 12.5-12.5 32.9 0.1 45.4 12.5 12.5 32.9 12.5 45.4 0l269-269.1c12.5-12.5 12.5-32.9 0-45.4s-32.9-12.5-45.4 0z" fill="#ddd"></path>
									<path d="M931.8 62.8a32.2 32.1 0 1 0 64.4 0 32.2 32.1 0 1 0-64.4 0Z" fill="#ddd"></path>
									<path d="M865.9 352c-17.8 0-32.2 14.4-32.2 32.1v0.1h-0.3v446.4c0 35.2-28.8 64-64 64H222.2c-35.2 0-64-28.8-64-64V192c0-35.2 28.8-64 64-64h482.4c17.6-0.3 31.7-14.5 31.7-32.1 0-17.7-14.4-32.1-32.2-32.1-0.8 0-1.6 0-2.4 0.1H226c-70.4 0-128 57.6-128 128v639.7c0 70.4 57.6 128 128 128h574c70.4 0 98-57.6 98-128V386.5c0.1-0.8 0.1-1.6 0.1-2.4 0-17.7-14.4-32.1-32.2-32.1z" fill="#ddd"></path>
								</svg>
								
								<svg class="svg-icon pointer" onclick="openDelete({echo:var.key})"  viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path fill="#f44336" d="M51.2 237.056V215.04c9.728-17.408 25.088-22.528 45.568-22.016 58.88 1.024 118.272 0.512 177.152 0.512 7.68 0 16.384-0.512 25.088-1.024v-26.624c1.024-48.128 30.208-76.8 81.408-78.848 11.776-0.512 23.04 0 34.304 0 73.728 0 147.456-0.512 221.184 0 57.856 0.512 87.552 27.136 90.112 82.432l1.536 24.064c68.608 0 135.168 0.512 201.728-0.512 19.968-0.512 34.304 5.632 43.52 22.016v22.016c-12.8 16.896-31.744 20.48-52.224 19.456-26.624-1.024-53.248 0-81.92 0v550.912c0 51.2-19.456 91.648-69.632 115.712-13.824 6.656-29.696 9.728-45.056 14.336H300.032c-93.184-28.16-114.176-56.32-114.176-152.064V256.512c-30.72 0-58.88-1.024-87.04 0.512-19.968 0.512-36.352-4.096-47.616-19.968z m313.856-45.568h293.376c0-9.216-0.512-16.384 0-23.552 1.024-12.8-5.632-18.432-18.944-18.432-84.992 0.512-169.984 0-254.976 0-13.824 0-19.968 6.144-19.456 18.432v23.552z m336.384 390.144c0-53.76 0-108.544-0.512-163.328 0-26.624-9.728-40.448-29.696-40.96-18.944-0.512-31.232 14.336-31.232 39.936-0.512 108.032 0 215.552 0 323.072 0.512 25.6 12.288 40.96 31.232 40.448 18.944-0.512 30.208-15.36 30.208-41.472v-157.696z m-314.368-2.048c-0.512 0-0.512 0 0 0-0.512-55.808 0-111.616 0-167.424-0.512-20.992-13.312-33.792-30.72-33.792-17.92 0.512-29.184 12.8-30.72 34.304v324.096c0 5.632-1.024 11.776 0.512 17.408 3.584 16.896 13.312 27.648 30.208 27.648 16.384-0.512 27.136-10.24 29.696-27.648 1.024-7.168 1.024-14.336 1.024-22.016v-152.576z m158.72 0.512V414.208c0-23.04-11.264-36.352-30.208-36.864-19.456-0.512-31.232 13.824-31.232 37.888v328.192c0 23.04 11.776 36.864 30.208 37.376 18.944 0.512 31.232-13.824 31.232-37.888v-162.816z"></path>
								</svg>
							</td>
							
							<td if(var.value.is_dir,==,true) class="file-actions">
								<svg if(var.fileserver_list.path,===,'') class="svg-icon pointer" onclick="urlconsole({echo:var.key})"  viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path fill="#FF9800" d="M853.3504 102.4H170.6496C133.0688 102.4 102.4 133.12 102.4 170.6496v512c0 37.5296 30.72 68.1984 68.2496 68.1984h204.8c0 37.5808-30.72 68.2496-68.2496 68.2496-29.0304 0-51.2 22.2208-51.2 51.2512C256 899.4304 278.1184 921.6 307.2 921.6h409.6c29.0304 0 51.2-22.1696 51.2-51.2 0-29.0816-22.1696-51.3024-51.2-51.3024-37.5296 0-68.2496-30.72-68.2496-68.1984h204.8c37.5296 0 68.2496-30.72 68.2496-68.2496v-512C921.6 133.0688 890.88 102.4 853.3504 102.4z m-119.4496 460.8H680.96a85.76 85.76 0 0 1-83.712 68.3008A86.016 86.016 0 0 1 513.6384 563.2H290.0992c-8.4992 0-17.0496-8.4992-17.0496-17.1008 0-8.4992 8.4992-17.0496 17.0496-17.0496h223.6416A85.76 85.76 0 0 1 597.4016 460.8c40.96 0 75.1104 29.0304 83.6608 68.2496h52.8896c8.4992 0 17.1008 8.4992 17.1008 17.0496-0.1024 8.4992-8.704 17.1008-17.152 17.1008z m0-238.8992H510.2592a85.76 85.76 0 0 1-83.6608 68.1984 86.016 86.016 0 0 1-83.6608-68.1984H290.048c-8.4992 0-17.1008-8.4992-17.1008-17.1008 0-8.4992 8.4992-17.1008 17.1008-17.1008h52.9408a85.76 85.76 0 0 1 83.712-68.1984c40.9088 0 75.0592 29.0304 83.6608 68.1984h223.5904c8.4992 0 17.1008 8.4992 17.1008 17.1008-0.1024 8.4992-8.704 17.1008-17.152 17.1008z m-187.8016 221.8496a51.2 51.2 0 1 0 102.4512 0 51.2 51.2 0 0 0-102.5024 0zM379.3408 326.8096a51.2 51.2 0 1 1 94.72-39.2192 51.2 51.2 0 0 1-94.72 39.2192z"></path>
								</svg>
								
								<svg class="svg-icon pointer" onclick="openDelete({echo:var.key})"  viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path fill="#f44336" d="M51.2 237.056V215.04c9.728-17.408 25.088-22.528 45.568-22.016 58.88 1.024 118.272 0.512 177.152 0.512 7.68 0 16.384-0.512 25.088-1.024v-26.624c1.024-48.128 30.208-76.8 81.408-78.848 11.776-0.512 23.04 0 34.304 0 73.728 0 147.456-0.512 221.184 0 57.856 0.512 87.552 27.136 90.112 82.432l1.536 24.064c68.608 0 135.168 0.512 201.728-0.512 19.968-0.512 34.304 5.632 43.52 22.016v22.016c-12.8 16.896-31.744 20.48-52.224 19.456-26.624-1.024-53.248 0-81.92 0v550.912c0 51.2-19.456 91.648-69.632 115.712-13.824 6.656-29.696 9.728-45.056 14.336H300.032c-93.184-28.16-114.176-56.32-114.176-152.064V256.512c-30.72 0-58.88-1.024-87.04 0.512-19.968 0.512-36.352-4.096-47.616-19.968z m313.856-45.568h293.376c0-9.216-0.512-16.384 0-23.552 1.024-12.8-5.632-18.432-18.944-18.432-84.992 0.512-169.984 0-254.976 0-13.824 0-19.968 6.144-19.456 18.432v23.552z m336.384 390.144c0-53.76 0-108.544-0.512-163.328 0-26.624-9.728-40.448-29.696-40.96-18.944-0.512-31.232 14.336-31.232 39.936-0.512 108.032 0 215.552 0 323.072 0.512 25.6 12.288 40.96 31.232 40.448 18.944-0.512 30.208-15.36 30.208-41.472v-157.696z m-314.368-2.048c-0.512 0-0.512 0 0 0-0.512-55.808 0-111.616 0-167.424-0.512-20.992-13.312-33.792-30.72-33.792-17.92 0.512-29.184 12.8-30.72 34.304v324.096c0 5.632-1.024 11.776 0.512 17.408 3.584 16.896 13.312 27.648 30.208 27.648 16.384-0.512 27.136-10.24 29.696-27.648 1.024-7.168 1.024-14.336 1.024-22.016v-152.576z m158.72 0.512V414.208c0-23.04-11.264-36.352-30.208-36.864-19.456-0.512-31.232 13.824-31.232 37.888v328.192c0 23.04 11.776 36.864 30.208 37.376 18.944 0.512 31.232-13.824 31.232-37.888v-162.816z"></path>
								</svg>
							</td>
						</tr>
					</tbody>
				</table>
			</main>
		</section>
		
		
		<div-editor>
			<style>
				.editor-container {
					position: fixed;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					z-index: 99;
					background-color: #2d2d2d;
					display: flex;
					flex-direction: column;
				}
				.editor-container.hidden {
					display: none;
				}

				.editor-container .toolbar {
					display: flex;
					justify-content: space-between;
					align-items: center;
					margin-top: 10px;
					padding: 10px;
					background-color: #202020;
					border-radius: 6px;
					flex-shrink: 0;
				}

				.editor-container .toolbar-left {
					display: flex;
					gap: 12px;
				}

				.editor-container .toolbar-right {
					display: flex;
					gap: 12px;
				}

				.editor-container .toolbar-button {
					background-color: #3a3a3a;
					border: none;
					border-radius: 6px;
					color: #e0e0e0;
					padding: 10px 16px;
					display: flex;
					align-items: center;
					gap: 8px;
					cursor: pointer;
					transition: all 0.2s ease;
					font-size: 0.95rem;
				}

				.editor-container .toolbar-button:hover {
					background-color: #4a4a4a;
				}

				.editor-container .toolbar-button:disabled {
					opacity: 0.5;
					cursor: not-allowed;
				}

				.editor-container .toolbar-button svg {
					width: 18px;
					height: 18px;
				}

				.editor-container .action-button {
					padding: 10px 16px;
					border-radius: 6px;
					border: none;
					font-size: 0.95rem;
					font-weight: 500;
					cursor: pointer;
					transition: all 0.2s ease;
					display: flex;
					align-items: center;
					justify-content: center;
					gap: 8px;
					min-width: 80px;
				}

				.editor-container .action-button svg {
					width: 18px;
					height: 18px;
				}

				.editor-container .cancel-button {
					background-color: #3a3a3a;
					color: #e0e0e0;
				}

				.editor-container .cancel-button:hover {
					background-color: #4a4a4a;
				}

				.editor-container .save-button {
					background-color: #6c8cff;
					color: #ffffff;
				}

				.editor-container .save-button:hover {
					background-color: #5a7cff;
				}

				.editor-container .save-button:disabled {
					background-color: #4a5a9a;
					cursor: not-allowed;
				}

				.editor-container .editor-area-wrapper {
					flex: 1;
					overflow: hidden;
					display: flex;
					flex-direction: column;
				}

				.editor-container .editor-area {
					width: 100%;
					height: 100%;
					background-color: #252525;
					border: 1px solid #404040;
					border-radius: 6px;
					padding: 15px;
					color: #e0e0e0;
					font-size: 1rem;
					line-height: 1.6;
					outline: none;
					resize: none;
					font-family: inherit;
					box-sizing: border-box;
				}

				/* 自定义滚动条样式 */
				.editor-container .editor-area::-webkit-scrollbar {
					width: 10px;
				}

				.editor-container .editor-area::-webkit-scrollbar-track {
					background: #202020;
					border-radius: 4px;
				}

				.editor-container .editor-area::-webkit-scrollbar-thumb {
					background: #6c8cff;
					border-radius: 4px;
				}

				.editor-container .editor-area::-webkit-scrollbar-thumb:hover {
					background: #5a7cff;
				}

				.editor-container .editor-area:focus {
					border-color: #6c8cff;
					box-shadow: 0 0 0 2px rgba(108, 140, 255, 0.2);
				}

				/* 移除原有的placeholder样式，使用textarea原生placeholder */
				.editor-container .editor-area::placeholder {
					color: #888;
					font-style: italic;
				}

				/* 加载动画 */
				.editor-container .loading-spinner {
					display: inline-block;
					width: 18px;
					height: 18px;
					border: 2px solid rgba(255, 255, 255, 0.3);
					border-radius: 50%;
					border-top-color: #ffffff;
					animation: spin 0.8s linear infinite;
				}

				@keyframes spin {
					to { transform: rotate(360deg); }
				}
			</style>
			<div class="editor-container hidden">
				<div class="editor-area-wrapper">
					<textarea 
						id="editor" 
						class="editor-area" 
						spellcheck="false"
						placeholder="在这里输入文本..."
					></textarea>
				</div>
				
				<div class="toolbar">
					<div class="toolbar-left">
						<button id="undoBtn" class="toolbar-button" disabled>
							<svg viewBox="0 0 24 24" fill="currentColor">
								<path d="M12.5 8c-2.65 0-5.05.99-6.9 2.6L2 7v9h9l-3.62-3.62c1.39-1.16 3.16-1.88 5.12-1.88 3.54 0 6.55 2.31 7.6 5.5l2.37-.78C21.08 11.03 17.15 8 12.5 8z"/>
							</svg>
							撤回
						</button>
						
						<button id="redoBtn" class="toolbar-button" disabled>
							<svg viewBox="0 0 24 24" fill="currentColor">
								<path d="M18.4 10.6C16.55 8.99 14.15 8 11.5 8c-4.65 0-8.58 3.03-9.96 7.22L3.9 16c1.05-3.19 4.05-5.5 7.6-5.5 1.95 0 3.73.72 5.12 1.88L15 19h9v-9l-3.6 3.6z"/>
							</svg>
							重做
						</button>
					</div>
					
					<div class="toolbar-right">
						<button id="cancelBtn" class="action-button cancel-button">
							<svg viewBox="0 0 24 24" fill="currentColor">
								<path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
							</svg>
							关闭
						</button>
						
						<button id="saveBtn" class="action-button save-button">
							<svg viewBox="0 0 24 24" fill="currentColor">
								<path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
							</svg>
							保存
						</button>
					</div>
				</div>
			</div>
		</div-editor>
		
		
		<div-modal>
			<style>
				.delete {
					position: fixed;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					z-index: 99;
					display: flex;
					justify-content: center;
					align-items: center;
					user-select: none;
					background: rgba(0, 0, 0, 0.3);
					backdrop-filter: blur(3px);
				}
				.delete.hidden {
					display: none;
				}
				
				.delete * {
					margin: 0;
					padding: 0;
					box-sizing: border-box;
					font-family: 'Segoe UI', system-ui, sans-serif;
				}
				
				.delete-window {
					background-color: #3a3a3a;
					border-radius: 10px;
					box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
					width: 100%;
					max-width: 500px;
					overflow: hidden;
					color: #f0f0f0;
					border: 1px solid #4a4a4a;
				}
				
				.delete .window-header {
					background-color: #4a4a4a;
					padding: 18px 24px;
					display: flex;
					align-items: center;
					border-bottom: 1px solid #5a5a5a;
				}
				
				.delete .window-title {
					font-size: 18px;
					font-weight: 600;
					margin-left: 5px;
				}
				
				.delete .window-content {
					padding: 28px 24px;
				}
				
				.delete .file-info {
					display: flex;
					align-items: center;
					margin-bottom: 24px;
					background-color: #444;
					padding: 14px;
					border-radius: 6px;
				}
				
				.delete .file-icon {
					margin-right: 10px;
					vertical-align: middle;
				}
				
				.delete .file-icon svg {
					vertical-align: top;
				}
				
				.delete .file-name {
					font-size: 16px;
					font-weight: 500;
					color: #fff;
				}
				
				.delete .warning-message {
					color: #ff9c7c;
					font-size: 15px;
					line-height: 1.5;
					margin-bottom: 22px;
					padding-left: 6px;
				}
				
				.delete .password-section {
					margin-top: 26px;
				}
				
				.delete .password-label {
					display: block;
					margin-bottom: 10px;
					font-size: 14px;
					color: #ccc;
				}
				
				.delete .password-input {
					width: 100%;
					padding: 14px 16px;
					background-color: #444;
					border: 1px solid #555;
					border-radius: 6px;
					color: #fff;
					font-size: 15px;
					transition: all 0.2s;
				}
				
				.delete .password-input:focus {
					outline: none;
					border-color: #6a9eff;
					box-shadow: 0 0 0 2px rgba(106, 158, 255, 0.2);
				}
				
				.delete .password-input::placeholder {
					color: #888;
				}
				
				.delete .button-group {
					display: flex;
					justify-content: flex-end;
					gap: 12px;
					margin-top: 28px;
				}
				
				.delete .btn {
					padding: 12px 24px;
					border-radius: 6px;
					font-size: 15px;
					font-weight: 500;
					cursor: pointer;
					transition: all 0.2s;
					border: none;
				}
				
				.delete .btn-cancel {
					background-color: #555;
					color: #ddd;
				}
				
				.delete .btn-cancel:hover {
					background-color: #666;
				}
				
				.delete .btn-delete {
					background-color: #d9534f;
					color: white;
				}
				
				.delete .btn-delete:hover {
					background-color: #c9302c;
				}
			</style>
			<div class="delete hidden">
				<div class="delete-window">
					<div class="window-header">
						<span class="window-title">确认删除</span>
					</div>
					
					<div class="window-content">
						<div class="file-info">
							<div class="file-icon">
								<!-- SVG 图标：文件 -->
								<svg width="25" height="25" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M14 2H6C5.46957 2 4.96086 2.21071 4.58579 2.58579C4.21071 2.96086 4 3.46957 4 4V20C4 20.5304 4.21071 21.0391 4.58579 21.4142C4.96086 21.7893 5.46957 22 6 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V8L14 2Z" stroke="#6a9eff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M14 2V8H20" stroke="#6a9eff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</div>
							<div class="file-name">project_backup_2024.zip</div>
						</div>
						
						<div class="warning-message">
							此操作将永久删除该文件。删除后无法恢复，请确认您已备份重要数据。
						</div>
						
						<div class="password-section">
							<label class="password-label">请输入您的密码以确认删除：</label>
							<input type="password" class="password-input" id="passwordInput" placeholder="输入密码..." autocomplete="current-password">
						</div>
						
						<div class="button-group">
							<button class="btn btn-cancel" onclick="closeDelete()">取消</button>
							<button class="btn btn-delete">删除文件</button>
						</div>
					</div>
				</div>
			</div>
		</div-modal>
		
		
		<script>
			class TextEditor {
				constructor(index) {
					this.path = list[index].path;
					
					this.editor = document.getElementById('editor'); // 现在这是一个 textarea
					this.undoBtn = document.getElementById('undoBtn');
					this.redoBtn = document.getElementById('redoBtn');
					this.saveBtn = document.getElementById('saveBtn');
					this.cancelBtn = document.getElementById('cancelBtn');
					this.statusMessage = document.getElementById('statusMessage');
					
					// 历史记录相关
					this.history = [''];
					this.currentIndex = 0;
					
					// 初始化
					this.init();
				}
				
				init() {
					// 初始化事件监听
					this.editor.onclick    = () => this.handleInput();
					this.undoBtn.onclick   = () => this.undo();
					this.redoBtn.onclick   = () => this.redo();
					this.saveBtn.onclick   = () => this.save();
					this.cancelBtn.onclick = () => this.cancel();
					
					// 添加键盘快捷键
					document.addEventListener('keydown', (e) => {
						// Ctrl+Z 撤回
						if (e.ctrlKey && e.key === 'z') {
							e.preventDefault();
							this.undo();
						}
						
						// Ctrl+Y 重做
						if (e.ctrlKey && e.key === 'y') {
							e.preventDefault();
							this.redo();
						}
						
						// Ctrl+S 保存
						if (e.ctrlKey && e.key === 's') {
							e.preventDefault();
							this.save();
						}
						
						// Esc 取消
						if (e.key === 'Escape') {
							this.cancel();
						}
					});
					
					// 初始化按钮状态
					this.updateButtons();
					
					// 加载文件内容
					const params = new URLSearchParams();
					params.append('mods', 'fileserver_read');
					params.append('p', this.path);
					
					fetch(`/weiw/index.php?${params.toString()}`)
						.then(response => response.json())
						.then(data => {
							if (data.error) {
								throw new Error(data.error);
								return;
							}
							
							this.editor.value = data.data;
							// 初始化历史记录
							this.history = [data.data];
							this.currentIndex = 0;
							this.updateButtons();
							
							// 显示编辑器
							this.show();
						})
						.catch(error => {
							showMessage('读取文件失败: ' + error.message);
						});
				}
				
				handleInput() {
					// 延迟添加到历史记录，避免频繁记录
					clearTimeout(this.inputTimeout);
					this.inputTimeout = setTimeout(() => {
						this.addToHistory();
					}, 500);
				}
				
				addToHistory() {
					const text = this.editor.value; // 使用 value 而不是 innerHTML
					
					// 如果当前文本与历史记录中最新的一条相同，则不添加
					if (this.history[this.currentIndex] === text) {
						return;
					}
					
					// 移除当前索引之后的所有历史记录
					this.history = this.history.slice(0, this.currentIndex + 1);
					
					// 添加新记录
					this.history.push(text);
					this.currentIndex++;
					
					// 限制历史记录数量，避免内存占用过大
					if (this.history.length > 100) {
						this.history = this.history.slice(-50);
						this.currentIndex = this.history.length - 1;
					}
					
					// 更新UI
					this.updateButtons();
				}
				
				undo() {
					if (this.currentIndex > 0) {
						this.currentIndex--;
						this.editor.value = this.history[this.currentIndex]; // 使用 value
						this.updateButtons();
						setTimeout(() => this.hideStatus(), 1500);
					}
				}
				
				redo() {
					if (this.currentIndex < this.history.length - 1) {
						this.currentIndex++;
						this.editor.value = this.history[this.currentIndex]; // 使用 value
						this.updateButtons();
						setTimeout(() => this.hideStatus(), 1500);
					}
				}
				
				updateButtons() {
					this.undoBtn.disabled = this.currentIndex <= 0;
					this.redoBtn.disabled = this.currentIndex >= this.history.length - 1;
				}
				
				save() {
					// 禁用保存按钮，显示加载动画
					this.saveBtn.disabled = true;
					this.saveBtn.innerHTML = '<span class="loading-spinner"></span> 保存中...';
					
					const formData = new FormData();
					formData.append('path', this.path);
					formData.append('content', this.editor.value);
					
					// 发送保存请求到服务器
					fetch('/weiw/index.php?mods=fileserver_write', {
						method: 'POST',
						body: formData
					})
					.then(response => response.json())
					.then(data => {
						if (data.error) {
							throw new Error(data.error);
						}
						
						// 保存成功
						showMessage('内容已成功保存！');
					})
					.catch(error => {
						showMessage('保存失败: ' + error.message);
					})
					.finally(() => {
						// 恢复保存按钮
						this.saveBtn.disabled = false;
						this.saveBtn.innerHTML = '保存';
						this.cancel();
					});
				}
				
				show() {
					document.body.style.overflow = 'hidden';
					document.querySelector(".editor-container").classList.remove('hidden');
				}
				
				cancel() {
					document.body.style.overflow = 'auto';
					document.querySelector(".editor-container").classList.add('hidden');
				}
			}
			
			
			
			const list = {json:var.fileserver_list.list};
			let total = 0;
			let loaded = 0;
			let dragCount = 0;
			
			document.getElementById('fileInput').addEventListener('change', async function(event) {
				
				// 从事件对象获取文件列表
				const files = Array.from(event.target.files);
				files.forEach(file => total += file.size);
				
				for (file of files) {
					await uploadFile(file, file.name);
				}
				
				location.reload();
			});
			
			document.getElementById('folderInput').addEventListener('change', async function(event) {
				
				// 从事件对象获取文件列表
				const files = Array.from(event.target.files);
				files.forEach(file => total += file.size);
				
				for (file of files) {
					await uploadFile(file, file.webkitRelativePath);
				}
				
				location.reload();
			});
			
			const upload = document.querySelector(".upload-container");
			const dropZone = document.querySelector("body");
			const progressBar = document.getElementById("progress");
			
			
			// 阻止默认的浏览器行为
			["dragenter", "dragover", "dragleave", "drop"].forEach(eventName => {
				dropZone.addEventListener(eventName, e => e.preventDefault());
			});
			
			// 当目录拖拽到区域时，添加样式
			dropZone.addEventListener("dragenter", (e) => {
				e.preventDefault();
				dragCount++;
				upload.classList.remove("hidden");
			});
			
			dropZone.addEventListener("dragleave", (e) => {
				dragCount--;
				if (dragCount === 0) {
					upload.classList.add("hidden");
				}
			});
			
			dropZone.addEventListener("drop", (e) => {
				e.preventDefault();
				dragCount = 0;
				upload.classList.add("hidden");
			});
			
			
			// 处理拖拽目录
			handleDropUpload(dropZone, async function(files) {
				
				files.forEach(file => total += file.file.size);
				
				for (file of files) {
					await uploadFile(file.file, file.path);
					console.log(file);
				}
				
				location.reload();
			});
			
			
			// 上传函数
			function uploadFile(file, path)
			{
				return new Promise((resolve, reject) => {
					const urlParams = new URLSearchParams(window.location.search);
					const url = new URL('/weiw/index.php', window.location.origin);
					url.searchParams.append('mods', 'fileserver_upload');
					url.searchParams.append('p', `${urlParams.get('p') ?? ''}/${path}`);
					
					const xhr = new XMLHttpRequest();
					const formData = new FormData();
					let previousLoaded = 0;
					formData.append("file", file);
					
					xhr.upload.addEventListener("progress", (e) => {
						if (e.lengthComputable)
						{
							loaded += e.loaded-previousLoaded;
							previousLoaded = e.loaded;
							progressBar.max = total;
							progressBar.value = loaded;
						}
					});
					
					xhr.addEventListener("load", () => {
						if (xhr.status === 200) resolve();
						else reject(xhr.statusText);
					});
					
					xhr.addEventListener("error", () => reject("Network error"));
					xhr.open("POST", url.toString(), true);
					xhr.send(formData);
				});
			}
			
			
			
			function handleDropUpload(dropZone, callbacks) {
				const files = []; // 存储所有文件

				// 递归遍历目录
				async function traverseDirectory(entry) {
					if (entry.isDirectory) {
						const reader = entry.createReader();
						let entries;

						do {
							entries = await new Promise((resolve, reject) =>
								reader.readEntries(resolve, reject)
							);

							for (const subEntry of entries) {
								await traverseDirectory(subEntry);
							}
						} while (entries.length > 0);
					}

					if (entry.isFile) {
						const file = await new Promise((resolve, reject) =>
							entry.file(resolve, reject)
						);

						files.push({
							file,
							path: entry.fullPath
						});
					}
				}

				dropZone.addEventListener("drop", async (event) => {
					event.preventDefault();

					const processPromises = [];

					for (const item of event.dataTransfer.items) {
						const entry = item.webkitGetAsEntry?.();
						if (entry) {
							processPromises.push(traverseDirectory(entry));
						}
					}

					// 等待目录遍历完成
					await Promise.all(processPromises);

					// 执行回调
					await callbacks(files);
				});
			}
			
			// 跳转到控制台页面
			function urlconsole(index)
			{
				window.location.replace('console.php?name='+encodeURIComponent(list[index].name));
				window.parent.loading();
			}
			
			// 打开删除确认窗口
			function openDelete(index)
			{
				document.body.style.overflow = 'hidden';
				document.querySelector(".delete").classList.remove('hidden');
				document.querySelector(".file-name").textContent = list[index].name;
				document.querySelector('.btn-delete').onclick = () => {
					
					const url = new URL('/weiw/index.php', window.location.origin);
					url.searchParams.append('mods', 'fileserver_delete');
					url.searchParams.append('password', document.querySelector(".password-input").value);
					url.searchParams.append('p', list[index].path);
					
					
					fetch(url.toString())
						.then(data => data.json())
						.then(data => {
							if (data.error) {
								showMessage(data.error);
								return;
							}
							
							location.reload();
							console.log(data);
						});
					
					closeDelete();
				};
			}
			
			// 关闭删除确认窗口
			function closeDelete() {
				document.body.style.overflow = 'auto';
				document.querySelector(".password-input").value = '';
				document.querySelector(".file-name").textContent = '';
				document.querySelector(".delete").classList.add('hidden');
			}
		</script>
	</body>
</html>