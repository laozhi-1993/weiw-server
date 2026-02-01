<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_verify_access');
	$MKH ->mods('mc_item_list');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>道具管理</title>
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
				text-align: center;
				margin-bottom: 30px;
				padding-bottom: 20px;
				border-bottom: 1px solid #444;
			}
			
			h1 {
				color: #4a9eff;
				margin-bottom: 10px;
				font-weight: 600;
			}
			
			.main-content {
				display: flex;
				flex-wrap: wrap;
				gap: 30px;
			}
			
			.main-content .panel {
				background-color: #3a3a3a;
				border-radius: 10px;
				box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
				padding: 25px;
				flex: 1;
				min-width: 300px;
			}
			
			.main-content .panel-title {
				color: #6c8eff;
				margin-bottom: 20px;
				padding-bottom: 10px;
				border-bottom: 1px solid #555;
				font-size: 1.5rem;
				display: flex;
				align-items: center;
				gap: 10px;
			}
			
			.main-content .panel-title svg {
				width: 25px;
				height: 25px;
				fill: currentColor;
			}
			
			/* 道具列表样式 */
			.main-content .items-list {
				flex: 2;
			}
			
			.main-content .table-container {
				overflow-x: auto;
			}
			
			.main-content table {
				width: 100%;
				border-collapse: collapse;
			}
			
			.main-content th {
				background-color: #4a4a4a;
				color: #6c8eff;
				text-align: left;
				padding: 15px 10px;
				font-weight: 600;
			}
			
			.main-content th:last-child {
				width: 185px;
				text-align: right;
			}
			
			.main-content td {
				cursor: grab;
				padding: 10px;
				border-bottom: 1px solid #555;
			}
			
			.main-content tr:hover {
				background-color: #444;
			}
			
			.main-content .item-icon {
				width: 40px;
				height: 40px;
				border-radius: 5px;
				object-fit: cover;
				background-color: #555;
				display: flex;
				align-items: center;
				justify-content: center;
				color: #aaa;
				font-size: 1.2rem;
			}
			
			.main-content .item-actions {
				display: flex;
				gap: 10px;
				justify-content: flex-end;
			}
			
			.main-content .item-actions svg {
				width: 15px;
				height: 15px;
				fill: currentColor;
			}
			
			.main-content .btn {
				padding: 8px 15px;
				border: none;
				border-radius: 5px;
				cursor: pointer;
				font-weight: 600;
				transition: all 0.3s;
				display: flex;
				align-items: center;
				gap: 5px;
			}
			
			.main-content .btn-edit {
				background-color: #4a6bff;
				color: white;
			}
			
			.main-content .btn-delete {
				background-color: #ff4757;
				color: white;
			}
			
			.main-content .btn-add {
				background-color: #2ed573;
				color: white;
				margin-top: 15px;
				width: 100%;
				justify-content: center;
				padding: 12px;
				font-size: 1rem;
			}
			
			.main-content .btn-add svg {
				width: 20px;
				height: 20px;
				fill: currentColor;
			}
			
			.main-content .btn:hover {
				opacity: 0.9;
				transform: translateY(-2px);
			}
			
			/* 表单样式 */
			.main-content .form-group {
				margin-bottom: 20px;
			}
			
			.main-content label {
				display: flex;
				align-items: center;
				gap: 10px;
				margin-bottom: 8px;
				color: #ccc;
				font-weight: 600;
			}
			
			.main-content label svg {
				width: 20px;
				height: 20px;
				fill: currentColor;
			}
			
			.main-content input, select {
				width: 100%;
				padding: 12px 15px;
				border-radius: 5px;
				border: 1px solid #555;
				background-color: #4a4a4a;
				color: #f0f0f0;
				font-size: 1rem;
			}
			
			input:focus, select:focus {
				outline: none;
				border-color: #6c8eff;
			}
			
			/* 去掉数字输入框的上下箭头 */
			.main-content input[type="number"]::-webkit-inner-spin-button,
			.main-content input[type="number"]::-webkit-outer-spin-button {
				-webkit-appearance: none;
				margin: 0;
			}
			
			.main-content .form-row {
				display: flex;
				gap: 15px;
			}
			
			.main-content .form-row .form-group {
				flex: 1;
			}
			
			/* 空状态样式 */
			.main-content .empty-state {
				display: flex;
				justify-content: center;
				align-items: center;
				color: #aaa;
				text-align: center;
				padding: 50px 0;
				height: calc(100% - 120px);
			}
			
			.main-content .empty-state svg {
				width: 150px;
				height: 150px;
				fill: currentColor;
			}
			
			/* 统计信息 */
			.stats {
				display: flex;
				justify-content: space-between;
				background-color: #3a3a3a;
				padding: 15px;
				border-radius: 8px;
				margin-bottom: 20px;
			}
			
			.stat-item {
				text-align: center;
			}
			
			.stat-value {
				font-size: 2rem;
				color: #6c8eff;
				font-weight: 700;
			}
			
			.stat-label {
				color: #aaa;
				font-size: 0.9rem;
			}
			
			/* 响应式设计 */
			@media (max-width: 1600px) {
				.main-content {
					flex-direction: column;
				}
				
				.items-list, .add-item-form {
					width: 100%;
				}
			}
			
			@media (max-width: 768px) {
				.form-row {
					flex-direction: column;
					gap: 0;
				}
			}
		</style>
	</head>
	<body>
		<div class="container">
			<includes-scrollbar><?php include('../includes/scrollbar.html') ?></includes-scrollbar>
			<includes-message><?php include('../includes/message.html') ?></includes-message>
			
			<header>
			</header>
			
			<div class="stats">
				<div class="stat-item">
					<div class="stat-value" id="total-items">0</div>
					<div class="stat-label">道具总数</div>
				</div>
				<div class="stat-item">
					<div class="stat-value" id="total-price">0</div>
					<div class="stat-label">总价格</div>
				</div>
				<div class="stat-item">
					<div class="stat-value" id="avg-price">0</div>
					<div class="stat-label">平均价格</div>
				</div>
			</div>
			
			<div class="main-content">
				<div class="panel items-list">
					<h2 class="panel-title">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
							<path d="M187.392 70.656q28.672 0 48.64 19.456t19.968 48.128l0 52.224q0 28.672-19.968 48.64t-48.64 19.968l-54.272 0q-27.648 0-47.616-19.968t-19.968-48.64l0-52.224q0-28.672 19.968-48.128t47.616-19.456l54.272 0zM889.856 70.656q27.648 0 47.616 19.456t19.968 48.128l0 52.224q0 28.672-19.968 48.64t-47.616 19.968l-437.248 0q-28.672 0-48.64-19.968t-19.968-48.64l0-52.224q0-28.672 19.968-48.128t48.64-19.456l437.248 0zM187.392 389.12q28.672 0 48.64 19.968t19.968 48.64l0 52.224q0 27.648-19.968 47.616t-48.64 19.968l-54.272 0q-27.648 0-47.616-19.968t-19.968-47.616l0-52.224q0-28.672 19.968-48.64t47.616-19.968l54.272 0zM889.856 389.12q27.648 0 47.616 19.968t19.968 48.64l0 52.224q0 27.648-19.968 47.616t-47.616 19.968l-437.248 0q-28.672 0-48.64-19.968t-19.968-47.616l0-52.224q0-28.672 19.968-48.64t48.64-19.968l437.248 0zM187.392 708.608q28.672 0 48.64 19.968t19.968 47.616l0 52.224q0 28.672-19.968 48.64t-48.64 19.968l-54.272 0q-27.648 0-47.616-19.968t-19.968-48.64l0-52.224q0-27.648 19.968-47.616t47.616-19.968l54.272 0zM889.856 708.608q27.648 0 47.616 19.968t19.968 47.616l0 52.224q0 28.672-19.968 48.64t-47.616 19.968l-437.248 0q-28.672 0-48.64-19.968t-19.968-48.64l0-52.224q0-27.648 19.968-47.616t48.64-19.968l437.248 0z"></path>
						</svg>
						<span>道具列表</span>
					</h2>
					<div class="table-container">
						<table id="items-table">
							<thead>
								<tr>
									<th>图标</th>
									<th>名字</th>
									<th>指令</th>
									<th>价格</th>
									<th>RCON</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody id="items-table-body">
								<!-- 道具数据将通过JavaScript动态添加 -->
							</tbody>
						</table>
					</div>
					
					<div id="empty-state" class="empty-state">
						<div>
							<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
								<path d="M839.811657 361.764571h-642.048L67.364571 596.406857v292.864h902.729143V596.406857L839.826286 361.764571zM633.4464 599.04c0 63.444114-51.317029 114.8928-114.702629 114.8928-63.400229 0-114.717257-51.448686-114.717257-114.907429H121.197714l104.448-199.738514H811.739429l104.448 199.738514H633.431771zM508.269714 121.270857h39.350857v141.824h-39.350857V121.270857z m-266.971428 70.407314l27.808914-27.882057 100.030171 100.278857-27.808914 27.896686-100.0448-100.293486z m433.342171 72.469943l100.030172-100.293485 27.823542 27.896685-100.030171 100.278857-27.823543-27.882057z"></path>
							</svg>
							<h3>暂无道具</h3>
							<p>在"添加/编辑道具"处添加第一个道具</p>
						</div>
					</div>
				</div>
				
				<div class="panel add-item-form">
					<h2 class="panel-title">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
							<path d="M512 1024C229.238154 1024 0 794.761846 0 512S229.238154 0 512 0s512 229.238154 512 512-229.238154 512-512 512z m236.307692-551.384615H551.384615V275.692308a39.384615 39.384615 0 1 0-78.76923 0v196.923077H275.692308a39.384615 39.384615 0 1 0 0 78.76923h196.923077v196.923077a39.384615 39.384615 0 1 0 78.76923 0V551.384615h196.923077a39.384615 39.384615 0 0 0 0-78.76923z"></path>
						</svg>
						<span>添加/编辑道具</span>
					</h2>
					<form action="/weiw/index.php?mods=mc_item_save" method="POST">
						<div class="form-group">
							<label for="item-name">
								<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path d="M278.024631 223.909066a39.213474 39.213474 0 0 0 39.213474 39.213473H707.281457a39.213474 39.213474 0 1 0 0-77.511966H316.715259a39.213474 39.213474 0 0 0-38.690628 38.298493zM278.024631 472.6532a39.213474 39.213474 0 0 0 39.213474 39.213474H707.281457a39.213474 39.213474 0 1 0 0-77.511966H316.715259a39.213474 39.213474 0 0 0-38.690628 38.298492z"></path>
									<path d="M931.713238 1023.994641a44.834072 44.834072 0 0 1-26.142316-8.365541L511.867646 731.200704 118.295082 1015.367677A44.70336 44.70336 0 0 1 47.187983 978.899146V44.964914A44.964783 44.964783 0 0 1 92.152766 0.000131h839.691184a44.834072 44.834072 0 0 1 44.964783 44.964783V979.029858a44.964783 44.964783 0 0 1-45.095495 44.964783zM511.867646 630.814211a46.141187 46.141187 0 0 1 26.142316 8.365541l348.738493 251.750501V89.929697H136.856126v801.26198l348.738493-251.750502a44.441937 44.441937 0 0 1 26.142316-8.626964z"></path>
								</svg>
								<span>道具名字</span>
							</label>
							<input type="text" name="name" id="item-name" placeholder="例如：钻石剑" required>
						</div>
						
						<div class="form-group">
							<label for="item-command">
								<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path d="M853.333333 0a170.666667 170.666667 0 0 1 170.666667 170.666667v682.666666a170.666667 170.666667 0 0 1-170.666667 170.666667H170.666667a170.666667 170.666667 0 0 1-170.666667-170.666667V170.666667a170.666667 170.666667 0 0 1 170.666667-170.666667h682.666666z m0 85.333333H170.666667a85.333333 85.333333 0 0 0-85.162667 78.933334L85.333333 170.666667v682.666666a85.333333 85.333333 0 0 0 78.933334 85.162667L170.666667 938.666667h682.666666a85.333333 85.333333 0 0 0 85.162667-78.933334L938.666667 853.333333V170.666667a85.333333 85.333333 0 0 0-78.933334-85.162667L853.333333 85.333333zM578.730667 266.752a42.666667 42.666667 0 0 1 28.501333 49.066667l-1.28 4.778666-126.464 384a42.666667 42.666667 0 0 1-82.346667-21.845333l1.194667-4.778667 126.549333-384a42.666667 42.666667 0 0 1 53.845334-27.221333z m-244.906667 47.189333a42.666667 42.666667 0 0 1 11.52 55.210667l-2.986667 4.522667-102.997333 137.386666 103.082667 137.386667a42.666667 42.666667 0 0 1-4.522667 56.32l-4.010667 3.413333a42.666667 42.666667 0 0 1-56.32-4.437333l-3.413333-4.096-122.282667-162.986667a42.666667 42.666667 0 0 1-3.072-46.506666l3.072-4.693334 122.197334-162.986666a42.666667 42.666667 0 0 1 59.733333-8.533334z m356.352 0a42.666667 42.666667 0 0 1 56.234667 4.437334l3.498666 4.096 122.197334 162.986666 3.157333 4.608a42.666667 42.666667 0 0 1 0 41.813334l-3.157333 4.778666-122.197334 162.986667-3.498666 4.096a42.666667 42.666667 0 0 1-51.797334 7.424l-4.437333-2.986667-4.096-3.413333a42.666667 42.666667 0 0 1-7.424-51.797333l2.986667-4.522667 102.997333-137.386667-102.997333-137.386666-2.986667-4.522667a42.666667 42.666667 0 0 1 11.52-55.210667z"></path>
								</svg>
								<span>指令</span>
							</label>
							<input type="text" name="command" id="item-command" placeholder="例如：give {name} diamond_sword" required>
						</div>
						
						<div class="form-row">
							<div class="form-group">
								<label for="item-price">
									<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
										<path d="M419.868545 371.201505c119.957888 0 244.638514-26.377915 319.492222-76.610347v91.550631h69.357129V185.603409C808.719666 65.05053 608.372533 0 419.868545 0S31.031591 65.05053 31.031591 185.610492v547.081422c0 120.552879 200.341821 185.598096 388.844038 185.598097v-69.351816c-197.949463 0-319.486909-67.708509-319.48691-116.248051V568.145151c74.860791 50.225349 199.534334 76.610347 319.48691 76.610346v-69.357128c-197.949463 0-319.486909-67.708509-319.48691-116.253364v-164.546763c74.848396 50.225349 199.516626 76.603264 319.479826 76.603263z m0-301.85146c197.956546 0 319.492222 67.715592 319.492222 116.253364 0 48.541313-121.535675 116.249822-319.492222 116.249822-197.94415 0-319.486909-67.708509-319.486909-116.249822 0.001771-48.539542 121.54453-116.253363 319.486909-116.253364zM730.699759 409.109133c-172.180705 0-262.272192 66.244053-262.272193 131.668223v351.557963c0 65.425941 90.091487 131.662911 262.272193 131.66291 170.888017 0 260.866173-65.254173 262.197818-130.203767h0.069061V540.770273c-0.005312-65.42417-90.084404-131.66114-262.266879-131.66114z m0 69.357128c127.276626 0 192.909751 43.669828 192.909751 62.311095 0 18.643037-65.633125 62.319949-192.909751 62.319948-127.287251 0-192.920376-43.67514-192.920376-62.319948 0-18.641267 65.645521-62.311095 192.920376-62.311095z m0 476.162444c-127.287251 0-192.920376-43.67514-192.920376-62.311094v-83.922002c44.011593 23.897017 108.59286 39.807702 192.920376 39.807702 84.322204 0 148.905241-15.915997 192.909751-39.807702v83.922002c0 18.635954-65.633125 62.311095-192.909751 62.311094z m0-175.77544c-127.287251 0-192.920376-43.669828-192.920376-62.305782V632.620169c44.011593 23.898787 108.59286 39.814785 192.920376 39.814785 84.322204 0 148.905241-15.903602 192.909751-39.802389v83.927314c0 18.623559-65.633125 62.298699-192.909751 62.298699v-0.005313z m0 0"></path>
									</svg>
									<span>价格</span>
								</label>
								<input type="number" name="price" value="100" id="item-price" placeholder="例如：100" min="1" required>
							</div>
							
							<div class="form-group">
								<label for="item-icon">
									<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
										<path d="M884.18750029 107.93750029c-13.12499971-5.625-27.18749971-8.4375-41.25000058-8.4375H181.06250029c-15.00000029 0-29.06250029 2.8125-42.1875 7.49999971C93.87500029 124.81250029 62 167.00000029 62 217.62500029V807.3125c0 50.625 31.87500029 92.8125 77.81249971 109.6875 13.12499971 4.68749971 27.18749971 7.49999971 42.1875 7.49999971h660.9375c65.62500029 0 119.06250029-53.4375 119.06250029-119.06249942V217.62500029c0-50.625-31.87500029-92.8125-77.81249971-109.6875zM422 364.81249971c0 48.75000029-40.31250029 88.12500029-90 88.12500029s-90-39.375-90-88.12500029 40.31250029-88.12500029 90-88.12499942 90 39.375 90 88.12499942z m420.93749971 499.68750058H181.06250029c-28.125 0-52.49999971-19.6875-58.12500058-46.87500058-0.93750029-3.75000029-0.93750029-7.49999971-0.93749942-11.25v-45l177.1875-149.99999942 63.74999971 60.93749971c32.81249971 31.87500029 85.31250029 33.75 120.9375 4.68749971l299.06250029-247.5c57.18750029 61.875 96.56250029 103.12499971 120.9375 124.68750029v251.25000029c-1.87499971 32.81249971-28.125 59.0625-60.93750058 59.0625z"></path>
									</svg>
									<span>图标路径</span>
								</label>
								<input type="text" name="icon" value="/images/000.svg" id="item-icon" placeholder="例如：/images/000.svg" required>
							</div>
						</div>
						
						<div class="form-row">
							<div class="form-group">
								<label for="rcon-address">
									<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
										<path d="M938.666667 51.2H85.333333c-17.066667 0-34.133333 17.066667-34.133333 34.133333v341.333334c0 17.066667 12.8 34.133333 34.133333 34.133333h853.333334c17.066667 0 34.133333-12.8 34.133333-34.133333V85.333333c0-17.066667-17.066667-34.133333-34.133333-34.133333z m-34.133334 341.333333H119.466667V119.466667h789.333333v273.066666zM938.666667 563.2H85.333333c-17.066667 0-34.133333 12.8-34.133333 34.133333v341.333334c0 17.066667 12.8 34.133333 34.133333 34.133333h853.333334c17.066667 0 34.133333-12.8 34.133333-34.133333v-341.333334c0-17.066667-17.066667-34.133333-34.133333-34.133333z m-34.133334 341.333333H119.466667v-277.333333h789.333333v277.333333zM234.666667 298.666667h42.666666c12.8 0 21.333333-8.533333 21.333334-21.333334v-42.666666c0-12.8-8.533333-21.333333-21.333334-21.333334h-42.666666c-12.8 0-21.333333 8.533333-21.333334 21.333334v42.666666c0 12.8 8.533333 21.333333 21.333334 21.333334zM234.666667 810.666667h42.666666c12.8 0 21.333333-8.533333 21.333334-21.333334v-42.666666c0-12.8-8.533333-21.333333-21.333334-21.333334h-42.666666c-12.8 0-21.333333 8.533333-21.333334 21.333334v42.666666c0 12.8 8.533333 21.333333 21.333334 21.333334zM405.333333 298.666667h42.666667c12.8 0 21.333333-8.533333 21.333333-21.333334v-42.666666c0-12.8-8.533333-21.333333-21.333333-21.333334h-42.666667c-12.8 0-21.333333 8.533333-21.333333 21.333334v42.666666c0 12.8 8.533333 21.333333 21.333333 21.333334zM405.333333 810.666667h42.666667c12.8 0 21.333333-8.533333 21.333333-21.333334v-42.666666c0-12.8-8.533333-21.333333-21.333333-21.333334h-42.666667c-12.8 0-21.333333 8.533333-21.333333 21.333334v42.666666c0 12.8 8.533333 21.333333 21.333333 21.333334z"></path>
									</svg>
									<span>RCON地址</span>
								</label>
								<input type="text" name="rconAddress" value="127.0.0.1" id="rcon-address" placeholder="例如：127.0.0.1" required>
							</div>
							
							<div class="form-group">
								<label for="rcon-port">
									<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
										<path d="M362.24 64a42.666667 42.666667 0 0 1 42.666667 42.666667v74.453333a42.666667 42.666667 0 1 1-85.333334 0V106.666667a42.666667 42.666667 0 0 1 42.666667-42.666667z m297.898667 0a42.666667 42.666667 0 0 1 42.666666 42.666667v74.453333a42.666667 42.666667 0 0 1-85.333333 0V106.666667a42.666667 42.666667 0 0 1 42.666667-42.666667zM170.666667 354.901333a42.666667 42.666667 0 0 1 42.666666-42.666666h595.797334a42.666667 42.666667 0 1 1 0 85.333333h-31.786667v155.946667a241.28 241.28 0 0 1-223.445333 240.597333V925.866667a42.666667 42.666667 0 1 1-85.333334 0v-131.754667a241.28 241.28 0 0 1-223.402666-240.64V397.610667h-31.829334a42.666667 42.666667 0 0 1-42.666666-42.666667z m159.829333 42.666667v155.946667a155.946667 155.946667 0 0 0 155.904 155.904h49.664a155.946667 155.946667 0 0 0 155.946667-155.904V397.568H330.453333z"></path>
									</svg>
									<span>RCON端口</span>
								</label>
								<input type="number" name="rconPort" value="25575" id="rcon-port" placeholder="例如：25575" required>
							</div>
						</div>
						
						<div class="form-group">
							<label for="rcon-password">
								<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path d="M655.54431073 120.1012469c-138.4177282 0-251.20254378 112.78481557-251.20254378 251.20254378 0 16.51898815 1.70886084 33.03797627 5.12658253 49.55696442l2.27848111 11.96202589-295.06330537 295.06330538v176.58228702h206.20254159v-102.53165053h96.26582744V705.67089542h95.12658687v-96.8354477h32.468356v-9.1139245l29.6202546 9.68354477c25.06329235 8.54430421 51.83544554 12.53164617 78.03797845 12.53164617 138.4177282 0 251.20254378-112.78481557 251.20254377-251.20254377 1.13924057-137.84810792-111.64557501-250.6329235-250.06330321-250.63292349z m93.98734631 210.18988357c0 29.05063432-23.92405179 52.9746861-52.97468611 52.97468611s-52.9746861-23.92405179-52.9746861-52.97468611 23.92405179-52.9746861 52.9746861-52.9746861 52.9746861 23.35443151 52.97468611 52.9746861z"></path>
								</svg>
								<span>RCON密码</span>
							</label>
							<input type="password" name="rconPassword" id="rcon-password" placeholder="请输入RCON密码" required>
						</div>
						
						<div class="form-group">
							<button type="submit" class="btn btn-add">
								<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path d="M766.138182 0H93.090909a93.090909 93.090909 0 0 0-93.090909 93.090909v837.818182a93.090909 93.090909 0 0 0 93.090909 93.090909h837.818182a93.090909 93.090909 0 0 0 93.090909-93.090909V186.181818z m-139.636364 884.363636a139.636364 139.636364 0 1 1 139.636364-139.636363 139.636364 139.636364 0 0 1-137.774546 139.636363z m139.636364-535.272727a46.545455 46.545455 0 0 1-46.545455 46.545455H209.454545a46.545455 46.545455 0 0 1-46.545454-46.545455v-139.636364a46.545455 46.545455 0 0 1 46.545454-46.545454h512a46.545455 46.545455 0 0 1 46.545455 46.545454z"></path>
								</svg>
								<span>保存</span>
							</button>
							<button type="button" id="cancel-edit" class="btn" style="background-color: #555; color: white; margin-top: 10px; display: none;">
								取消编辑
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<div-modal>
			<style>
				/* 确认窗口样式 */
				.confirm-overlay {
					position: fixed;
					top: 0;
					left: 0;
					right: 0;
					bottom: 0;
					background: rgba(0, 0, 0, 0.3);
					backdrop-filter: blur(3px);
					display: flex;
					justify-content: center;
					align-items: center;
					z-index: 99;
					user-select: none;
					opacity: 0;
					visibility: hidden;
					transition: all 0.3s ease;
				}
				
				.confirm-overlay.active {
					opacity: 1;
					visibility: visible;
				}
				
				.confirm-dialog {
					background: #3a3a3a;
					width: 90%;
					max-width: 500px;
					border-radius: 16px;
					overflow: hidden;
					box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
					transform: scale(0.9);
					transition: transform 0.3s ease;
				}
				
				.confirm-overlay.active .confirm-dialog {
					transform: scale(1);
				}
				
				.confirm-header {
					background: #ff5252;
					color: white;
					padding: 25px 30px;
					display: flex;
					align-items: center;
				}
				
				.confirm-header h3 {
					font-size: 1.8rem;
				}
				
				.confirm-body {
					padding: 30px;
				}
				
				.confirm-message {
					font-size: 1.2rem;
					line-height: 1.6;
					margin-bottom: 25px;
					color: #e0e0e0;
				}
				
				.confirm-overlay .item-preview {
					display: flex;
					align-items: center;
					background: #444;
					padding: 15px;
					border-radius: 10px;
					margin-bottom: 30px;
				}
				
				.confirm-overlay .item-preview svg {
					margin-right: 10px;
					width: 30px;
					height: 30px;
					fill: currentColor;
				}
				
				.confirm-overlay .confirm-actions {
					display: flex;
					justify-content: flex-end;
					gap: 15px;
				}
				
				.confirm-overlay .btn {
					padding: 14px 28px;
					border: none;
					border-radius: 8px;
					font-weight: 600;
					font-size: 1.1rem;
					cursor: pointer;
					transition: all 0.3s;
				}
				
				.confirm-overlay .btn-cancel {
					background: #666;
					color: #f0f0f0;
				}
				
				.confirm-overlay .btn-cancel:hover {
					background: #777;
					transform: translateY(-2px);
				}
				
				.confirm-overlay .btn-delete {
					display: flex;
					align-items: center;
					gap: 5px;
					background: #ff5252;
					color: white;
				}
				
				.confirm-overlay .btn-delete svg {
					width: 20px;
					height: 20px;
					fill: currentColor;
				}
				
				.confirm-overlay .btn-delete:hover {
					background: #ff6b6b;
					transform: translateY(-2px);
					box-shadow: 0 5px 15px rgba(255, 82, 82, 0.3);
				}
			</style>
			<div class="confirm-overlay">
				<div class="confirm-dialog">
					<div class="confirm-header">
						<h3>删除道具</h3>
					</div>
					<div class="confirm-body">
						<div class="item-preview">
							<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
								<path d="M544 560v377c0 4.4-3.6 8-8 8h-48c-4.4 0-8-3.6-8-8V560H64v385c0 35.3 28.7 64 64 64h768c35.4 0 64-28.7 64-64V560H544zM896 209h-42c-6.4 0-10.2-7.2-6.6-12.5 15.6-23.2 23.2-48.7 21.6-74-1.9-30.2-17.1-56.4-43.8-75.8-19.2-13.9-44.7-24-71.7-28.6-49-8.2-100.9 5.7-146.3 39.3-24.4 18.1-46.6 41.2-66.4 69.2-12.7 17.9-39.4 17.9-52.1 0-19.8-28-42-51.2-66.4-69.2C377 23.8 325.1 9.8 276.1 18.1c-27 4.6-52.5 14.7-71.7 28.6-26.7 19.3-41.9 45.5-43.8 75.8-1.6 25.3 5.9 50.8 21.6 74 3.6 5.3-0.1 12.5-6.6 12.5H128C57.3 209 0 266.3 0 337v128c0 14.9 10.2 27.5 24 31h976c13.8-3.5 24-16.1 24-31V337c0-70.7-57.3-128-128-128z m-323.9-11.9c53.2-96.5 120.6-124.4 170.7-115.9 6.1 1 60 11.1 62.3 45.4 1.9 29.9-31.1 69.5-88 82.4h-138c-6.1 0-9.9-6.5-7-11.9z m-347.7-70.5c2.2-34.3 56.1-44.3 62.3-45.4 50.2-8.4 117.6 19.4 170.7 115.9 3 5.3-0.9 11.9-7 11.9h-138c-56.8-13-89.9-52.5-88-82.4z"></path>
							</svg>
							<div class="item-info">
								<div class="item-name"><strong id="item-to-delete">未知道具</strong></div>
							</div>
						</div>
						
						<div class="confirm-message">
							您确定要删除这个道具吗？此操作将永久移除该道具，并且无法恢复。
						</div>
						
						<div class="confirm-actions">
							<button class="btn btn-cancel" onclick="closeDeleteItem()">
								<span>取消</span>
							</button>
							<button class="btn btn-delete" id="btn-delete">
								<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
									<path d="M836.6 193.8h100.2c18.8 0 33.9-16.2 33.9-36.3s-15.1-35.2-33.9-35.2H724.9V85.9C724.9 40 690 2 646.6 2H377.9c-42.8 0-78.3 37.5-78.3 83.9v36.3H87.2c-18.8 0-33.9 16.2-33.9 36.3s15.1 36.3 33.9 36.3h100.2l649.2-1zM804.6 253.7l-585.2 1c-20.5 0-37.2 17.6-37.2 39.2V890c0 72.6 56.3 132 125.1 132h409.4c68.8 0 125.1-59.4 125.1-132V293c0-21.7-16.7-39.3-37.2-39.3z"></path>
								</svg>
								<span>确认删除</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div-modal>
		
		
		<script src="../js/Sortable.min.js"></script>
		<script src="../js/main.js"></script>
		<script>
			const items = {json: var.mc_item_list};

			// 页面加载时初始化
			document.addEventListener('DOMContentLoaded', function() {
				renderItemsTable();
				updateStats();
			});

			// 渲染道具表格
			function renderItemsTable() {
				const tableBody = document.getElementById('items-table-body');
				const emptyState = document.getElementById('empty-state');
				
				// 清空表格
				tableBody.innerHTML = '';
				
				if (items.length === 0) {
					emptyState.style.display = 'flex';
					return;
				}
				
				emptyState.style.display = 'none';
				
				// 添加道具行
				items.forEach((item, index) => {
					const html = `
						<tr id="${item.name}">
							<td><img src="${item.icon}" alt="${item.name}" class="item-icon"></td>
							<td>${item.name}</td>
							<td>${item.command}</td>
							<td>${item.price}</td>
							<td>${item.rconAddress}:${item.rconPort}</td>
							<td>
								<div class="item-actions">
									<button class="btn btn-edit" onclick="editItem(${index})">
										<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
											<path d="M847.104 465.5616c-32.512 0-60.928 28.416-60.928 60.928v353.1776H144.384V238.1824h337.152c32.512 0 56.832-28.416 56.832-60.8768s-24.32-60.928-56.832-60.928H83.456c-32.4608 0-60.928 28.4672-60.928 60.928V940.544c0 32.512 28.4672 60.928 60.928 60.928h763.648c16.2304 0 32.512-8.1408 44.6976-16.2304 12.1856-8.1408 16.2304-28.416 16.2304-44.6976v-414.1056c0-32.4608-28.416-60.928-60.928-60.928z m-476.9792 60.1088c-9.3184 0-14.0288 4.7104-18.688 9.472-4.608 4.7104-4.608 9.4208-4.608 9.4208L295.424 695.5008c-4.6592 9.4208 0 18.8928 9.3184 28.3136 9.3184 4.7104 18.688 9.4208 28.0064 4.7104l149.2992-51.8656c4.6592 0 4.6592-4.7616 9.3184-4.7616 9.3696-9.4208 9.3696-28.2624 0-37.7344l-97.9968-99.0208c-9.3184-4.7616-13.9776-9.472-23.296-9.472z m626.8416-421.4784L926.976 32.7168c-14.0288-14.2848-28.0064-19.0464-41.984-19.0464-14.0288 0-28.0064 4.7616-37.376 14.336l-41.984 42.8544 144.64 147.6096 41.984-42.8544a48.64 48.64 0 0 0 4.7104-71.424z m-400.0768 472.6784l295.424-295.3728c3.8912 0 3.8912-3.9424 7.8336-7.8848l7.8848-7.8848-149.6576-149.6576-311.1424 311.1424-51.2 51.2 149.6576 149.6576 51.2-51.2z"></path>
										</svg>
										<span>编辑</span>
									</button>
									<button class="btn btn-delete" onclick="deleteItem(${index})">
										<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
											<path d="M127.999978 928.000034a95.999966 95.999966 0 0 0 95.999966 95.999966h575.999797a95.999966 95.999966 0 0 0 95.999967-95.999966V256.00027H127.999978z m543.999808-511.99982a31.999989 31.999989 0 0 1 63.999978 0v447.999842a31.999989 31.999989 0 0 1-63.999978 0z m-191.999932 0a31.999989 31.999989 0 0 1 63.999977 0v447.999842a31.999989 31.999989 0 0 1-63.999977 0z m-191.999933 0a31.999989 31.999989 0 0 1 63.999978 0v447.999842a31.999989 31.999989 0 0 1-63.999978 0zM927.999696 64.000337H687.999781l-18.799994-37.399986A47.999983 47.999983 0 0 0 626.199802 0.00036H397.599883a47.439983 47.439983 0 0 0-42.799985 26.599991L335.999904 64.000337H95.999989A31.999989 31.999989 0 0 0 64 96.000326v63.999978a31.999989 31.999989 0 0 0 31.999989 31.999988h831.999707a31.999989 31.999989 0 0 0 31.999989-31.999988V96.000326a31.999989 31.999989 0 0 0-31.999989-31.999989z"></path>
										</svg>
										<span>删除</span>
									</button>
								</div>
							</td>
						</tr>
					`;
					
					// 将行添加到表格
					tableBody.insertAdjacentHTML('beforeend', html);
				});
			}
			
			
			// 重置表单
			function resetForm() {
				document.querySelector('form').reset();
				document.getElementById('cancel-edit').style.display = 'none';
			}
			
			// 更新统计信息
			function updateStats() {
				const totalItems = items.length;
				const totalPrice = items.reduce((sum, item) => sum + Number(item.price), 0);
				const avgPrice = totalItems > 0 ? totalPrice / totalItems : 0;
				
				document.getElementById('total-items').textContent = totalItems;
				document.getElementById('total-price').textContent = totalPrice;
				document.getElementById('avg-price').textContent = avgPrice;
			}
			
			handleFormSubmit("form", (fetch) => {
				fetch.then((data) => {
					if (data.error) {
						showMessage(data.error);
					} else {
						location.reload();
					}
				});
			});
			
			// 编辑道具
			function editItem(index)
			{
				const item = items[index];
				
				// 填充表单
				document.getElementById('item-name').value     = item.name;
				document.getElementById('item-command').value  = item.command;
				document.getElementById('item-price').value    = item.price;
				document.getElementById('item-icon').value     = item.icon;
				document.getElementById('rcon-address').value  = item.rconAddress;
				document.getElementById('rcon-port').value     = item.rconPort;
				document.getElementById('rcon-password').value = item.rconPassword;
				
				// 显示取消编辑按钮
				document.getElementById('cancel-edit').style.display = 'block';
				document.getElementById('cancel-edit').onclick = resetForm;
				
				// 滚动到表单
				document.querySelector('.add-item-form').scrollIntoView({ behavior: 'smooth' });
			}
			
			// 确认删除函数
			function deleteItem(index)
			{
				document.getElementById('item-to-delete').textContent = items[index].name;
				document.getElementById('btn-delete').onclick = function(){
					fetch(`/weiw/index.php?mods=mc_item_delete&name=${items[index].name}`)
						.then(data => data.json())
						.then(data => {
							if (data.error) {
								showMessage(data.error);
								return;
							}
							
							location.reload();
							console.log(data);
						});
						
					closeDeleteItem();
				};
				
				
				// 显示对话框
				document.querySelector('.confirm-overlay').classList.add('active');
				document.body.style.overflow = 'hidden';
			}
			
			// 关闭确认对话框
			function closeDeleteItem() {
				document.querySelector('.confirm-overlay').classList.remove('active');
				document.body.style.overflow = 'auto';
			}
			
			// 拖动排序
			const container = document.querySelector('tbody');
			new Sortable(container, {
				animation: 150,
				handle: 'td',
				onUpdate: function(e) {
					fetch(`/weiw/index.php?mods=mc_item_reorder&id=${e.item.id}&newIndex=${e.newIndex}`);
				}
			});
		</script>
	</body>
</html>