<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_users');
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
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
			section {
				margin: 0 10px;
				padding: 25px;
				overflow: auto;
				height: calc(100% - 10px);
				box-sizing: border-box;
			}
			main {
				max-width: 1200px;
				margin: 0 auto;
			}
			
			.container {
				color: white;
				padding: 30px;
				background-color: #333;
				border-radius: 10px;
				animation: fadeIn 1s ease-out;
			}

			.header {
				display: flex;
				justify-content: space-between;
				align-items: center;
				margin-bottom: 20px;
			}

			.header button {
				padding: 10px 20px;
				background-color: #FF6F61;
				color: white;
				border: none;
				border-radius: 5px;
				cursor: pointer;
				transition: background-color 0.3s;
			}

			.header button:hover {
				background-color: #FF4B3A;
			}

			.total {
				font-size: 18px;
			}

			.user-list {
				margin-top: 20px;
				animation: slideUp 0.8s ease-out;
			}

			table {
				width: 100%;
				border-collapse: collapse;
				border-radius: 8px;
				overflow: hidden;
				animation: fadeInTable 1s ease-out;
			}

			table th, table td {
				padding: 15px;
				text-align: left;
				border-bottom: 1px solid #444;
			}

			table th {
				background-color: #444;
			}

			table th:last-child {
				text-align: right;
			}

			table td:last-child {
				text-align: right;
			}

			table td {
				background-color: #555;
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

			.pagination {
				display: flex;
				justify-content: space-between;
				margin-top: 20px;
				font-size: 16px;
			}

			.pagination .page-info {
				color: #bbb;
			}

			.load-more {
				width: 100%;
				display: block;
				margin: 30px auto;
				padding: 10px 20px;
				background-color: #FF6F61;
				color: white;
				border: none;
				border-radius: 5px;
				cursor: pointer;
				text-align: center;
				transition: background-color 0.3s;
			}

			.load-more:hover {
				background-color: #FF4B3A;
			}

			.load-more:focus {
				outline: none;
			}

			@keyframes fadeIn {
				0% {
					opacity: 0;
					transform: translateY(-20px);
				}
				100% {
					opacity: 1;
					transform: translateY(0);
				}
			}

			@keyframes slideUp {
				0% {
					transform: translateY(30px);
					opacity: 0;
				}
				100% {
					transform: translateY(0);
					opacity: 1;
				}
			}

			@keyframes fadeInTable {
				0% {
					opacity: 0;
				}
				100% {
					opacity: 1;
				}
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
				<includes-message><?php include('includes/message.html') ?></includes-message>
				
				<div class="container">
					<div class="header">
						<button onclick="window.location.href='index.php'">返回首页</button>
						<div class="total">总共 {echo:var.mc_users.number} 个用户</div>
					</div>


					<loading-container>
						<div id="userList" class="user-list">
							<table>
								<thead>
									<tr>
										<th>用户名</th>
										<th>金币数</th>
										<th>登陆时间</th>
										<th>注册时间</th>
									</tr>
								</thead>
								
								
								<tbody>
									<tr foreach(var.mc_users.users,var.key,var.value)>
										<td>{echo:var.value.name}</td>
										<td>{echo:var.value.money}</td>
										<td>{echo:var.value.loginTime}</td>
										<td>{echo:var.value.registerTime}</td>
									</tr>
								</tbody>
							</table>


							<div class="pagination">
								<div class="page-info">第 {echo:var.mc_users.page.current} 页 / 共 {echo:var.mc_users.page.total} 页</div>
							</div>
						</div>
					</loading-container>


					<button class="load-more" onclick="loadingContainer()">加载更多</button>
				</div>
			</main>
		</section>

		<script src="js/main.js"></script>
		<script>
			let count = 2;
			
			
			function message(message) {
				showMessage(message);
				document.querySelector('section').scrollTop = 0;
			}
			function loadingContainer() {
				fetchAndAppendHtml(`users.php?findId=userList&current=${count}`, "loading-container", () => { count++ });
			}
		</script>
	</body>
</html>