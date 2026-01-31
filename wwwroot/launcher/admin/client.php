<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_verify_access');
	$MKH ->mods('mc_client');

	if ($_SERVER['PATH_INFO'] === '/forge') {
		die(file_get_contents("https://files.minecraftforge.net/net/minecraftforge/forge/maven-metadata.json"));
	}
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>新建客户端</title>
		<style>
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
				font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			}
			
			body {
				background-color: #2e2e2e;
				color: #e0e0e0;
				line-height: 1.6;
				padding: 0 20px;
				min-height: 100vh;
			}
			
			header {
				border-radius: 12px;
				background: linear-gradient(135deg, #6a994e 0%, #386641 100%);
				margin-bottom: 20px;
				padding: 24px 32px;
				display: flex;
				align-items: center;
				gap: 20px;
			}
			
			.logo {
				display: flex;
				align-items: center;
				justify-content: center;
				width: 60px;
				height: 60px;
				background-color: rgba(255, 255, 255, 0.1);
				border-radius: 12px;
				padding: 10px;
			}
			
			.logo svg {
				width: 40px;
				height: 40px;
			}
			
			h1 {
				font-size: 2.2rem;
				font-weight: 700;
				color: white;
			}
			
			.main-content {
				display: grid;
				grid-template-columns: 1fr 1fr;
				gap: 30px;
			}
			
			.again {
				display: flex;
				flex-direction: column; /* 垂直排列 */
				gap: 20px; /* 子元素之间的间距 */
			}
			
			@media (max-width: 1200px) {
				.main-content {
					grid-template-columns: 1fr;
				}
			}
			
			.form-section {
				background-color: #444444;
				border-radius: 10px;
				padding: 24px;
				box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
			}
			
			.section-title {
				font-size: 1.4rem;
				margin-bottom: 20px;
				padding-bottom: 10px;
				border-bottom: 2px solid #6a994e;
				color: #fff;
				display: flex;
				align-items: center;
				gap: 10px;
			}
			
			.section-title svg {
				width: 25px;
				height: 25px;
				fill: #6a994e;
			}
			
			.form-group {
				margin-bottom: 22px;
			}
			
			label {
				display: block;
				margin-bottom: 8px;
				font-weight: 600;
				color: #c9c9c9;
			}
			
			input, textarea {
				width: 100%;
				padding: 10px 14px;
				background-color: #555;
				border: 1px solid #666;
				border-radius: 5px;
				color: #fff;
				resize: vertical;
				font-size: 1rem;
				transition: all 0.3s;
			}
			
			input:focus, textarea:focus {
				outline: none;
				border-color: #6a994e;
				box-shadow: 0 0 0 3px rgba(106, 153, 78, 0.2);
			}
			
			.loader-selector {
				display: flex;
				gap: 15px;
				flex-wrap: wrap;
				margin-bottom: 10px;
				user-select: none;
			}
			
			.loader-option {
				flex: 1;
				min-width: 120px;
			}
			
			.loader-option label {
				display: flex;
				flex-direction: column;
				align-items: center;
				justify-content: center;
				background-color: #2a5caa;
				padding: 15px;
				border-radius: 8px;
				cursor: pointer;
				transition: all 0.3s;
				text-align: center;
				height: 100%;
			}
			
			.loader-option label:hover {
				transform: translateY(-5px);
			}
			
			.loader-option label:active {
				transform: translateY(5px);
			}
			
			.loader-option img {
				width: 30px;
				height: 30px;
				margin-bottom: 8px;
			}
			
			.loader-option svg {
				width: 30px;
				height: 30px;
				fill: #c9c9c9;
				margin-bottom: 8px;
			}
			
			.weight-input {
				max-width: 300px;
			}
			
			.form-actions {
				grid-column: 1 / -1;
				display: flex;
				justify-content: flex-end;
				gap: 20px;
				margin-top: 20px;
				padding-top: 20px;
				border-top: 1px solid #555;
			}
			
			.btn {
				padding: 14px 30px;
				border-radius: 8px;
				font-weight: 600;
				font-size: 1rem;
				cursor: pointer;
				transition: all 0.2s;
				border: none;
			}
			
			.btn-primary {
				background-color: #6a994e;
				color: white;
			}
			
			.btn-primary:hover {
				background-color: #58803e;
				transform: translateY(-2px);
			}
			
			.btn-secondary {
				background-color: #666;
				color: white;
			}
			
			.btn-secondary:hover {
				background-color: #777;
			}
			
			.info-text {
				font-size: 0.9rem;
				color: #aaa;
				margin-top: 5px;
			}
			
			.list {
				background-color: #555;
				border: 1px solid #666;
				border-radius: 5px;
				margin-top: 5px;
				padding: 10px;
			}

			.list.hidden {
				display: none;
			}

			.list .scrollbar {
				max-height: 300px;
				overflow-y: auto;
				scrollbar-width: thin;
				scrollbar-color: #4CAF50 #4B4B4B;
			}

			.list .scrollbar center {
				display: flex;
				justify-content: center;
				align-items: center;
				color: #fff;
				height: 100%;
				font-size: 25px;
			}

			.list .scrollbar div {
				line-height: 25px;
				padding: 0 10px;
				cursor: pointer;
				transition: all 0.3s ease;
			}

			.list .scrollbar div:hover {
				background-color: #2a5caa;
			}
			
			
			.loader {
				position: relative;
				width: 85px;
				height: 50px;
				background-repeat: no-repeat;
				background-image: linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0),
								  linear-gradient(#FFF 50px, transparent 0);
				background-position: 0px center, 15px center, 30px center, 45px center, 60px center, 75px center, 90px center;
				animation: rikSpikeRoll 0.65s linear infinite alternate;
			}
			
			@keyframes rikSpikeRoll {
			  0% { background-size: 10px 3px;}
			  16% { background-size: 10px 50px, 10px 3px, 10px 3px, 10px 3px, 10px 3px, 10px 3px}
			  33% { background-size: 10px 30px, 10px 50px, 10px 3px, 10px 3px, 10px 3px, 10px 3px}
			  50% { background-size: 10px 10px, 10px 30px, 10px 50px, 10px 3px, 10px 3px, 10px 3px}
			  66% { background-size: 10px 3px, 10px 10px, 10px 30px, 10px 50px, 10px 3px, 10px 3px}
			  83% { background-size: 10px 3px, 10px 3px,  10px 10px, 10px 30px, 10px 50px, 10px 3px}
			  100% { background-size: 10px 3px, 10px 3px, 10px 3px,  10px 10px, 10px 30px, 10px 50px}
			}
		</style>
	</head>
	<body>
		<includes-scrollbar><?php include('../includes/scrollbar.html') ?></includes-scrollbar>
		<includes-message><?php include('../includes/message.html') ?></includes-message>
		
		<form class="main-content" action="/weiw/index.php?mods=mc_client_save" method="POST">
			<div class="again">
				<div class="form-section">
					<h2 class="section-title">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M1016.832 606.208q2.048 12.288-1.024 29.696t-10.24 35.328-17.408 32.256-22.528 20.48-21.504 6.144-20.48-4.096q-10.24-3.072-25.6-5.632t-31.232-1.024-31.744 6.656-27.136 17.408q-24.576 25.6-28.672 58.368t9.216 62.464q10.24 20.48-3.072 40.96-6.144 8.192-19.456 16.896t-29.184 15.872-33.28 11.264-30.72 4.096q-9.216 0-17.408-7.168t-11.264-15.36l-1.024 0q-11.264-31.744-38.4-54.784t-62.976-23.04q-34.816 0-62.976 23.04t-39.424 53.76q-5.12 12.288-15.36 17.92t-22.528 5.632q-14.336 0-32.256-5.12t-35.84-12.8-32.256-17.92-21.504-20.48q-5.12-7.168-5.632-16.896t7.68-27.136q11.264-23.552 8.704-53.76t-26.112-55.808q-14.336-15.36-34.816-19.968t-38.912-3.584q-21.504 1.024-44.032 8.192-14.336 4.096-28.672-2.048-11.264-4.096-20.992-18.944t-17.408-32.768-11.776-36.864-2.048-31.232q3.072-22.528 20.48-28.672 30.72-12.288 55.296-40.448t24.576-62.976q0-35.84-24.576-62.464t-55.296-38.912q-9.216-3.072-15.36-14.848t-6.144-24.064q0-13.312 4.096-29.696t10.752-31.744 15.36-28.16 18.944-18.944q8.192-5.12 15.872-4.096t16.896 4.096q30.72 12.288 64 7.68t58.88-29.184q12.288-12.288 17.92-30.208t7.168-35.328 0-31.744-2.56-20.48q-2.048-6.144-3.584-14.336t1.536-14.336q6.144-14.336 22.016-25.088t34.304-17.92 35.84-10.752 27.648-3.584q13.312 0 20.992 8.704t10.752 17.92q11.264 27.648 36.864 48.64t60.416 20.992q35.84 0 63.488-19.968t38.912-50.688q4.096-8.192 12.8-16.896t17.92-8.704q14.336 0 31.232 4.096t33.28 11.264 30.208 18.432 22.016 24.576q5.12 8.192 3.072 17.92t-4.096 13.824q-13.312 29.696-8.192 62.464t29.696 57.344 60.416 27.136 66.56-11.776q8.192-5.12 19.968-4.096t19.968 9.216q15.36 14.336 27.136 43.52t15.872 58.88q2.048 17.408-5.632 27.136t-15.872 12.8q-31.744 11.264-54.272 39.424t-22.528 64q0 34.816 18.944 60.928t49.664 37.376q7.168 4.096 12.288 8.192 11.264 9.216 15.36 23.552zM540.672 698.368q46.08 0 87.04-17.408t71.168-48.128 47.616-71.168 17.408-86.528-17.408-86.528-47.616-70.656-71.168-47.616-87.04-17.408-86.528 17.408-70.656 47.616-47.616 70.656-17.408 86.528 17.408 86.528 47.616 71.168 70.656 48.128 86.528 17.408z"></path></svg>
						<span>基本配置</span>
					</h2>
					
					<div class="form-group">
						<label for="name">名称</label>
						<input type="text" name="name" id="name" required placeholder="例如：纯净">
					</div>
					
					<div class="form-group">
						<label for="version">版本</label>
						<input type="text" name="version" id="version" required placeholder="例如：1.7.10">
						<div class="list hidden" id="versions-list">
							<div class="scrollbar" id="versions"></div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="weight">权重值</label>
						<input type="number" name="weight" id="weight" class="weight-input">
						<div class="info-text">数字越大越靠前</div>
					</div>
					
					<div class="form-group">
						<label for="server">服务器地址</label>
						<textarea name="server" id="server" rows="5" placeholder="在此输入服务器地址，每行一个地址"></textarea>
						<div class="info-text">每行一个地址</div>
					</div>
				</div>
				
				<div class="form-section">
					<h2 class="section-title">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M891.072 580.928h-68.928a68.928 68.928 0 1 1-137.856 0H132.928a68.928 68.928 0 1 1 0-137.856h551.36a68.928 68.928 0 1 1 137.856 0h68.928a68.928 68.928 0 1 1 0 137.856z m0-310.144H339.712a68.928 68.928 0 1 1-137.856 0H132.928a68.928 68.928 0 1 1 0-137.856h68.928a68.928 68.928 0 1 1 137.856 0h551.36a68.928 68.928 0 1 1 0 137.856zM132.928 753.216h68.928a68.928 68.928 0 1 1 137.856 0h551.36a68.928 68.928 0 1 1 0 137.856H339.712a68.928 68.928 0 1 1-137.856 0H132.928a68.928 68.928 0 1 1 0-137.856z"></path></svg>
						<span>高级参数</span>
					</h2>
					
					<div class="form-group">
						<label for="game">游戏参数</label>
						<textarea name="game" id="game" rows="5" placeholder="在此输入游戏参数，每行一个参数"></textarea>
						<div class="info-text">每行一个游戏启动参数</div>
					</div>
					
					<div class="form-group">
						<label for="jvm">虚拟机参数 (JVM)</label>
						<textarea name="jvm" id="jvm" rows="15" placeholder="在此输入JVM参数，每行一个参数"></textarea>
						<div class="info-text">每行一个JVM参数，用于调整Java虚拟机设置</div>
					</div>
				</div>
			</div>
			
			<div class="again">
				<div class="form-section">
					<h2 class="section-title">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M699.733333 443.733333c22.755556 5.688889 45.511111 11.377778 68.266667 11.377778C876.088889 455.111111 967.111111 364.088889 967.111111 256c0-28.444444-5.688889-56.888889-22.755555-85.333333-5.688889-5.688889-11.377778-11.377778-22.755556-17.066667-11.377778 0-17.066667 0-22.755556 5.688889l-91.022222 91.022222-39.822222-39.822222 91.022222-91.022222c5.688889-5.688889 11.377778-17.066667 5.688889-22.755556s0-17.066667-11.377778-17.066667c-28.444444-17.066667-56.888889-22.755556-85.333333-22.755555C659.911111 56.888889 568.888889 147.911111 568.888889 256c0 22.755556 5.688889 45.511111 11.377778 68.266667l-256 256c-22.755556-5.688889-45.511111-11.377778-68.266667-11.377778C147.911111 568.888889 56.888889 659.911111 56.888889 768c0 28.444444 5.688889 56.888889 22.755555 85.333333 5.688889 5.688889 11.377778 11.377778 22.755556 17.066667 11.377778 0 17.066667 0 22.755556-5.688889l91.022222-91.022222 39.822222 39.822222-91.022222 91.022222c-5.688889 5.688889-11.377778 17.066667-5.688889 22.755556 0 11.377778 5.688889 17.066667 17.066667 22.755555 22.755556 11.377778 51.2 17.066667 79.644444 17.066667C364.088889 967.111111 455.111111 876.088889 455.111111 768c0-22.755556-5.688889-45.511111-11.377778-68.266667l256-256zM233.244444 910.222222l79.644445-79.644444c11.377778-11.377778 11.377778-28.444444 0-39.822222l-79.644445-79.644445c-11.377778-11.377778-28.444444-11.377778-39.822222 0L113.777778 790.755556v-22.755556C113.777778 688.355556 176.355556 625.777778 256 625.777778c22.755556 0 39.822222 5.688889 62.577778 17.066666 11.377778 5.688889 22.755556 5.688889 34.133333-5.688888l284.444445-284.444445c11.377778-11.377778 11.377778-22.755556 5.688888-34.133333-11.377778-22.755556-17.066667-39.822222-17.066666-62.577778C625.777778 170.666667 705.422222 102.4 790.755556 113.777778l-79.644445 79.644444c-11.377778 11.377778-11.377778 28.444444 0 39.822222l79.644445 79.644445c11.377778 11.377778 28.444444 11.377778 39.822222 0L910.222222 233.244444v22.755556C910.222222 335.644444 847.644444 398.222222 768 398.222222c-22.755556 0-39.822222-5.688889-62.577778-17.066666-11.377778-5.688889-22.755556-5.688889-34.133333 5.688888l-284.444445 284.444445c-11.377778 11.377778-11.377778 22.755556-5.688888 34.133333 11.377778 22.755556 17.066667 39.822222 17.066666 62.577778C398.222222 853.333333 318.577778 921.6 233.244444 910.222222z m-170.666666-568.888889c0-5.688889-5.688889-11.377778-5.688889-17.066666s5.688889-17.066667 5.688889-22.755556l125.155555-125.155555c159.288889-159.288889 347.022222-113.777778 352.711111-108.088889 17.066667 0 28.444444 11.377778 28.444445 22.755555s-11.377778 22.755556-22.755556 28.444445c-108.088889 39.822222-159.288889 113.777778-159.288889 130.844444l56.888889 56.888889c11.377778 11.377778 11.377778 28.444444 5.688889 39.822222s-28.444444 11.377778-39.822222 0l-62.577778-56.888889c-5.688889-11.377778-17.066667-28.444444-11.377778-56.888889 5.688889-34.133333 39.822222-79.644444 96.711112-119.466666-56.888889 5.688889-130.844444 28.444444-199.111112 96.711111l-108.088888 113.777778L199.111111 398.222222l68.266667-68.266666c11.377778-11.377778 28.444444-11.377778 39.822222 0l62.577778 62.577777c11.377778 11.377778 11.377778 28.444444 0 39.822223s-28.444444 11.377778-39.822222 0L284.444444 386.844444 216.177778 455.111111c-5.688889 5.688889-11.377778 11.377778-17.066667 11.377778s-17.066667-5.688889-22.755555-11.377778l-113.777778-113.777778z m870.4 472.177778c11.377778 11.377778 11.377778 28.444444 0 39.822222L853.333333 932.977778c-5.688889 5.688889-11.377778 5.688889-22.755555 5.688889s-17.066667 0-22.755556-5.688889l-233.244444-233.244445c-11.377778-11.377778-11.377778-28.444444 0-39.822222s28.444444-11.377778 39.822222 0l216.177778 216.177778 39.822222-39.822222-216.177778-216.177778c-11.377778-11.377778-11.377778-28.444444 0-39.822222s28.444444-11.377778 39.822222 0l238.933334 233.244444z"></path></svg>
						<span>加载器</span>
					</h2>
					
					<div class="loader-selector">
						<div class="loader-option" onclick="extension('fabric')">
							<label for="loader-fabric">
								<img src="data:image/png;base64,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">
								<span>Fabric</span>
							</label>
						</div>
						<div class="loader-option" onclick="extension('forge')">
							<label for="loader-forge">
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADgAAAA4CAYAAACohjseAAAACXBIWXMAAAidAAAInQGyjvixAAADaklEQVRoge2ZW4hNURjHfzNmua0lQrnXKOU6LokUZVwmnjzhgRIPFEaNkqRIeeFBSnjx4IkwpTRuMyEUL4SiXEqZlGakmJm1GLPMjIe16ThztrP32XvTnvavduesvdf6vu9/9t5rre87Zb29vfRnyv93AEmTCUw7mcC0kwlMO5nAtJMJTDuZwLSTCUw7FUkZtkYrYHRS9gPQIqTqTEwgsBY4m6D9YiwD7lZYo8uB9cDgCMa+AteBq177MtAeLb54qBBS9Vij3+KCmliinW5gHLDUa3cCF3z6fge0d7QBxjt+tXXOuXbvyO9jgK4iMbWA9w4KqR5Zo+cD54CVYdUBA4ApOe1Zf+k7yDtGleAnl1agHrgC3BdSFRT8+x0UUn20Rq8GDgAHgbKQDqfmfJ8AjAg5PiiNwCngppDKFuv8xyQjpOoGDlmjH+ImiPEhHE/La88MMTYI94A9QqrHYQYVXAeFVE3AbOBSCFszirRLpRPYBiwLKw6grFhd1Bq9ATgNDC9i6x1QmdPuAIaFDSiPT8AqIdWTUg0UFQhgjR4LHAM2lOqoBNqBJUKq51GMBNqqCalahFQbgcXA/SgOQ7AlqjgIeAfzsUYvBNYBC4AqYGTUQPJoFFKtjsNQSQLzsUYPxK1rgwCFWyLmAjvpO7sGoUZIdStyYMQk0A9r9GCggXCbhy5ACql+xBFDogIBrNGTcDNs0NSsWUhVGZf/xPNBIdV74FWIISpO//8q4R0Sou8oa/T0uBwnLtAaXQ1MDjlsX1z+ExXoiasvYegma/Qhb5KKRKyTjDW6DKgGFgFrvM+g9ND3B/8CXAMeA6+BJi8hCEzcAo8DdT6Xu3FZ/wpgqE+fO7h10y+LOSmk2hUmptgeUWv0bvzFvcbVaObiLw5gObAfl3gXotYaHUpgXDuZ9cDFApd6gRO4oBtwAorRAczDbQHP0Lcy1wOsEVJdCxJbXHdwh8/520KqOmA7wcSBS7HO4wpYewtcLwe2Bg0sybIhgPZ2Modxj2kD8BR4g8v12nBr5HBcLjkHV+5bCdQCzVEDSFpgGy7FqhFSPfDp8xn4ALwEbgBHrNFjgM3At6gBxCXwmc/5p0Iqv/KhL0KqVuCoNboKV4vJ50VQW4lvtv83/f7Pl0xg2skEpp1MYNrJBKadTGDa6fcCfwKIG+8hWGn4eQAAAABJRU5ErkJggg==">
								<span>Forge</span>
							</label>
						</div>
						<div class="loader-option" onclick="extension('neoforge')">
							<label for="loader-neoforge">
								<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADgAAAA4CAYAAACohjseAAAACXBIWXMAAAidAAAInQGyjvixAAAE7mlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgOS4xLWMwMDIgNzkuYTZhNjM5NiwgMjAyNC8wMy8xMi0wNzo0ODoyMyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIDI1LjkgKFdpbmRvd3MpIiB4bXA6Q3JlYXRlRGF0ZT0iMjAyNi0wMS0zMVQxMToxMDo1NCswODowMCIgeG1wOk1vZGlmeURhdGU9IjIwMjYtMDEtMzFUMTE6NDQ6MTQrMDg6MDAiIHhtcDpNZXRhZGF0YURhdGU9IjIwMjYtMDEtMzFUMTE6NDQ6MTQrMDg6MDAiIGRjOmZvcm1hdD0iaW1hZ2UvcG5nIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjgzZmZjOTA0LTM4OGUtODc0Zi1hMzJjLTAyYzQ0YzYwMTYyNyIgeG1wTU06RG9jdW1lbnRJRD0i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">
								<span>NeoForge</span>
							</label>
						</div>
						<div class="loader-option" onclick="extension(null)">
							<label for="loader-none">
								<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M512 1024c-282.282667 0-512-229.660444-512-512s229.717333-512 512-512c282.339556 0 512 229.660444 512 512s-229.660444 512-512 512z m202.524444-671.630222l-51.768888-51.768889-155.136 155.192889-155.136-155.136-51.768889 51.768889L455.907556 507.448889 300.714667 662.755556l51.768889 51.712L507.619556 559.217778l155.136 155.192889 51.768888-51.768889-155.192888-155.136 155.136-155.136z"></path></svg>
								<span>无加载器</span>
							</label>
						</div>
					</div>
					
					<div class="list">
						<div class="scrollbar" id="extensions"><center>none</center></div>
					</div>

					<input type="hidden" name="extension-type" id="extension-type" />
					<input type="hidden" name="extension-value" id="extension-value" />
				</div>
				
				<div class="form-section">
					<h2 class="section-title">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="33326"><path d="M958.5 716.5v186.2c0.3 14.8-5.2 29.1-15 39.6-9.5 10.6-22.7 16.5-36.5 16.3H118c-13.8 0.2-27-5.7-36.4-16.3-9.9-10.5-15.3-24.8-15-39.6V716.5c-0.3-14.8 5.2-29.1 15-39.6 9.5-10.6 22.7-16.5 36.4-16.3h249.3l72.4 79.1c19.2 20.8 45.5 32.6 72.9 32.6 27.4 0 53.7-11.7 72.9-32.6l72.9-79.1h248.7c13.8-0.2 27 5.7 36.4 16.3 9.9 10.6 15.3 24.8 15 39.6zM784.3 385.4c6.1 15.9 3.6 29.5-7.5 40.7L536.7 686.9c-6.3 7.1-15 11.1-24.1 11.1-9.1 0-17.9-4-24.1-11.1L248.3 426.1c-11.1-11.2-13.6-24.8-7.5-40.7 4.7-14.1 17.5-23.3 31.6-22.7h137.2V102c-0.1-9.8 3.6-19.3 10.2-26.2 6.2-7.1 15-11.1 24.1-11.1h137.2c9.1-0.1 17.9 4 24.1 11.1 6.6 6.9 10.3 16.4 10.2 26.2v260.7h137.2c14.2-0.6 27 8.6 31.7 22.7z m-41.8 487.7c13.6-14.5 13.6-37.9 0-52.4-6.3-7.1-15-11.1-24.1-11.1-9.1 0-17.9 4-24.1 11.1-13.6 14.5-13.6 37.9 0 52.4 6.3 7.1 15 11.1 24.1 11.1 9.1-0.1 17.8-4.1 24.1-11.1z m137.2 0c13.6-14.5 13.6-37.9 0-52.4-6.3-7.1-15-11.1-24.1-11.1-9.1 0-17.9 4-24.1 11.1-13.6 14.5-13.6 37.9 0 52.4 6.3 7.1 15 11.1 24.1 11.1 9.1-0.1 17.9-4.1 24.1-11.1z m0 0"></path></svg>
						<span>资源下载列表</span>
					</h2>
					
					<div class="form-group">
						<textarea name="downloads" id="downloads" rows="15" placeholder="在此输入资源地址，每行一个地址"></textarea>
						<div class="info-text">每行一个地址</div>
					</div>
				</div>
			</div>

			<div class="form-actions">
				<button type="button" class="btn btn-secondary" onclick="exit()">退出</button>
				<button class="btn btn-primary">保存</button>
			</div>
		</form>
		
		
		<script src="../js/main.js"></script>
		<script>
			function getJson(url, container, onclick)
			{
				const addDiv = function(content, onclick) {
					const newDiv = document.createElement('div');
					
					newDiv.onclick = onclick;
					newDiv.textContent = content;
					
					container.appendChild(newDiv);
				}
				
				fetch(url)
					.then(response => response.json())
					.then(data => {
						container.innerHTML = '';
						onclick(data, addDiv);
						
						if (container.innerHTML.trim() === '') {
							container.innerHTML = '<center>没有数据</center>';
						}
					})
					.catch(() => {
						container.innerHTML = '<center>加载失败</center>';
					});
					
				container.innerHTML = '<center><span class="loader"></span></center>';
			}
			
			function extension(type)
			{
				const version = document.getElementById("version");
				const loaders = document.getElementById("extensions");
				const loaderType = document.getElementById("extension-type");
				const loaderValue = document.getElementById("extension-value");
				
				
				loaderType.value = '';
				loaderValue.value = '';
				
				
				if (!version.value) {
					return;
				}
				
				if (type === null) {
					loaders.innerHTML = '<center>none</center>';
				}
				
				if (type === 'fabric')
				{
					getJson('https://meta.fabricmc.net/v2/versions/loader/'+(version.value), loaders, (data, addDiv) => {
						for(const item of data) {
							addDiv([type,item.loader.version].join('-'), () => {
								loaderType.value = type;
								loaderValue.value = item.loader.version;
								loaders.innerHTML = `<center>${type}-${item.loader.version}</center>`;
							});
						}
					});
				}
				
				if (type === 'forge')
				{
					getJson('clientnew.php/forge', loaders, (data, addDiv) => {
						if (data[version.value]) {
							for(const item of data[version.value].reverse()) {
								addDiv([type,item].join('-'), () => {
									loaders.innerHTML = `<center>${type}-${item}</center>`;
									loaderType.value = type;
									loaderValue.value = item;
								});
							}
						}
					});
				}
				
				if (type === 'neoforge')
				{
					getJson('https://maven.neoforged.net/api/maven/versions/releases/net/neoforged/neoforge', loaders, (data, addDiv) => {
						const [ v1, v2, v3 ] = version.value.split('.');
						
						for(const item of data.versions.reverse()) {
							if (item.startsWith([v2, v3 ?? 0, ''].join('.'))) {
								addDiv([type,item].join('-'), () => {
									loaders.innerHTML = `<center>${type}-${item}</center>`;
									loaderType.value = type;
									loaderValue.value = item;
								});
							}
						}
					});
				}
			}
			
			function exit() {
				window.parent.loading();
				location.replace("fileclients.php");
			}
			
			
			const version = document.getElementById('version');
			version.addEventListener('input', function(event) {
				document.getElementById("extensions").innerHTML = '<center>none</center>';
				document.getElementById("extension-type").value = '';
				document.getElementById("extension-value").value = '';
			});
			version.addEventListener('focus', function(event) {
				
				const versions = document.getElementById("versions");
				const loaders = document.getElementById("extensions");
				const loaderType = document.getElementById("extension-type");
				const loaderValue = document.getElementById("extension-value");
				
				getJson('https://launchermeta.mojang.com/mc/game/version_manifest.json', versions, (data, addDiv) => {
					for(const item of data.versions) {
						if (item.type === 'release') {
							addDiv(item.id, () => {
								version.value = item.id;
								
								loaders.innerHTML = '<center>none</center>';
								loaderType.value = '';
								loaderValue.value = '';
								document.getElementById("versions-list").classList.add('hidden');
							});
						}
					}
				});
				
				document.getElementById("versions-list").classList.remove('hidden');
			});
			
			
			const client = {json:var.mc_client};
			if (client.name)
			{
				let servers = [];
				for (const server of client.server) {
					servers.push(`${server.address}:${server.port}:${server.name}`);
				}
				
				if (client.extensionValue === '') {
					document.getElementById("extensions").innerHTML = '<center>none</center>';
				} else {
					document.getElementById("extensions").innerHTML = `<center>${client.extensionType}-${client.extensionValue}</center>`;
				}
				
				document.getElementById("extension-type").value  = client.extensionType;
				document.getElementById("extension-value").value = client.extensionValue;
				
				document.getElementById("game").value      = client.game.join('\r\n');
				document.getElementById("jvm").value       = client.jvm.join('\r\n');
				document.getElementById("server").value    = servers.join('\r\n');
				document.getElementById("name").value      = client.name;
				document.getElementById("version").value   = client.version;
				document.getElementById("weight").value    = client.weight;
				document.getElementById("downloads").value = client.downloads;
			}
			else
			{
				const jvm = [
					'-Xmx6G',
					'-XX:+UseG1GC',
					'-XX:-UseAdaptiveSizePolicy',
					'-XX:-OmitStackTraceInFastThrow',
					'-Dfml.ignoreInvalidMinecraftCertificates=true',
					'-Dfml.ignorePatchDiscrepancies=true',
					'-Djdk.lang.Process.allowAmbiguousCommands=true',
					'-Dlog4j2.formatMsgNoLookups=true',
				];
				
				const game = [
					'--width 954',
					'--height 580',
				];
				
				document.getElementById("jvm").value = jvm.join('\r\n');
				document.getElementById("game").value = game.join('\r\n');
				document.getElementById("server").value = '127.0.0.1:25565:§e我的世界服务器';
				document.getElementById("weight").value = 0;
				document.getElementById("name").value = '';
				document.getElementById("version").value = '';
				document.getElementById("downloads").value = '';
			}
			
			
			handleFormSubmit("form", (fetch) => {
				fetch.then((data) => {
					if (data.error) {
						showMessage(data.error);
					}
					
					if (data.message === 'add') {
						exit();
					}
					
					if (data.message === 'save') {
						showMessage('保存完成');
					}
				});
			});
		</script>
	</body>
</html>