<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_user');
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<style>
			body {
				margin: 0;
				padding: 0;
				overflow: hidden;
			}
			header {
				width: 100%;
				user-select: none;
			}
			header .operate {
				display: flex;
				gap: 5px;
				-webkit-app-region: drag;
			}
			header .operate .user {
				display: flex;
				gap: 5px;
				width: calc(100% - 435px);
				height: 45px;
			}
			header .operate .user img {
				width:  100%;
				height: 100%;
			}
			header .operate .user #avatar {
				overflow: hidden;
				width:  45px;
				height: 45px;
				border-radius: 5px;
				background-color: #FFFFE0;
			}
			header .operate .user #name {
				padding: 0 8px;
				text-overflow: ellipsis;
				white-space: nowrap;
				overflow: hidden;
				font-size: 20px;
				font-family: "FangSong";
				line-height: 45px;
				color: #000000;
				width: 100%;
				height: 45px;
				border-radius: 5px;
				background-color: #FFFFE0;
			}
			header .operate .checkin {
				display: flex;
				gap: 5px;
				height: 45px;
				overflow: hidden;
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
				font-size: 20px;
				font-family: "Impact";
				color: #000000;
				line-height: 47px;
				width: 150px;
				height: 45px;
			}
			header .operate .checkin .button {
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
			header .operate .start span:nth-of-type(2) {
				display: none;
			}
			main {
				display: flex;
				height: 100vh;
			}
			main .menu {
				display: flex;
				flex-direction: column;
				justify-content: space-between;
				width: 60px;
				height: 100vh;
				background-color: #393939;
				text-align: center;
				user-select: none;
				-webkit-app-region: drag;
			}
			main .menu .select {
				background-color: rgba(120,120,120,0.4);
				border-radius: 10px;
			}
			main .menu .select svg path {
				fill: #9393ff;
			}
			main .menu ul {
				display: flex;
				gap: 10px;
				align-items: center;
				flex-direction: column;
				list-style-type: none;
				margin: 0;
				padding: 0;
				padding-top: 30px;
			}
			main .menu ul li {
				width: 25px;
				height: 25px;
				transition: background-color 0.3s ease;
				border-radius: 10px;
				cursor: pointer;
				padding: 8px;
				-webkit-app-region: no-drag;
			}
			main .menu ul li svg {
				width: 	100%;
				height: 100%;
			}
			main .menu ul li svg path {
				fill: #afeeee;
			}
			main .menu ul.iframe-nav li:hover {
				background-color: rgba(120,120,120,0.4);
			}
			main .menu ul.browser-nav {
				margin-bottom: 10px;
			}
			main .menu ul.browser-nav li:hover svg path {
				transition: fill 0.3s ease;
				fill: #9393ff;
			}
			main .content {
				display: flex;
				gap: 8px;
				flex-direction: column;
				width: 100%;
				height: 100%;
				padding: 10px;
				padding-top: 30px;
				box-sizing: border-box;
				background: radial-gradient(#333,#333);
			}
			main .content #tab {
				border: none;
				width:  100%;
				height: calc(100% - 0px);
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
		<includes-header><?php include('includes/window-header.html') ?></includes-header>
		<includes-dialog><?php include('includes/dialog.html') ?></includes-dialog>
		
		<section>
			<main>
				<div class="menu">
					<ul class="iframe-nav">
						<li data-url="home.php">
							<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M592.795 942.076v-255.69H432.057v256.373c-5.023 0.259-9.03 0.647-13.039 0.647-75.894 0-151.828 0.041-227.727 0-26.08 0-43.618-16.728-43.733-44.43-0.527-105.2-0.367-210.487 0.116-315.687 0-5.548 4.214-12.642 8.466-16.429 68.687-60.686 137.734-120.984 206.665-181.33 45.884-40.168 91.73-80.34 137.612-120.467 3.565-3.098 7.213-6.106 11.704-9.94 27.377 23.917 54.633 47.7 81.849 71.527 89.783 78.58 179.449 157.332 269.476 235.612 9.68 8.384 13.81 16.899 13.728 30.446-0.566 99.872-0.406 199.778-0.2 299.603 0.037 18.152-4.215 33.937-19.322 43.959-5.467 3.649-12.392 6.794-18.668 6.836-80.551 0.43-161.103 0.21-241.61 0.17-1.174 0.002-2.395-0.558-4.579-1.2z m120.97-707.89c0-42.193-0.04-81.159 0-120.085 0.037-24.858 5.626-30.794 28.995-30.836 36.287 0 72.574-0.04 108.861 0.042 18.711 0.047 25.187 7.053 25.23 28.086 0.085 83.307 0.283 166.664-0.244 249.971-0.082 12.86 3.322 21.115 12.834 29.287 39.775 33.98 78.772 68.901 117.975 103.61 19.233 17.034 19.721 25.33 3.521 45.591-9.797 12.3-19.393 24.817-29.278 37.076-12.148 15.178-22.194 16.126-36.73 3.221-139.193-123.352-278.386-246.788-417.622-370.18-4.82-4.258-9.759-8.433-15.392-13.338-31.303 27.703-62.366 55.1-93.348 82.58-112.988 100.13-225.979 200.296-338.97 300.42-15.308 13.59-24.821 12.777-37.7-3.225a4194.073 4194.073 0 0 1-31.75-40.08c-12.232-15.657-11.744-25.766 3.036-38.967 63.054-56.043 126.275-111.871 189.451-167.783 84.194-74.536 168.471-148.983 252.627-223.647 38.187-33.85 75.366-33.85 113.639 0.257 45.235 40.298 90.597 80.43 135.91 120.598 2.151 1.897 4.418 3.657 8.954 7.402z m0 0"></path></svg>
						</li>
						<li data-url="goods.php">
							<svg viewBox="0 0 1152 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M294.656 925.312a68.032 68.032 0 1 0 136.064 0 68.032 68.032 0 1 0-136.064 0zM816 925.312a68.032 68.032 0 1 0 136.064 0 68.032 68.032 0 1 0-136.064 0zM248.128 166.016h872.768l-76.288 457.344a160 160 0 0 1-157.824 133.76H353.472a64 64 0 0 1-61.888-47.68l-148.48-562.176a12.8 12.8 0 0 0-12.416-9.536H12.992V40.96h192.512a12.8 12.8 0 0 1 12.416 9.536l30.208 115.52z m205.184 360.64H882.24a32 32 0 1 0 0-64H453.312a32 32 0 1 0 0 64z m0-136h317.376a32 32 0 0 0 0-64H453.312a32 32 0 1 0 0 64z"></path></svg>
						</li>
						<li data-url="capes.php">
							<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M512 64a128 128 0 0 1 84.672 224h54.336a128 128 0 0 1 117.952 78.336L992 896l-162.88-46.528a128 128 0 0 0-112 20.672L588.8 966.4a128 128 0 0 1-153.6 0l-128.32-96.256a128 128 0 0 0-112-20.672L32 896l223.04-529.664A128 128 0 0 1 372.992 288h54.336A128 128 0 0 1 512 64z" fill="#040404"></path></svg>
						</li>
						<li data-url="textures.php">
							<svg viewBox="0 0 1228 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M935.004926 0.00061h-70.225859a63.07815 63.07815 0 0 0-48.48556 22.397201c-35.973158 42.933181-138.856388 70.741996-203.670634 70.741996s-167.666195-27.808815-203.639353-70.741996a63.297117 63.297117 0 0 0-48.48556-22.397201h-70.382265a63.609927 63.609927 0 0 0-45.592067 19.237819L11.261162 256.489223a39.445349 39.445349 0 0 0 0 55.195336l142.32858 144.784139a37.850018 37.850018 0 0 0 54.272547 0l4.692151-4.692151a8.0705 8.0705 0 0 1 13.826204 5.802627V962.204372c0 32.845057 26.088359 59.433912 58.354718 59.433912h655.649898c32.266358 0 58.354718-26.588856 58.354717-59.433912V457.45405a8.054859 8.054859 0 0 1 13.841846-5.802627l4.692151 4.692151a37.850018 37.850018 0 0 0 54.272546 0l142.32858-144.768498a39.445349 39.445349 0 0 0 0-55.195336L980.659555 19.113305A64.126063 64.126063 0 0 0 935.004926 0.00061z"></path></svg>
						</li>
					</ul>
					
					<ul class="browser-nav">
						<li if(var.mc_user.admin,==,true)>
							<a href="users.php">
								<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M619.064182 504.57971c91.163561-42.401656 154.766046-133.565217 154.766046-239.569358C773.830228 118.724638 655.10559 0 508.819876 0S243.809524 118.724638 243.809524 265.010352c0 106.004141 63.602484 197.167702 154.766045 239.569358C169.606625 555.461698 0 758.989648 0 1002.799172v21.200828h1017.639752v-21.200828c0-243.809524-169.606625-447.337474-398.57557-498.219462z"></path></svg>
							</a>
						</li>
						<li if(var.mc_user.admin,==,true)>
							<a href="config.php">
								<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M950.857143 402.285714h-51.748572a403.2 403.2 0 0 0-36.571428-86.308571l36.571428-36.571429a73.142857 73.142857 0 0 0 0-103.314285l-51.017142-51.931429a73.142857 73.142857 0 0 0-103.314286 0l-36.571429 36.571429A393.691429 393.691429 0 0 0 621.714286 125.074286V73.142857a73.142857 73.142857 0 0 0-73.142857-73.142857h-73.142858a73.142857 73.142857 0 0 0-73.142857 73.142857v51.931429a393.691429 393.691429 0 0 0-86.308571 35.657143l-36.571429-36.571429a73.142857 73.142857 0 0 0-103.314285 0L124.16 175.908571a73.142857 73.142857 0 0 0 0 103.314286l36.571429 36.571429a403.2 403.2 0 0 0-36.571429 86.308571H73.142857a73.142857 73.142857 0 0 0-73.142857 73.142857v73.142857a73.142857 73.142857 0 0 0 73.142857 73.142858h51.748572a403.2 403.2 0 0 0 36.571428 86.308571l-36.571428 36.571429a73.142857 73.142857 0 0 0 0 103.314285l51.748571 51.748572a73.142857 73.142857 0 0 0 103.314286 0l36.571428-36.571429A393.691429 393.691429 0 0 0 402.285714 898.925714V950.857143a73.142857 73.142857 0 0 0 73.142857 73.142857h73.142858a73.142857 73.142857 0 0 0 73.142857-73.142857v-51.931429a393.691429 393.691429 0 0 0 86.308571-35.657143l36.571429 36.571429a73.142857 73.142857 0 0 0 103.314285 0l51.748572-51.748571a73.142857 73.142857 0 0 0 0-103.314286l-36.571429-36.571429a403.2 403.2 0 0 0 36.571429-86.308571H950.857143a73.142857 73.142857 0 0 0 73.142857-73.142857V475.428571a73.142857 73.142857 0 0 0-73.142857-73.142857zM617.142857 613.668571a146.285714 146.285714 0 1 1-3.474286-206.811428 146.285714 146.285714 0 0 1 3.474286 206.811428z" fill="#333333"></path></svg>
							</a>
						</li>
						<li if(var.mc_user.admin,==,true)>
							<a href="file_manager.php">
								<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M914.304 1024H109.696A109.696 109.696 0 0 1 0 914.304V109.696C0 49.088 49.088 0 109.696 0H327.68C394.88 0 471.04 109.696 545.664 109.696h368.64c60.544 0 109.696 49.152 109.696 109.76v694.848c0 60.608-49.152 109.696-109.696 109.696z m-54.848-694.848H164.48a54.848 54.848 0 1 0 0 109.696H859.52a54.848 54.848 0 0 0 0-109.696z"></path></svg>
							</a>
						</li>
						<li if(var.mc_user.admin,==,true)>
							<a href="console.php">
								<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M944.38 70.19h-864c-44.19 0-80 35.81-80 80v571.43c0 44.19 35.81 80 80 80h864c44.18 0 80-35.81 80-80V150.19c0-44.19-35.82-80-80-80z m5.45 603.45c0 26.26-21.29 47.55-47.55 47.55H750.12V445.41c0-26.26-21.28-47.55-47.55-47.55-26.26 0-47.55 21.29-47.55 47.55v275.78h-95.1V350.31c0-26.26-21.28-47.55-47.55-47.55-26.26 0-47.55 21.29-47.55 47.55v370.88h-95.1v-199.7c0-26.26-21.28-47.55-47.55-47.55-26.26 0-47.55 21.28-47.55 47.55v199.7H122.49c-26.26 0-47.55-21.29-47.55-47.55V198.16c0-26.26 21.29-47.55 47.55-47.55h779.79c26.26 0 47.55 21.29 47.55 47.55v475.48zM722.67 874.76H302.09c-25.25 0-45.71 20.47-45.71 45.71 0 25.25 20.47 45.71 45.71 45.71h420.58c25.24 0 45.71-20.46 45.71-45.71 0-25.24-20.47-45.71-45.71-45.71z m0 0" fill="#333333"></path></svg>
							</a>
						</li>
						<li>
							<a href="change-password.php">
								<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="4782"><path d="M884.363636 325.818182a93.090909 93.090909 0 0 1 93.090909 93.090909v512a93.090909 93.090909 0 0 1-93.090909 93.090909H139.636364a93.090909 93.090909 0 0 1-93.090909-93.090909V418.909091a93.090909 93.090909 0 0 1 93.090909-93.090909h744.727272z m-372.363636 186.181818a93.090909 93.090909 0 0 0-46.545455 173.707636V791.272727a46.545455 46.545455 0 0 0 93.09091 0l0.046545-105.565091A93.090909 93.090909 0 0 0 512 512z" fill="#008DF0" p-id="4783"></path><path d="M512 0c175.197091 0 319.534545 127.627636 325.632 289.373091l0.186182 10.565818V372.363636h-93.090909V299.938909C744.727273 186.786909 641.489455 93.090909 512 93.090909 386.094545 93.090909 285.044364 181.620364 279.505455 290.583273L279.272727 299.938909V372.363636H186.181818V299.938909C186.181818 133.213091 333.032727 0 512 0z" fill="#008DF0" p-id="4784"></path></svg>
							</a>
						</li>
						<li>
							<a href="javascript:logout()">
								<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M804.341617 0.438732H219.512139C98.860897 0.438732 0.146244 99.153385 0.146244 219.804627v584.829478c0 120.651243 98.714653 219.365895 219.365895 219.365895H804.341617c120.651243 0 219.365895-98.714653 219.365895-219.365895V219.804627c0-120.651243-98.714653-219.365895-219.365895-219.365895zM474.854042 264.262782c0-9.652099 3.217366-19.157955 12.723222-28.810054 7.45844-8.043416 17.841759-12.576978 28.810054-12.723222 9.652099 0 19.157955 3.217366 25.592688 12.723222 8.043416 7.45844 12.576978 17.841759 12.723222 28.810054v230.33419c0 9.505855-3.217366 19.157955-12.723222 25.592688-6.434733 6.434733-15.940588 12.723222-25.592688 12.723222s-19.304199-3.217366-28.810054-12.723222c-6.434733-6.434733-12.723222-15.940588-12.723222-25.592688V264.262782z m287.954298 371.020851c-12.869466 32.027421-35.244787 60.691231-57.620108 86.283919-25.592688 25.592688-54.402742 44.896887-86.283919 57.620109-32.027421 12.723222-67.272208 22.375321-105.588118 22.375321s-73.560697-6.434733-105.588117-22.375321c-31.149957-15.501857-60.106255-34.806055-86.283919-57.620109-24.861468-24.422736-44.458155-53.96401-57.620109-86.283919-12.869466-32.027421-22.375321-67.272208-22.375321-105.588117 0-22.375321 3.217366-44.750643 6.434733-63.908598 6.434733-22.375321 12.723222-41.67952 22.375321-60.691231 9.652099-19.157955 22.375321-35.098543 35.244787-54.402742 13.600686-17.256784 29.833762-32.319909 47.96801-44.750643 9.652099-6.434733 19.157955-9.652099 28.810054-6.434733 9.652099 3.217366 19.304199 6.434733 25.592688 15.940589 6.434733 9.652099 9.652099 19.304199 6.434733 28.810054-3.217366 9.652099-6.434733 19.157955-15.940589 25.592688-25.592688 19.157955-47.968009 41.67952-60.691231 70.34333-12.723222 28.810054-22.375321 57.620109-22.375321 89.647529 0 25.592688 6.434733 51.185376 15.940588 76.778064 9.652099 25.592688 25.592688 44.896887 41.67952 60.837475 17.403028 17.695516 38.023422 31.881177 60.691231 41.67952 24.276492 10.529563 50.307912 15.940588 76.778064 15.940588 25.592688 0 51.185376-6.434733 76.778063-15.940588 25.592688-9.652099 44.896887-25.592688 60.691231-41.67952 17.695516-17.403028 31.881177-38.023422 41.67952-60.837475 10.529563-24.276492 15.940588-50.307912 15.940589-76.778064 0-32.027421-6.434733-60.691231-19.157955-86.283918s-32.027421-51.185376-57.620109-67.272208c-9.652099-6.434733-12.723222-15.940588-15.940588-25.592688-3.217366-9.652099 0-19.157955 6.434733-28.810054s15.940588-12.723222 25.592688-15.940589c9.652099-3.217366 19.157955 0 28.810054 6.434733 15.940588 12.723222 32.027421 28.810054 44.896887 44.896887 12.723222 15.940588 25.592688 35.244787 35.098543 51.185375 9.652099 19.157955 15.940588 38.31591 22.375321 57.620109s6.434733 41.67952 6.434733 63.908597c2.632391 38.169666-3.656098 73.268209-19.596687 105.29563z" fill="#FF452C"></path></svg>
							</a>
						</li>
					</ul>
				</div>
				<div class="content">
					<iframe id="tab"></iframe>
					<div id="tab-loading"><span class="loading"></span></div>
				</div>
			</main>
		</section>
		
		
		<script>
			function logout() {
				showConfirm('确认要退出登陆吗？', (result) => {
					if (result) {
						document.cookie = 'login_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
						window.location.replace('login.php');
					}
				});
			}
			
			document.querySelectorAll(".menu ul.iframe-nav li[data-url]").forEach(function(item) {
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
		</script>
	</body>
</html>