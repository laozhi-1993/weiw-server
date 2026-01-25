<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_verify_access');
?>
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>后台管理系统</title>
		<style>
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
				font-family: 'Segoe UI', 'Microsoft YaHei', sans-serif;
			}
			
			body {
				background-color: #2e2e2e;
				color: #e0e0e0;
				min-height: 100vh;
				display: flex;
				flex-direction: column;
			}
			
			/* 导航容器 - 固定在顶部 */
			.nav-container {
				background-color: #2e2e2e;
				padding: 0 20px;
				padding-top: 30px;
				padding-bottom: 10px;
				display: flex;
				justify-content: space-between;
				align-items: center;
				user-select: none;
				box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
				position: sticky;
				top: 0;
				z-index: 80;
				height: 80px;
			}
			
			.logo {
				display: flex;
				align-items: center;
				gap: 12px;
			}
			
			.logo-icon {
				width: 38px;
				height: 38px;
				background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
				border-radius: 8px;
				display: flex;
				align-items: center;
				justify-content: center;
				color: white;
				font-weight: bold;
			}
			
			.logo-icon svg {
				width: 20px;
				height: 20px;
				fill: white;
			}
			
			.logo-text {
				font-size: 22px;
				font-weight: 700;
				background: linear-gradient(to right, #6a11cb, #2575fc);
				-webkit-background-clip: text;
				background-clip: text;
				color: transparent;
			}
			
			.nav-buttons {
				display: flex;
				gap: 8px;
			}
			
			.nav-button {
				background-color: #3a3a3a;
				border: none;
				border-radius: 8px;
				color: #e0e0e0;
				padding: 10px 20px;
				display: flex;
				align-items: center;
				gap: 10px;
				cursor: pointer;
				transition: all 0.3s ease;
				font-size: 13px;
				font-weight: 500;
			}
			
			.nav-button:hover {
				background-color: #4a4a4a;
				transform: translateY(-2px);
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
			}
			
			.nav-button.active {
				background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
				color: white;
			}
			
			.nav-button svg {
				width: 18px;
				height: 18px;
				fill: currentColor;
			}
			
			/* 返回首页按钮特殊样式 */
			.home-btn {
				background-color: #3a3a3a;
				border: none;
				border-radius: 8px;
				color: #e0e0e0;
				padding: 10px 20px;
				display: flex;
				align-items: center;
				gap: 10px;
				cursor: pointer;
				transition: all 0.3s ease;
				font-size: 13px;
				font-weight: 500;
				text-decoration: none;
			}
			
			.home-btn:hover {
				background-color: #4a4a4a;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
				transform: translateY(-2px);
			}
			
			.home-btn svg {
				width: 18px;
				height: 18px;
				fill: currentColor;
			}
			
			
			/* 内容区域 - iframe容器 */
			.content-container {
				flex: 1;
				display: flex;
				flex-direction: column;
				position: relative;
			}
			
			.iframe-wrapper {
				height: calc(100vh - 130px);
				position: relative;
				padding: 10px;
			}
			
			.iframe-wrapper iframe {
				width: 100%;
				height: 100%;
				border: none;
			}
			
			@keyframes spin {
				to { transform: rotate(360deg); }
			}
			
			.page-title {
				font-size: 20px;
				margin-bottom: 10px;
				color: #f0f0f0;
				text-align: center;
			}
			
			footer {
				text-align: center;
				padding: 15px;
				color: #888;
				font-size: 14px;
				border-top: 1px solid #3a3a3a;
				background-color: #2e2e2e;
			}
			
			.skeleton-container {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				display: flex;
				flex-direction: column;
				gap: 30px;
				overflow: none;
				padding: 10px;
				box-sizing: border-box;
				background-color: #2e2e2e;
			}
			
			.skeleton-container.hidden {
				display: none;
			}
			
			.skeleton-row {
				display: flex;
				gap: 30px;
				width: 100%;
			}
			
			.skeleton-col {
				flex: 1;
				display: flex;
				flex-direction: column;
				gap: 30px;
			}
			
			.skeleton-item {
				background-color: #444;
				border-radius: 8px;
				position: relative;
				overflow: hidden;
			}
			
			/* 闪烁动画 */
			.skeleton-item::after {
				content: '';
				position: absolute;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				background: linear-gradient(90deg, 
					transparent, 
					rgba(255, 255, 255, 0.1), 
					transparent);
				animation: shimmer 1s infinite;
			}
			
			.skeleton-header {
				height: 80px;
				margin-bottom: 20px;
			}
			
			.skeleton-title {
				height: 40px;
				width: 70%;
			}
			
			.skeleton-text {
				height: 16px;
				width: 100%;
			}
			
			.skeleton-text.short {
				width: 85%;
			}
			
			.skeleton-text.medium {
				width: 92%;
			}
			
			.skeleton-avatar {
				width: 60px;
				height: 60px;
				border-radius: 50%;
			}
			
			.skeleton-card {
				height: 200px;
			}
			
			.skeleton-image {
				height: 180px;
			}
			
			.skeleton-footer {
				height: 100%;
				margin-top: 20px;
			}
			
			@keyframes shimmer {
				0% { transform: translateX(-100%); }
				100% { transform: translateX(100%); }
			}
			
			@media (max-width: 768px) {
				.skeleton-row {
					flex-direction: column;
				}
			}

			@media (max-width: 1024px) {
				.nav-container {
					flex-direction: column;
					height: auto;
					padding: 15px 20px;
					gap: 15px;
				}
				
				.nav-buttons {
					flex-wrap: wrap;
					justify-content: center;
				}
			}
			
			@media (max-width: 768px) {
				.nav-button {
					padding: 10px 15px;
					font-size: 14px;
				}
				
				.nav-button span {
					display: none;
				}
				
				.nav-button svg {
					width: 22px;
					height: 22px;
				}
			}
		</style>
	</head>
	<body>
		<includes-header><?php include('../includes/window-header.html') ?></includes-header>
		
		<!-- 导航容器 -->
		<header class="nav-container">
			<div class="logo">
				<div class="logo-icon">
					<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
						<path d="M961.5 167.7L545.6 12.5c-10.8-4-22.2-6-33.5-6-11.4 0-22.8 2-33.7 6.1l-416.1 156C24.8 182.7 0 218.5 0 258.5v433.1c0 35.4 19.4 67.9 50.6 84.6l417.6 224.3c14.2 7.6 29.8 11.4 45.4 11.4 14.7 0 29.4-3.4 42.9-10.1l414.4-207.2c32.5-16.3 53.1-49.5 53.1-85.9v-451c0-40.1-24.9-76-62.5-90zM500.8 72.5c3.6-1.3 7.4-2 11.2-2 3.8 0 7.6 0.7 11.2 2l365.6 136.4c10.5 3.9 10.4 18.8-0.2 22.5l-344.5 123a95.55 95.55 0 0 1-64.6 0L136.3 231.8c-10.5-3.8-10.6-18.6-0.2-22.5L500.8 72.5zM960 708.7c0 12.2-6.8 23.2-17.7 28.6L578.7 919.1c-16 8-34.7-3.6-34.7-21.5V456.4c0-20.3 12.8-38.4 31.9-45.2L928 285.5c15.6-5.6 32.1 6 32.1 22.6v400.6z"></path>
					</svg>
				</div>
				<div class="logo-text">后台管理系统</div>
			</div>
			
			<div class="nav-buttons">
				<a href="../index.php" class="home-btn">
					<svg viewBox="0 0 1152 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
						<path d="M560.77004 296.52L192.03004 600.22V928a32 32 0 0 0 32 32l224.12-0.58a32 32 0 0 0 31.84-32V736a32 32 0 0 1 32-32h128a32 32 0 0 1 32 32v191.28a32 32 0 0 0 32 32.1L928.03004 960a32 32 0 0 0 32-32V600L591.37004 296.52a24.38 24.38 0 0 0-30.6 0zM1143.23004 502.94L976.03004 365.12V88.1a24 24 0 0 0-24-24h-112a24 24 0 0 0-24 24v145.22L636.97004 86a96 96 0 0 0-122 0L8.71004 502.94a24 24 0 0 0-3.2 33.8l51 62A24 24 0 0 0 90.33004 602l470.44-387.48a24.38 24.38 0 0 1 30.6 0L1061.83004 602a24 24 0 0 0 33.8-3.2l51-62a24 24 0 0 0-3.4-33.86z"></path>
					</svg>
					<span>首页</span>
				</a>
				<button class="nav-button" data-page="config.php">
					<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
						<path d="M199.36 257.472c26.112 14.208 54.848 26.432 85.568 36.48a807.296 807.296 0 0 0-26.176 190.336H64a446.208 446.208 0 0 1 92.544-253.824c13.632 9.92 27.968 18.944 42.816 27.008z m293.12 265.856H297.792c1.408 63.36 9.792 124.288 24.512 179.328a748.608 748.608 0 0 1 170.24-23.104V523.328z m-293.12 226.88a513.728 513.728 0 0 1 85.568-36.544 807.296 807.296 0 0 1-26.176-190.336H64a446.208 446.208 0 0 0 92.544 253.888c13.632-9.92 27.968-18.944 42.816-27.008z m332.16-673.472v212.416a709.76 709.76 0 0 0 158.976-21.44 502.4 502.4 0 0 0-30.336-71.936c-35.84-68.672-80.896-110.144-128.64-119.04z m-39.04 407.616V328.128a748.48 748.48 0 0 1-170.176-23.104c-14.72 55.04-23.104 115.968-24.512 179.328h194.688z m209.216-179.328c-52.864 13.76-110.464 21.696-170.24 23.04v156.288h194.752a767.424 767.424 0 0 0-24.512-179.328z m-209.216 625.92v-212.416c-55.872 1.408-109.696 8.704-158.976 21.44 8.256 24.704 18.368 48.768 30.336 71.936 35.84 68.672 80.896 110.08 128.64 119.04zM363.84 195.776a502.4 502.4 0 0 0-30.336 71.936c49.28 12.672 103.104 20.032 158.976 21.44v-212.48c-47.744 8.96-92.8 50.432-128.64 119.04z m460.8 61.696a513.664 513.664 0 0 1-85.568 36.48c15.744 58.624 24.704 123.264 26.176 190.336H960A446.208 446.208 0 0 0 867.456 230.4a386.56 386.56 0 0 1-42.816 27.072z m-606.592-34.24c23.744 12.992 49.92 24.128 78.08 33.472 9.408-28.16 20.48-54.72 33.152-78.976 22.72-43.52 49.408-77.952 79.36-102.208q7.68-6.272 15.552-11.52a447.808 447.808 0 0 0-242.56 136.576c11.712 8.32 23.872 15.808 36.416 22.656z m190.592 708.928c-29.952-24.32-56.64-58.688-79.36-102.272a540.16 540.16 0 0 1-33.152-78.912c-28.16 9.28-54.336 20.48-78.08 33.472a354.368 354.368 0 0 0-36.352 22.656 447.808 447.808 0 0 0 242.56 136.512q-7.936-5.248-15.616-11.52z m397.312-147.712a474.88 474.88 0 0 0-78.08-33.472c-9.408 28.16-20.48 54.656-33.152 78.912-22.72 43.584-49.408 78.016-79.36 102.272q-7.68 6.208-15.552 11.52a447.808 447.808 0 0 0 242.56-136.576 354.24 354.24 0 0 0-36.416-22.656z m-145.792 27.456c11.968-23.168 22.08-47.232 30.336-71.936-49.28-12.736-103.104-20.032-158.976-21.44v212.416c47.744-8.96 92.8-50.368 128.64-119.04z m-128.64-288.576v156.16c59.712 1.472 117.312 9.344 170.176 23.168 14.72-55.04 23.104-115.904 24.512-179.328H531.584z m83.84-447.808c29.952 24.32 56.64 58.624 79.36 102.208 12.672 24.32 23.744 50.752 33.152 78.976 28.16-9.28 54.336-20.48 78.08-33.472 12.608-6.784 24.704-14.4 36.352-22.656A447.68 447.68 0 0 0 599.744 64q7.936 5.248 15.616 11.52z m252.16 701.696A446.208 446.208 0 0 0 960 523.328h-194.752a807.488 807.488 0 0 1-26.176 190.272c30.72 10.176 59.52 22.4 85.568 36.608 14.848 8.064 29.184 17.088 42.88 27.008z"></path>
					</svg>
					<span>网站</span>
				</button>
				<button class="nav-button" data-page="users.php">
					<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
						<path d="M315.076923 527.753846c-55.138462 0-102.4 23.630769-141.784615 70.892308h-70.892308c-31.507692 0-55.138462-7.876923-70.892308-23.630769-15.753846-15.753846-31.507692-31.507692-31.507692-63.015385 0-126.030769 23.630769-189.046154 63.015385-189.046154 0 0 7.876923 0 23.630769 7.876923s31.507692 15.753846 55.138461 23.630769c23.630769 7.876923 39.384615 7.876923 63.015385 7.876924 23.630769 0 47.261538-7.876923 70.892308-15.753847v31.507693c-7.876923 63.015385 7.876923 110.276923 39.384615 149.661538z m-15.753846-433.230769c23.630769 23.630769 39.384615 55.138462 39.384615 94.523077s-15.753846 70.892308-39.384615 94.523077c-23.630769 23.630769-55.138462 39.384615-94.523077 39.384615s-70.892308-15.753846-94.523077-39.384615-39.384615-55.138462-39.384615-94.523077 15.753846-70.892308 39.384615-94.523077 55.138462-39.384615 94.523077-39.384615 63.015385 15.753846 94.523077 39.384615z m575.015385 771.938461c0 39.384615-15.753846 78.769231-39.384616 102.4s-63.015385 39.384615-102.4 39.384616H267.815385c-39.384615 0-78.769231-15.753846-102.4-39.384616-23.630769-23.630769-39.384615-55.138462-39.384616-102.4v-55.138461c0-15.753846 0-39.384615 7.876923-55.138462 0-23.630769 7.876923-39.384615 15.753846-55.138461 7.876923-15.753846 15.753846-31.507692 23.63077-55.138462s23.630769-31.507692 31.507692-39.384615c15.753846-7.876923 23.630769-23.630769 47.261538-31.507692 15.753846-7.876923 39.384615-7.876923 55.138462-7.876923 0 0 7.876923 0 23.630769 7.876923 7.876923 7.876923 23.630769 15.753846 39.384616 23.630769 15.753846 7.876923 31.507692 15.753846 55.138461 23.630769 23.630769 7.876923 47.261538 7.876923 70.892308 7.876923 23.630769 0 47.261538 0 70.892308-7.876923 23.630769-7.876923 39.384615-15.753846 55.138461-23.630769 15.753846-7.876923 23.630769-15.753846 39.384615-23.630769 7.876923-7.876923 15.753846-7.876923 23.63077-7.876923 23.630769 0 39.384615 0 55.138461 7.876923 15.753846 7.876923 31.507692 15.753846 47.261539 31.507692 15.753846 15.753846 23.630769 23.630769 31.507692 39.384615 7.876923 15.753846 15.753846 31.507692 23.630769 55.138462 7.876923 15.753846 7.876923 39.384615 15.753846 55.138461 0 23.630769 7.876923 39.384615 7.876923 55.138462s7.876923 31.507692 7.876924 55.138461zM645.907692 252.061538c39.384615 39.384615 63.015385 86.646154 63.015385 141.784616s-23.630769 102.4-63.015385 141.784615-86.646154 63.015385-141.784615 63.015385-102.4-23.630769-141.784615-63.015385-63.015385-86.646154-63.015385-141.784615 23.630769-102.4 63.015385-141.784616 86.646154-63.015385 141.784615-63.015384 102.4 23.630769 141.784615 63.015384z m259.938462-157.538461c23.630769 23.630769 39.384615 55.138462 39.384615 94.523077s-15.753846 70.892308-39.384615 94.523077c-23.630769 23.630769-55.138462 39.384615-94.523077 39.384615s-70.892308-15.753846-94.523077-39.384615c-23.630769-23.630769-39.384615-55.138462-39.384615-94.523077s15.753846-70.892308 39.384615-94.523077c23.630769-23.630769 55.138462-39.384615 94.523077-39.384615s70.892308 15.753846 94.523077 39.384615z m110.276923 417.476923c0 23.630769-7.876923 47.261538-31.507692 63.015385-15.753846 15.753846-47.261538 23.630769-70.892308 23.630769h-70.892308c-39.384615-39.384615-86.646154-63.015385-141.784615-70.892308 31.507692-39.384615 39.384615-86.646154 39.384615-133.907692v-31.507692c23.630769 7.876923 47.261538 15.753846 70.892308 15.753846 23.630769 0 39.384615 0 63.015385-7.876923 23.630769-7.876923 39.384615-15.753846 55.138461-23.63077s23.630769-7.876923 23.630769-7.876923c39.384615-15.753846 63.015385 47.261538 63.015385 173.292308z"></path>
					</svg>
					<span>用户</span>
				</button>
				<button class="nav-button" data-page="items.php">
					<svg viewBox="0 0 1120 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
						<path d="M384 870.4c42.4128 0 76.8 34.3872 76.8 76.8s-34.3872 76.8-76.8 76.8-76.8-34.3872-76.8-76.8 34.3872-76.8 76.8-76.8z m460.8 0c42.4128 0 76.8 34.3872 76.8 76.8s-34.3872 76.8-76.8 76.8-76.8-34.3872-76.8-76.8 34.3872-76.8 76.8-76.8zM123.1488 0A76.8 76.8 0 0 1 198.336 61.1392l12.896 61.888A38.4 38.4 0 0 0 248.8256 153.6h788.3968c42.4128 0 76.8 34.3872 76.8 76.8a76.8 76.8 0 0 1-0.8512 11.392l-53.76 358.4A76.8 76.8 0 0 1 983.4624 665.6h-632.768a38.4 38.4 0 0 0-38.0992 43.1616l3.2 25.6A38.4 38.4 0 0 0 353.9008 768H934.4a38.4 38.4 0 0 1 0 76.8H320.5248a76.8 76.8 0 0 1-75.648-63.5584L127.1616 108.5824A38.4 38.4 0 0 0 89.3376 76.8H38.4A38.4 38.4 0 1 1 38.4 0h84.7488z"></path>
					</svg>
					<span>道具</span>
				</button>
				<button class="nav-button" data-page="fileclients.php">
					<svg viewBox="0 0 1179 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
						<path d="M755.661528 1023.994434H422.447272c-33.580249-24.579874-34.949508-33.524588-17.828202-71.802621 11.983802-26.79518 21.028706-54.909524 33.374304-87.716086h-39.675123c-97.178447-0.005566-194.356893 0.406325-291.529773-0.161417C37.87466 863.913552 0.14767 825.885993 0.103141 757.73473-0.041577 541.068929-0.024879 324.397563 0.092009 107.731762 0.130972 38.968229 37.117671 0.389627 105.95913 0.289437c322.065369-0.473118 644.136304-0.473118 966.207239 0 69.203255 0.10019 105.855988 38.372657 105.878252 107.097227 0.050095 214.817857-1.75332 429.657979 1.096521 644.436873 0.857179 64.216034-40.70485 115.368444-112.65219 113.320122-96.170983-2.732952-192.481119-0.706894-288.730028-0.606705-9.729533 0.005566-19.459067 0.846046-36.936604 1.664262 12.139652 32.288915 21.012007 59.980236 32.828826 86.346827 17.221497 38.417185 15.718651 47.718129-17.989618 71.446391z m-169.398525-394.129597c159.078985 0 318.163537 0.044529 477.248089-0.033396 34.571014-0.016698 37.893972-3.311826 37.916236-38.506243 0.111322-158.232939 0.10019-316.465878 0.011132-474.704383-0.022264-35.801121-2.749651-38.645395-37.259437-38.650961-316.315593-0.061227-632.631186-0.061227-948.94678 0-35.405928 0.005566-37.459817 2.20974-37.465383 38.01086-0.038963 158.238505-0.038963 316.471444-0.005566 474.704383 0.011132 37.025662 2.13738 39.15191 39.574933 39.163042 156.30707 0.044529 312.61414 0.016698 468.926776 0.016698z"></path>
					</svg>
					<span>客户端</span>
				</button>
				<button class="nav-button active" data-page="fileservers.php">
					<svg viewBox="0 0 1075 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">
						<path d="M1024 563.2H51.2A51.2 51.2 0 0 0 0 614.4v358.4a51.2 51.2 0 0 0 51.2 51.2H1024a51.2 51.2 0 0 0 51.2-51.2V614.4a51.2 51.2 0 0 0-51.2-51.2zM972.8 921.6H102.4V665.6h870.4zM1024 0H51.2a51.2 51.2 0 0 0-51.2 51.2V409.6a51.2 51.2 0 0 0 51.2 51.2H1024a51.2 51.2 0 0 0 51.2-51.2V51.2A51.2 51.2 0 0 0 1024 0z m-51.2 358.4H102.4V102.4h870.4z"></path>
						<path d="M248.832 274.432A44.032 44.032 0 1 0 204.8 230.4a44.032 44.032 0 0 0 44.032 44.032zM248.832 837.632A44.032 44.032 0 1 0 204.8 793.6a44.032 44.032 0 0 0 44.032 44.032zM453.632 274.432A44.032 44.032 0 1 0 409.6 230.4a44.032 44.032 0 0 0 44.032 44.032zM453.632 837.632A44.032 44.032 0 1 0 409.6 793.6a44.032 44.032 0 0 0 44.032 44.032zM716.8 844.8h102.4a51.2 51.2 0 0 0 0-102.4H716.8a51.2 51.2 0 0 0 0 102.4z"></path>
					</svg>
					<span>服务端</span>
				</button>
			</div>
		</header>
		
		<!-- 内容容器 - iframe加载不同页面 -->
		<main class="content-container">
			<div class="iframe-wrapper">
				<!-- 骨架屏 -->
				<div class="skeleton-container" id="loading-overlay">
					<div class="skeleton-row">
						<div class="skeleton-col">
							<div class="skeleton-item skeleton-header"></div>
							<div class="skeleton-item skeleton-title"></div>
							<div class="skeleton-item skeleton-text short"></div>
							<div class="skeleton-item skeleton-text medium"></div>
							<div class="skeleton-item skeleton-text"></div>
							<div class="skeleton-item skeleton-text short"></div>
						</div>
						<div class="skeleton-col">
							<div class="skeleton-item skeleton-card"></div>
							<div class="skeleton-row">
								<div class="skeleton-item skeleton-avatar"></div>
								<div class="skeleton-col" style="flex: 3;">
									<div class="skeleton-item skeleton-text" style="width: 70%;"></div>
									<div class="skeleton-item skeleton-text" style="width: 90%;"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="skeleton-row">
						<div class="skeleton-col">
							<div class="skeleton-item skeleton-image"></div>
						</div>
						<div class="skeleton-col">
							<div class="skeleton-item skeleton-image"></div>
						</div>
						<div class="skeleton-col">
							<div class="skeleton-item skeleton-image"></div>
						</div>
					</div>
					<div class="skeleton-item skeleton-footer"></div>
				</div>
				<!-- 初始加载的iframe -->
				<iframe id="main-iframe" src=""></iframe>
			</div>
		</main>
		
		<footer>
			<p>© 2026 后台管理系统 | 当前时间: <span id="current-time"></span></p>
		</footer>

		<script>
			class TimeoutLatch
			{
				constructor(time)
				{
					this.time = time;
					
					this.toggle = false;
					this.timerId = false;
					this.callback = false;
				}
				
				start()
				{
					clearTimeout(this.timerId);
					
					this.timerId = setTimeout(() => {
						if (this.callback) {
							this.callback();
						} else {
							this.toggle = true;
						}
					}, this.time);
					
					this.toggle = false;
					this.callback = false;
				}
				
				done(callback)
				{
					if (this.toggle) {
						callback();
					} else {
						this.callback = callback;
					}
				}
			}
			
			
			// 更新当前时间
			function updateTime() {
				const now = new Date();
				const timeString = now.toLocaleString('zh-CN', {
					year: 'numeric',
					month: '2-digit',
					day: '2-digit',
					hour: '2-digit',
					minute: '2-digit',
					second: '2-digit',
					hour12: false
				});
				document.getElementById('current-time').textContent = timeString;
			}
			
			// 初始更新时间
			updateTime();
			// 每秒更新一次时间
			setInterval(updateTime, 1000);
			
			// 导航按钮点击事件
			const navButtons = document.querySelectorAll('.nav-button');
			const iframe = document.getElementById('main-iframe');
			const loadingOverlay = document.getElementById('loading-overlay');
			const timeoutLatch = new TimeoutLatch(300);
			
			
			function loadPage(pageUrl) {
				loading()
				iframe.src = pageUrl;
			}
			
			function loading() {
				loadingOverlay.classList.remove("hidden");
				timeoutLatch.start();
			}
			
			
			
			// 当iframe加载完成后隐藏加载遮罩
			iframe.onload = function() {
				timeoutLatch.done(() => {
					loadingOverlay.classList.add("hidden");
				});
			};
			
			// 为每个导航按钮添加点击事件
			navButtons.forEach(button => {
				button.addEventListener('click', function() {
					// 移除所有按钮的active类
					navButtons.forEach(btn => btn.classList.remove('active'));
					// 给当前点击的按钮添加active类
					this.classList.add('active');
					
					// 加载对应页面
					loadPage(this.getAttribute('data-page'));
				});
			});
			
			// 初始加载首页
			window.addEventListener('DOMContentLoaded', () => {
				loadPage('fileservers.php');
			});
		</script>
	</body>
</html>