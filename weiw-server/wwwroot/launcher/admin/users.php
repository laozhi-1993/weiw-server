<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_verify_access');
	$MKH ->mods('mc_user_list');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>用户列表管理</title>
		<style>
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
				font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			}
			
			body {
				background-color: #2e2e2e;
				color: #f0f0f0;
				line-height: 1.6;
				padding: 20px;
				padding-top: 0;
				min-height: 100vh;
			}
			
			.container {
				margin: 0 auto;
			}
			
			header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 30px;
				padding-bottom: 20px;
				border-bottom: 1px solid #444;
			}
			
			h1 {
				color: #4dabf7;
				font-size: 2.5rem;
				margin-bottom: 10px;
			}
			
			.main-content {
				display: flex;
				flex-direction: column;
				gap: 30px;
			}
			
			.control-panel {
				display: flex;
				justify-content: space-between;
				align-items: center;
				gap: 10px;
				background-color: #3a3a3a;
				border-radius: 10px;
				padding: 20px;
				box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
			}
			
			.user-number {
				display: flex;
				align-items: center;
				gap: 10px;
				color: #4dabf7;
			}
			
			.user-number svg {
				width: 35px;
				height: 35px;
				fill: currentColor;
			}
			
			.money-section {
				display: flex;
				flex-direction: column;
				gap: 10px;
				flex-direction: row;
				flex-wrap: wrap;
			}
			
			.money-input {
				padding: 8px 15px;
				background-color: #2e2e2e;
				border: 1px solid #555;
				border-radius: 6px;
				color: #fff;
				width: 250px;
			}
			
			.money-input:focus {
				outline: none;
				border-color: #4dabf7;
				box-shadow: 0 0 0 2px rgba(77, 171, 247, 0.2);
			}
			
			.money-input[type="number"]::-webkit-outer-spin-button,
			.money-input[type="number"]::-webkit-inner-spin-button {
				-webkit-appearance: none;
				margin: 0;
			}
			
			.btn {
				padding: 8px 25px;
				border: none;
				border-radius: 6px;
				font-weight: 600;
				cursor: pointer;
				transition: all 0.3s ease;
			}
			
			.btn-primary {
				background-color: #4dabf7;
				color: #fff;
			}
			
			.btn-primary:hover {
				background-color: #339af0;
				transform: translateY(-2px);
			}
			
			.btn:disabled {
				background-color: #666;
				cursor: not-allowed;
				transform: none;
			}
			
			.content-right {
				flex: 1;
			}
			
			.users-table-container {
				background-color: #3a3a3a;
				border-radius: 10px;
				overflow: hidden;
				box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
				margin-bottom: 30px;
				overflow-x: auto;
			}
			
			table {
				width: 100%;
				border-collapse: collapse;
			}
			
			thead {
				background-color: #2e2e2e;
			}
			
			th {
				padding: 18px 15px;
				text-align: left;
				font-weight: 600;
				color: #4dabf7;
				border-bottom: 2px solid #555;
			}
			
			td {
				padding: 15px;
				border-bottom: 1px solid #555;
			}
			
			.register-time {
				text-align: right;
			}
			
			tbody tr:hover {
				background-color: #444;
			}
			
			.money-cell {
				font-weight: bold;
				color: #40c057;
			}
			
			.money-cell.negative {
				color: #fa5252;
			}
			
			.user-avatar {
				width: 40px;
				height: 40px;
				border-radius: 50%;
				background-color: #4dabf7;
				display: flex;
				align-items: center;
				justify-content: center;
				font-weight: bold;
				color: white;
				margin-right: 10px;
			}
			
			.user-info {
				display: flex;
				align-items: center;
			}
			
			.user-name {
				font-weight: 600;
			}
			
			.pagination {
				display: flex;
				justify-content: space-between;
				align-items: center;
				gap: 10px;
				margin-top: 20px;
				padding: 20px;
				background-color: #3a3a3a;
				border-radius: 10px;
				box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
			}
			
			.page-controls {
				display: flex;
				gap: 10px;
			}
			
			.page-controls .pager {
				width: 100px;
				height: 40px;
				border-radius: 20px;
			}
			
			.page-info {
				display: flex;
				gap: 10px;
			}
			
			.page-info span {
				background-color: #333;
				border-radius: 5px;
				padding: 0 20px;
				line-height: 40px;
			}
			
			.page-btn {
				width: 40px;
				height: 40px;
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
				background-color: #444;
				color: #f0f0f0;
				border: none;
				cursor: pointer;
				font-weight: bold;
				transition: all 0.3s ease;
			}
			
			.page-btn:hover {
				background-color: #4dabf7;
				color: white;
			}
			
			.page-btn.active {
				background-color: #4dabf7;
				color: white;
			}
			
			.page-btn:disabled {
				background-color: #333;
				color: #666;
				cursor: not-allowed;
			}
			
			.status-message {
				padding: 15px;
				border-radius: 6px;
				margin-bottom: 20px;
				display: none;
				text-align: center;
				font-weight: 600;
			}
			
			.status-message.success {
				background-color: rgba(64, 192, 87, 0.2);
				color: #40c057;
				display: block;
			}
			
			.status-message.error {
				background-color: rgba(250, 82, 82, 0.2);
				color: #fa5252;
				display: block;
			}
			
			@media (max-width: 900px) {
				header {
					flex-direction: column;
					align-items: flex-start;
					gap: 20px;
				}
				
				.money-section {
					flex-direction: column;
					align-items: stretch;
				}
				
				.money-input {
					min-width: 100%;
				}
				
				th, td {
					padding: 12px 8px;
				}
				
				.btn {
					width: 100%;
					margin-bottom: 10px;
				}
			}
		</style>
	</head>
	<body>
		<div class="container">
			<includes-scrollbar><?php include('../includes/scrollbar.html') ?></includes-scrollbar>
			
			<header>
			</header>
			
			<div class="main-content">
				<div class="control-panel">
					<div class="user-number">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
							<path d="M938.666667 0H85.333333a85.333333 85.333333 0 0 0-85.333333 85.333333v853.333334a85.333333 85.333333 0 0 0 85.333333 85.333333h853.333334a85.333333 85.333333 0 0 0 85.333333-85.333333V85.333333a85.333333 85.333333 0 0 0-85.333333-85.333333zM512 870.4c-238.933333 0-341.333333-1.194667-341.333333-46.421333 0-108.885333 122.026667-153.6 156.330666-153.6s65.536-44.373333 65.536-44.373334c0-15.701333 10.24-18.602667 10.24-18.602666l18.944-2.901334 5.802667-32.085333a59.050667 59.050667 0 0 1-29.184-39.936l-10.24-44.202667a82.090667 82.090667 0 0 1-13.141333-12.8c-12.970667 0-27.818667-19.456-34.133334-46.421333s-2.218667-56.490667 11.434667-60.416a12.458667 12.458667 0 0 1 4.778667 0l-7.850667-82.090667a91.989333 91.989333 0 0 1 6.997333-36.693333C370.688 204.8 425.642667 102.4 617.813333 184.32c0 0 76.970667 50.176 109.738667 41.301333A75.093333 75.093333 0 0 1 682.666667 266.069333s22.869333 22.869333 46.421333 15.872l-58.026667 43.349334-3.584 44.373333a15.36 15.36 0 0 1 6.314667 0c14.848 3.925333 20.48 30.378667 12.458667 59.050667-6.997333 25.258667-22.186667 43.861333-35.84 45.397333a83.456 83.456 0 0 1-14.165334 13.824l-10.24 44.202667a59.050667 59.050667 0 0 1-29.184 39.936l5.802667 32.085333 18.944 2.901333s10.24 2.901333 10.24 18.602667c0 0 35.498667 44.202667 65.877333 44.202667s156.330667 48.128 156.330667 153.6C853.333333 870.4 755.712 870.4 512 870.4z"></path>
						</svg>
						<span>共 <span id="total"></span> 个用户</span>
					</div>
					<form class="money-section" action="/weiw/index.php?mods=mc_user_add_money" method="POST">
						<input type="text" name="name" class="money-input" required placeholder="输入要操作的用户名">
						<input type="number" name="money" class="money-input" required placeholder="输入金额（正数为增加负数为减少）">
						<button class="btn btn-primary">
							增加金钱
						</button>
					</form>
				</div>
				
				<div class="content-right">
					<div class="status-message" id="statusMessage"></div>
					
					<div class="users-table-container">
						<table id="usersTable">
							<thead>
								<tr>
									<th>用户</th>
									<th>金钱</th>
									<th>最近登录时间</th>
									<th class="register-time">注册时间</th>
								</tr>
							</thead>
							<tbody id="usersTableBody">
								<!-- 用户数据将通过JavaScript动态生成 -->
							</tbody>
						</table>
					</div>
					
					<div class="pagination" id="pagination">
						<!-- 分页按钮将通过JavaScript动态生成 -->
					</div>
				</div>
			</div>
		</div>
		
		<script src="../js/main.js"></script>
		<script>
			// 用户数据变量
			const data = {json: var.mc_user_list};
			const users = data.data;
			
			// 分页相关变量
			const currentPage = Number(data.current_page);
			const totalPages = Number(data.total_pages);
			
			// DOM元素
			const usersTableBody = document.getElementById('usersTableBody');
			const pagination = document.getElementById('pagination');
			const statusMessage = document.getElementById('statusMessage');
			const noResults = document.getElementById('noResults');
			
			// 格式化日期
			function formatTimestamp(timestamp, format = 'YYYY-MM-DD HH:mm:ss') {
				const date = new Date(timestamp * 1000);
				
				const year = date.getFullYear();
				const month = String(date.getMonth() + 1).padStart(2, '0');
				const day = String(date.getDate()).padStart(2, '0');
				const hours = String(date.getHours()).padStart(2, '0');
				const minutes = String(date.getMinutes()).padStart(2, '0');
				const seconds = String(date.getSeconds()).padStart(2, '0');
				
				// 替换格式化字符串中的占位符
				return format
					.replace('YYYY', year)
					.replace('MM', month)
					.replace('DD', day)
					.replace('HH', hours)
					.replace('mm', minutes)
					.replace('ss', seconds);
			}
			
			// 显示状态消息
			function showStatus(message, isSuccess = true) {
				statusMessage.textContent = message;
				statusMessage.className = `status-message ${isSuccess ? 'success' : 'error'}`;
				
				setTimeout(() => {
					statusMessage.className = 'status-message';
				}, 10000);
			}
			
			// 渲染用户表格
			function renderUsersTable() {
				usersTableBody.innerHTML = '';
				
				users.forEach(user => {
					html = `
						<tr>
							<td>
								<div class="user-info">
									<div>
										<div class="user-name">${user.name}</div>
									</div>
								</div>
							</td>
							<td class="money-cell">${user.money.toLocaleString()}</td>
							<td>${formatTimestamp(user.loginTime)}</td>
							<td class="register-time">${formatTimestamp(user.registerTime)}</td>
						</tr>
					`;
					
					usersTableBody.insertAdjacentHTML('beforeend', html)
				});
			}
			
			// 渲染分页控件
			function renderPagination() {
				// 生成页码按钮
				const maxVisiblePages = 5;
				let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
				let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
				
				if (endPage - startPage + 1 < maxVisiblePages) {
					startPage = Math.max(1, endPage - maxVisiblePages + 1);
				}
				
				// 构建页面按钮 HTML
				let pageButtonsHtml = '';
				for (let i = startPage; i <= endPage; i++) {
					pageButtonsHtml += `<button onclick="page(${i})" class="page-btn ${i === currentPage ? 'active' : ''}">${i}</button>`;
				}
				
				// 构建完整的分页 HTML
				pagination.innerHTML = `
					<div class="page-info">
						<span>第 ${currentPage} 页</span>
						<span>共 ${totalPages}  页</span>
					</div>
					<div class="page-controls">
						${pageButtonsHtml}
						<button class="page-btn pager" onclick="page(${currentPage-1})" ${currentPage === 1 ? 'disabled' : ''}>
							上一页
						</button>
						<button class="page-btn pager" onclick="page(${currentPage+1})" ${currentPage === totalPages ? 'disabled' : ''}>
							下一页
						</button>
					</div>
				`;
			}
			
			function page(i) {
				window.location.replace("?page=" + i);
			}
			
			// 初始化页面
			function initPage()
			{
				handleFormSubmit("form", (fetch) => {
					fetch.then((data) => {
						if (data.success) {
							showStatus(data.success);
							document.querySelector('form').reset();
						} else {
							showStatus(data.error, false);
						}
					});
				});
				
				renderUsersTable();
				renderPagination();
				document.getElementById('total').textContent = data.total;
			}
			
			// 页面加载完成后初始化
			document.addEventListener('DOMContentLoaded', initPage);
		</script>
	</body>
</html>