<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");
	
	
    $MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_user');
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<script src="js/jquery.min.js"></script>
		<script src="js/checkin.js"></script>
		<style>
			body {
				margin: 0;
				padding: 0;
				overflow: hidden;
				background-color: #666;
			}
			header {
				position: absolute;
				top: 28px;
				left: 0;
				z-index: 1;
				width: 100%;
				user-select: none;
				vertical-align: top;
			}
			header .operate {
				padding-left: 10px;
				padding-right: 10px;
				padding-bottom: 2.5px;
				margin-left: 60px;
				font-size: 0;
				-webkit-app-region: drag;
			}
			header .operate .user {
				display: inline-block;
				margin-right: 5px;
				width: calc(100% - 425px);
				height: 45px;
			}
			header .operate .user img {
				width:  100%;
				height: 100%;
			}
			header .operate .user #avatar {
				display: inline-block;
				overflow: hidden;
				margin-right: 5px;
				width:  45px;
				height: 45px;
				border-radius: 5px;
				background-color: #FFFFE0;
			}
			header .operate .user #name {
				display: inline-block;
				padding: 0 8px;
				text-overflow: ellipsis;
				white-space: nowrap;
				overflow: hidden;
				font-size: 20px;
				font-family: "FangSong";
				line-height: 45px;
				color: #000000;
				width: calc(100% - 66px);
				height: 45px;
				border-radius: 5px;
				background-color: #FFFFE0;
			}
			header .operate .checkin {
				display: inline-block;
				font-size: 0;
				overflow: hidden;
				margin-right: 5px;
				height: 45px;
				border-radius: 5px;
				background-color: #FFFFE0;
			}
			header .operate .checkin svg {
				padding: 12.5px 13px;
				padding-right: 2px;
				width: 20px;
				height: 20px;
			}
			header .operate .checkin svg path {
				fill: #7B68EE;
			}
			header .operate .checkin .money {
				display: inline-block;
				vertical-align: top;
				text-align: left;
				font-size: 20px;
				font-family: "Impact";
				color: #000000;
				line-height: 47px;
				width: 150px;
				height: 45px;
			}
			header .operate .checkin .button {
				display: inline-block;
				vertical-align: top;
				text-align: center;
				font-size: 18px;
				font-family: "Digital-7";
				color: #FFFFFF;
				cursor: pointer;
				line-height: 47px;
				width: 100px;
				height: 45px;
				background-color: #7B68EE;
				-webkit-app-region: no-drag;
			}
			header .operate .checkin .button:active {
				background-color: #2f4f4f;
				color: #FFFFFF;
			}
			header .operate .start {
				display: inline-block;
				vertical-align: top;
				text-align: center;
				font-size: 18px;
				cursor: pointer;
				color: #FFFFFF;
				width: 130px;
				height: 45px;
				line-height: 45px;
				background-color: #7B68EE;
				border-radius: 5px;
				-webkit-app-region: no-drag;
			}
			header .operate .start:active {
				background-color: #2f4f4f;
				color: #FFFFFF;
			}
			main {
				position: relative;
				height: 100vh;
			}
			main .menu {
				position: absolute;
				top: 0;
				left: 0;
				z-index: 2;
				width: 60px;
				height: 100vh;
				background-color: #393939;
				text-align: center;
				user-select: none;
				-webkit-app-region: drag;
			}
			main .menu .select {
				background-color: rgba(120,120,120,0.2);
				border-radius: 10px;
			}
			main .menu .select svg path {
				fill: #9393ff;
			}
			main .menu ul {
				list-style-type: none;
				margin:  0;
				padding: 0;
				padding-top: 28px;
			}
			main .menu ul li {
				margin: 0 7px 10px 7px;
				cursor: pointer;
				padding: 8px;
				-webkit-app-region: no-drag;
			}
			main .menu ul li:hover {
				background-color: rgba(120,120,120,0.2);
				border-radius: 10px;
			}
			main .menu ul li svg {
				width: 	25px;
				height: 25px;
				vertical-align: top;
			}
			main .menu ul li svg path {
				fill: #afeeee;
			}
			main .menu .LogOut {
				position: absolute;
				bottom: 10px;
				width: 60px;
				margin-bottom: 5px;
			}
			main .menu .LogOut a {
				display: inline-block;
				cursor: pointer;
				-webkit-app-region: no-drag;
			}
			main .menu .LogOut a svg {
				width: 	30px;
				height: 30px;
				vertical-align: top;
			}
			main .menu .LogOut a svg path {
				fill: #afeeee;
			}
			main .menu .LogOut a:hover svg path {
				fill: #9393ff;
			}
			main .content {
				height: 100%;
				margin-left: 60px;
				padding: 10px;
				padding-top: 80px;
				box-sizing: border-box;
				background: radial-gradient(#666,#222);
			}
			main .content #tab {
				border: none;
				width:  100%;
				height: 100%;
			}
			main .content #tab-loading {
				display: none;
				text-align: center;
				height: 100%;
			}
			
			.loading {
				display: inline-block;
				position: relative;
				top: calc(50% - 100px);
			}
			.loading::before {
				display: inline-block;
				content: 'Loading';
				color: #CCCCCC;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 48px;
				letter-spacing: 2px;
				box-sizing: border-box;
				animation: floating 1s ease-out infinite alternate;
			}
			.loading::after {
				content: '';  
				width: 100%;
				height: 10px;
				background: rgba(0, 0, 0, 0.15);
				position: absolute;
				left: 0;
				top: 100%;
				filter: blur(4px);
				border-radius: 50%;
				box-sizing: border-box;
				animation: animloader 1s ease-out infinite alternate;
			}

			@keyframes floating {
				0% {
					transform: translateY(0);
				}
				100% {
					transform: translateY(-25px);
				}
			}

			@keyframes animloader {
				0% {
					transform: scale(0.8);
				}
				100% {
					transform: scale(1.2);
				}
			}
			
			@font-face {
				font-family: 'digital-7';
				src: url('fonts/7segment.ttf');
			}
		</style>
		<title>我的世界启动器</title>
	</head>
	<body>
		<window-header>
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
		</window-header>
		<header>
			<div class="operate">
				<div class="user">
					<span id="avatar"><img src="/weiw/index_auth.php/avatar/{echo:var.mc_user.SKIN.hash}/48" /></span>
					<span id="name">{echo:var.mc_user.name}</span>
				</div>
				<div class="checkin">
					<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5947"><path d="M387.016962 261.154905l242.128573 0c74.925457 0 132.079154-162.481581 132.079154-162.481581 0-48.660256-4.871961-85.47472-88.069825-88.068801-83.172281-2.619664-103.098099 58.158584-162.871461 58.158584-61.266365 0-91.911316-47.780213-167.301354-58.158584-75.365478-10.426467-88.044242 39.408545-88.044242 88.068801C254.937808 98.674347 312.066947 261.154905 387.016962 261.154905zM642.362558 311.381843l-255.345596 0c-282.762015 0-352.203574 555.509956-352.203574 555.509956 0 72.966848 59.137889 146.252968 132.079154 146.252968l695.569876 0c72.942289 0 132.078131-73.28612 132.078131-146.252968C994.541573 866.892823 925.076478 311.381843 642.362558 311.381843zM671.344636 738.312352c17.036002 0 30.842449 13.829983 30.842449 30.867008 0 17.034978-13.805424 30.864962-30.842449 30.864962l-125.201513 0 0 80.97115c0 17.034978-13.805424 30.867008-30.816866 30.867008-17.036002 0-30.840402-13.83203-30.840402-30.867008L484.485855 800.044322l-126.009925 0c-17.034978 0-30.840402-13.829983-30.840402-30.864962 0-17.037025 13.805424-30.867008 30.840402-30.867008l126.009925 0 0-39.161928-126.009925 0c-17.034978 0-30.840402-13.806447-30.840402-30.842449 0-17.036002 13.805424-30.890544 30.840402-30.890544l85.181031 0-87.212294-154.989957c-8.518001-14.784728-3.451612-33.631982 11.283997-42.148959 14.759145-8.519024 33.607422-3.476171 42.125423 11.258415l105.007589 185.880501 5.310959 0 105.007589-185.880501c8.516977-14.734586 27.365254-19.778462 42.100864-11.258415 14.760169 8.516977 19.827581 27.364231 11.308557 42.148959l-87.212294 154.989957 79.967286 0c17.036002 0 30.842449 13.853519 30.842449 30.890544 0 17.034978-13.805424 30.842449-30.842449 30.842449l-125.201513 0 0 39.161928L671.344636 738.312352z" fill="#272636" p-id="5948"></path></svg>
					<span class="money">{echo:var.mc_user.money}</span>
					<span class="button">签到</span>
				</div>
				<div class="start" onclick="window.start({'username':'{echo:var.mc_user.name}','uuid':'{echo:var.mc_user.uuid}','token':'{echo:var.mc_user.accessToken}'})">
					<span>启动游戏</span>
				</div>
			</div>
		</header>
		<main>
			<div class="menu">
				<ul>
					<li data-url="home.php">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M592.795 942.076v-255.69H432.057v256.373c-5.023 0.259-9.03 0.647-13.039 0.647-75.894 0-151.828 0.041-227.727 0-26.08 0-43.618-16.728-43.733-44.43-0.527-105.2-0.367-210.487 0.116-315.687 0-5.548 4.214-12.642 8.466-16.429 68.687-60.686 137.734-120.984 206.665-181.33 45.884-40.168 91.73-80.34 137.612-120.467 3.565-3.098 7.213-6.106 11.704-9.94 27.377 23.917 54.633 47.7 81.849 71.527 89.783 78.58 179.449 157.332 269.476 235.612 9.68 8.384 13.81 16.899 13.728 30.446-0.566 99.872-0.406 199.778-0.2 299.603 0.037 18.152-4.215 33.937-19.322 43.959-5.467 3.649-12.392 6.794-18.668 6.836-80.551 0.43-161.103 0.21-241.61 0.17-1.174 0.002-2.395-0.558-4.579-1.2z m120.97-707.89c0-42.193-0.04-81.159 0-120.085 0.037-24.858 5.626-30.794 28.995-30.836 36.287 0 72.574-0.04 108.861 0.042 18.711 0.047 25.187 7.053 25.23 28.086 0.085 83.307 0.283 166.664-0.244 249.971-0.082 12.86 3.322 21.115 12.834 29.287 39.775 33.98 78.772 68.901 117.975 103.61 19.233 17.034 19.721 25.33 3.521 45.591-9.797 12.3-19.393 24.817-29.278 37.076-12.148 15.178-22.194 16.126-36.73 3.221-139.193-123.352-278.386-246.788-417.622-370.18-4.82-4.258-9.759-8.433-15.392-13.338-31.303 27.703-62.366 55.1-93.348 82.58-112.988 100.13-225.979 200.296-338.97 300.42-15.308 13.59-24.821 12.777-37.7-3.225a4194.073 4194.073 0 0 1-31.75-40.08c-12.232-15.657-11.744-25.766 3.036-38.967 63.054-56.043 126.275-111.871 189.451-167.783 84.194-74.536 168.471-148.983 252.627-223.647 38.187-33.85 75.366-33.85 113.639 0.257 45.235 40.298 90.597 80.43 135.91 120.598 2.151 1.897 4.418 3.657 8.954 7.402z m0 0" p-id="2074"></path></svg>
					</li>
					<li data-url="goods.php">
						<svg viewBox="0 0 1152 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M294.656 925.312a68.032 68.032 0 1 0 136.064 0 68.032 68.032 0 1 0-136.064 0zM816 925.312a68.032 68.032 0 1 0 136.064 0 68.032 68.032 0 1 0-136.064 0zM248.128 166.016h872.768l-76.288 457.344a160 160 0 0 1-157.824 133.76H353.472a64 64 0 0 1-61.888-47.68l-148.48-562.176a12.8 12.8 0 0 0-12.416-9.536H12.992V40.96h192.512a12.8 12.8 0 0 1 12.416 9.536l30.208 115.52z m205.184 360.64H882.24a32 32 0 1 0 0-64H453.312a32 32 0 1 0 0 64z m0-136h317.376a32 32 0 0 0 0-64H453.312a32 32 0 1 0 0 64z" p-id="34115"></path></svg>
					</li>
					<li data-url="textures.php">
						<svg viewBox="0 0 1228 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M935.004926 0.00061h-70.225859a63.07815 63.07815 0 0 0-48.48556 22.397201c-35.973158 42.933181-138.856388 70.741996-203.670634 70.741996s-167.666195-27.808815-203.639353-70.741996a63.297117 63.297117 0 0 0-48.48556-22.397201h-70.382265a63.609927 63.609927 0 0 0-45.592067 19.237819L11.261162 256.489223a39.445349 39.445349 0 0 0 0 55.195336l142.32858 144.784139a37.850018 37.850018 0 0 0 54.272547 0l4.692151-4.692151a8.0705 8.0705 0 0 1 13.826204 5.802627V962.204372c0 32.845057 26.088359 59.433912 58.354718 59.433912h655.649898c32.266358 0 58.354718-26.588856 58.354717-59.433912V457.45405a8.054859 8.054859 0 0 1 13.841846-5.802627l4.692151 4.692151a37.850018 37.850018 0 0 0 54.272546 0l142.32858-144.768498a39.445349 39.445349 0 0 0 0-55.195336L980.659555 19.113305A64.126063 64.126063 0 0 0 935.004926 0.00061z" p-id="4696"></path></svg>
					</li>
					<li if(var.mc_user.admin,==,true) data-url="users.php">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M619.064182 504.57971c91.163561-42.401656 154.766046-133.565217 154.766046-239.569358C773.830228 118.724638 655.10559 0 508.819876 0S243.809524 118.724638 243.809524 265.010352c0 106.004141 63.602484 197.167702 154.766045 239.569358C169.606625 555.461698 0 758.989648 0 1002.799172v21.200828h1017.639752v-21.200828c0-243.809524-169.606625-447.337474-398.57557-498.219462z" p-id="34716"></path></svg>
					</li>
					<li if(var.mc_user.admin,==,true) data-url="config.php?{echo:token}">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M950.857143 402.285714h-51.748572a403.2 403.2 0 0 0-36.571428-86.308571l36.571428-36.571429a73.142857 73.142857 0 0 0 0-103.314285l-51.017142-51.931429a73.142857 73.142857 0 0 0-103.314286 0l-36.571429 36.571429A393.691429 393.691429 0 0 0 621.714286 125.074286V73.142857a73.142857 73.142857 0 0 0-73.142857-73.142857h-73.142858a73.142857 73.142857 0 0 0-73.142857 73.142857v51.931429a393.691429 393.691429 0 0 0-86.308571 35.657143l-36.571429-36.571429a73.142857 73.142857 0 0 0-103.314285 0L124.16 175.908571a73.142857 73.142857 0 0 0 0 103.314286l36.571429 36.571429a403.2 403.2 0 0 0-36.571429 86.308571H73.142857a73.142857 73.142857 0 0 0-73.142857 73.142857v73.142857a73.142857 73.142857 0 0 0 73.142857 73.142858h51.748572a403.2 403.2 0 0 0 36.571428 86.308571l-36.571428 36.571429a73.142857 73.142857 0 0 0 0 103.314285l51.748571 51.748572a73.142857 73.142857 0 0 0 103.314286 0l36.571428-36.571429A393.691429 393.691429 0 0 0 402.285714 898.925714V950.857143a73.142857 73.142857 0 0 0 73.142857 73.142857h73.142858a73.142857 73.142857 0 0 0 73.142857-73.142857v-51.931429a393.691429 393.691429 0 0 0 86.308571-35.657143l36.571429 36.571429a73.142857 73.142857 0 0 0 103.314285 0l51.748572-51.748571a73.142857 73.142857 0 0 0 0-103.314286l-36.571429-36.571429a403.2 403.2 0 0 0 36.571429-86.308571H950.857143a73.142857 73.142857 0 0 0 73.142857-73.142857V475.428571a73.142857 73.142857 0 0 0-73.142857-73.142857zM617.142857 613.668571a146.285714 146.285714 0 1 1-3.474286-206.811428 146.285714 146.285714 0 0 1 3.474286 206.811428z" fill="#333333" p-id="25750"></path></svg>
					</li>
					<li data-url="console.php">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M944.38 70.19h-864c-44.19 0-80 35.81-80 80v571.43c0 44.19 35.81 80 80 80h864c44.18 0 80-35.81 80-80V150.19c0-44.19-35.82-80-80-80z m5.45 603.45c0 26.26-21.29 47.55-47.55 47.55H750.12V445.41c0-26.26-21.28-47.55-47.55-47.55-26.26 0-47.55 21.29-47.55 47.55v275.78h-95.1V350.31c0-26.26-21.28-47.55-47.55-47.55-26.26 0-47.55 21.29-47.55 47.55v370.88h-95.1v-199.7c0-26.26-21.28-47.55-47.55-47.55-26.26 0-47.55 21.28-47.55 47.55v199.7H122.49c-26.26 0-47.55-21.29-47.55-47.55V198.16c0-26.26 21.29-47.55 47.55-47.55h779.79c26.26 0 47.55 21.29 47.55 47.55v475.48zM722.67 874.76H302.09c-25.25 0-45.71 20.47-45.71 45.71 0 25.25 20.47 45.71 45.71 45.71h420.58c25.24 0 45.71-20.46 45.71-45.71 0-25.24-20.47-45.71-45.71-45.71z m0 0" fill="#333333" p-id="1430"></path></svg>
					</li>
					<li onclick="OpenAPI('https://space.bilibili.com/25792030')">
						<svg viewBox="0 0 1129 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M234.909 9.656a80.468 80.468 0 0 1 68.398 0 167.374 167.374 0 0 1 41.843 30.578l160.937 140.82h115.07l160.936-140.82a168.983 168.983 0 0 1 41.843-30.578A80.468 80.468 0 0 1 930.96 76.445a80.468 80.468 0 0 1-17.703 53.914 449.818 449.818 0 0 1-35.406 32.187 232.553 232.553 0 0 1-22.531 18.508h100.585a170.593 170.593 0 0 1 118.289 53.109 171.397 171.397 0 0 1 53.914 118.288v462.693a325.897 325.897 0 0 1-4.024 70.007 178.64 178.64 0 0 1-80.468 112.656 173.007 173.007 0 0 1-92.539 25.75h-738.7a341.186 341.186 0 0 1-72.421-4.024A177.835 177.835 0 0 1 28.91 939.065a172.202 172.202 0 0 1-27.36-92.539V388.662a360.498 360.498 0 0 1 0-66.789A177.03 177.03 0 0 1 162.487 178.64h105.414c-16.899-12.07-31.383-26.555-46.672-39.43a80.468 80.468 0 0 1-25.75-65.984 80.468 80.468 0 0 1 39.43-63.57M216.4 321.873a80.468 80.468 0 0 0-63.57 57.937 108.632 108.632 0 0 0 0 30.578v380.615a80.468 80.468 0 0 0 55.523 80.469 106.218 106.218 0 0 0 34.601 5.632h654.208a80.468 80.468 0 0 0 76.444-47.476 112.656 112.656 0 0 0 8.047-53.109v-354.06a135.187 135.187 0 0 0 0-38.625 80.468 80.468 0 0 0-52.304-54.719 129.554 129.554 0 0 0-49.89-7.242H254.22a268.764 268.764 0 0 0-37.82 0z m0 0" fill="#20B0E3" p-id="10041"></path><path d="M348.369 447.404a80.468 80.468 0 0 1 55.523 18.507 80.468 80.468 0 0 1 28.164 59.547v80.468a80.468 80.468 0 0 1-16.094 51.5 80.468 80.468 0 0 1-131.968-9.656 104.609 104.609 0 0 1-10.46-54.719v-80.468a80.468 80.468 0 0 1 70.007-67.593z m416.02 0a80.468 80.468 0 0 1 86.102 75.64v80.468a94.148 94.148 0 0 1-12.07 53.11 80.468 80.468 0 0 1-132.773 0 95.757 95.757 0 0 1-12.875-57.133V519.02a80.468 80.468 0 0 1 70.007-70.812z m0 0" fill="#20B0E3" p-id="10042"></path></svg>
					</li>
				</ul>
				<div class="LogOut">
					<a href="javascript:LogOut()">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M512 453c-24.9 0-45-20.1-45-45V46.3c0-24.9 20.1-45 45-45s45 20.1 45 45V408c0 24.9-20.1 45-45 45zM512 1024c-65.6 0-129.2-12.9-189.2-38.2-57.9-24.5-109.8-59.5-154.5-104.1-44.6-44.7-79.6-96.6-104.1-154.5C38.9 667.2 26 603.6 26 538c0-85.6 22.6-169.8 65.3-243.4 41.4-71.4 100.7-131.6 171.6-174 21.3-12.8 49-5.8 61.7 15.5s5.8 49-15.5 61.7c-57.8 34.6-106.2 83.6-139.9 141.8C134.4 399.7 116 468.2 116 538c0 105.8 41.2 205.2 116 280 74.8 74.8 174.2 116 280 116s205.2-41.2 280-116c74.8-74.8 116-174.2 116-280 0-69.8-18.4-138.3-53.1-198.3-33.8-58.2-82.2-107.3-139.9-141.8-21.3-12.8-28.3-40.4-15.5-61.7s40.4-28.3 61.7-15.5c70.9 42.4 130.2 102.5 171.6 174C975.4 368.2 998 452.4 998 538c0 65.6-12.9 129.2-38.2 189.2-24.5 57.9-59.5 109.8-104.1 154.5-44.6 44.6-96.6 79.7-154.5 104.1-60 25.3-123.6 38.2-189.2 38.2z" p-id="19281"></path></svg>
					</a>
				</div>
			</div>
			<div class="content">
				<iframe id="tab"></iframe>
				<div id="tab-loading"><span class="loading"></span></div>
			</div>
		</main>
		<script>
			document.querySelectorAll(".menu ul li[data-url]").forEach(function(item) {
				item.addEventListener("click", function() {
					document.getElementById("tab-loading").style.display = "block";
					document.getElementById("tab").style.display = "none";
					document.getElementById("tab").src = this.getAttribute("data-url");
					document.querySelectorAll(".menu ul li[data-url]").forEach(function(item) {
						item.classList.remove("select");
					});
					
					this.classList.add("select");
				});
			});
			document.querySelector(".menu ul li:nth-child(1)").click();
			document.querySelector("#tab").onload = function() {
				document.getElementById("tab-loading").style.display = "none";
				document.getElementById("tab").style.display = "block";
			};
			
			
			
			
			
			
			window.addEventListener("mc_state", function(e) {
				var startButton = document.querySelector(".start");
				
				switch (e.detail) {
					case 0:
						startButton.innerHTML = '启动游戏';
						break;
					case 1:
						startButton.innerHTML = '启动中';
						break;
					case 2:
						startButton.innerHTML = '关闭游戏';
						break;
					default:
						break;
				}
			});
			
			
			function LogOut()
			{
				document.cookie = 'login_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
				login();
			}
		</script>
	</body>
</html>