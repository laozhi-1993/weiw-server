<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");
	
	
    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_user');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<script src="js/jquery.min.js"></script>
		<script src="js/once.js"></script>
		<script src="js/login.js"></script>
		<style>
			body {
				margin: 0;
				padding: 0;
				height: 100vh;
				overflow: hidden;
				-webkit-app-region: drag;
			}
			main {
				padding: 50px;
				user-select: none;
			}
			main .login {
				-webkit-app-region: no-drag;
			}
			main .login h1 {
				font-size: 25px;
				text-align: center;
				color: #303030;
				padding: 15px 0;
			}
			main .login b {
				display: inline-block;
				color: #303030;
				margin-top: 10px;
			}
			main .login .error {
				color: #ff0000;
				padding-top: 10px;
				display: none;
			}
			main .login .error span {
				display: inline-block;
				line-height: 22px;
			}
			main .login .error svg {
				width:  22px;
				height: 22px;
				vertical-align: top;
			}
			main .login .error svg path {
				 fill: #ff0000;
			}
			main .login input {
				padding: 0 10px;
				font-size: 18px;
				text-align: center;
				color: #303030;
				width:  calc(100% - 20px);
				height: 45px;
				border-radius: 5px;
				border: none;
				background-color: rgba(255,255,255,0.8);
			}
			main .login input:focus ~ fieldset {
				border: 2px solid #7fff00;
			}
			main .login .button {
				background-color: #0c9cff;
				border-radius: 5px;
				margin: 30px auto;
				text-align: center;
				font-size: 15px;
				color: #FFFFFF;
				cursor: pointer;
				width: 180px;
				height: 40px;
				line-height: 40px;
			}
			main .login .button:hover {
				background-color: #1e90ff;
				color: #FFFFFF;
			}
			main .login_auto {
				padding-top: 10px;
				text-align: center;
			}
			main .login_auto .name {
				color: #303030;
				font-size: 20px;
			}
			main .login_auto img {
				width: 180px;
				height: 180px;
				border-radius: 15px;
				background-color: #FFFFFF;
			}
			main .login_auto .button {
				background-color: #0c9cff;
				border-radius: 5px;
				font-size: 15px;
				color: #FFFFFF;
				cursor: pointer;
				margin:  5px;
				width: 180px;
				height: 40px;
				line-height: 40px;
				display: inline-block;
				-webkit-app-region: no-drag;
			}
			main .login_auto .button:hover {
				background-color: #1e90ff;
				color: #FFFFFF;
			}
			
			
			.loading {
				display: none;
				position: relative;
				top: -18px;
				left: 0;
				color: #fff;
				font-size: 7px;
			}
			.loading,
			.loading:before,
			.loading:after {
				border-radius: 50%;
				width:  10px;
				height: 10px;
				animation-fill-mode: both;
				animation: loading 1.8s infinite ease-in-out;
			}
			.loading:before,
			.loading:after {
				content: '';
				position: absolute;
				top: 0;
			}
			.loading:before {
				left: -20px;
				animation-delay: -0.32s;
			}
			.loading:after {
				left: 20px;
				animation-delay: 0.16s;
			}
			@keyframes loading {
				0%, 80%, 100% { box-shadow: 0 2.5em 0 -1.3em }
				40% { box-shadow: 0 2.5em 0 0 }
			}
		</style>
		<title>登陆</title>
	</head>
	<body>
		<window-background>
			<style>
				window-background {
					position: fixed;
					top: 0;
					z-index: -99;
					width:  100%;
					height: 100%;
					font-family: -apple-system, BlinkMacSystemFont, sans-serif;
					animation: background 15s ease infinite;
					background: linear-gradient(315deg, rgba(101,0,94,1) 3%, rgba(60,132,206,1) 38%, rgba(48,238,226,1) 68%, rgba(255,25,25,1) 98%);
					background-size: 400% 400%;
					background-attachment: fixed;
				}
				window-background .wave {
					background: rgb(255 255 255 / 25%);
					border-radius: 1000% 1000% 0 0;
					position: fixed;
					width: 200%;
					height: 12em;
					animation: wave 10s -3s linear infinite;
					transform: translate3d(0, 0, 0);
					opacity: 0.8;
					bottom: 0;
					left: 0;
					z-index: -1;
				}
				window-background .wave:nth-of-type(2) {
					bottom: -1.25em;
					animation: wave 18s linear reverse infinite;
					opacity: 0.8;
				}
				window-background .wave:nth-of-type(3) {
					bottom: -2.5em;
					animation: wave 20s -1s reverse infinite;
					opacity: 0.9;
				}
				@keyframes background {
					0% {
						background-position: 0% 0%;
					}
					50% {
						background-position: 100% 100%;
					}
					100% {
						background-position: 0% 0%;
					}
				}
				@keyframes wave {
					2% {
						transform: translateX(1);
					}

					25% {
						transform: translateX(-25%);
					}

					50% {
						transform: translateX(-50%);
					}

					75% {
						transform: translateX(-25%);
					}

					100% {
						transform: translateX(1);
					}
				}
			</style>
			<div class="wave"></div>
			<div class="wave"></div>
			<div class="wave"></div>
		</window-background>
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
					fill: #000000;
				}
				window-header #minimize:hover {
					background-color: #dcdcdc;
				}
				window-header #minimize:hover svg path {
					fill: #FFFFFF;
				}
				window-header #maximize:hover {
					background-color: #dcdcdc;
				}
				window-header #maximize:hover svg path {
					fill: #FFFFFF;
				}
				window-header #restore:hover {
					background-color: #dcdcdc;
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
			<!--<div id="minimize"><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3730"><path d="M128 448h768v128H128z" p-id="3731"></path></svg></svg></div>-->
			<!--<div id="maximize"><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3389"><path d="M199.111111 256v512h625.777778v-512z m56.888889 455.111111v-341.333333h512v341.333333z" p-id="3390"></path></svg></div>-->
			<!--<div id="restore" ><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3132"><path d="M512 1255.489906M865.682191 310.085948l-554.675195 0c-14.634419 0-26.403358 11.973616-26.403358 26.710374L284.603638 423.681791l-92.309414 0c-14.634419 0-26.403358 11.973616-26.403358 26.710374l0 349.998001c0 14.634419 11.768939 26.505697 26.403358 26.505697l554.675195 0c14.634419 0 26.710374-11.871277 26.710374-26.505697L773.679792 713.30002l92.002399 0c14.634419 0 26.710374-11.871277 26.710374-26.505697l0-349.998001C892.392564 322.059564 880.31661 310.085948 865.682191 310.085948zM728.65081 781.86688 210.817509 781.86688 210.817509 468.710774l517.8333 0L728.65081 781.86688zM847.363582 668.271037l-73.68379 0L773.679792 450.392165c0-14.634419-12.075954-26.710374-26.710374-26.710374L329.530282 423.681791l0-68.56686 517.8333 0L847.363582 668.271037z" p-id="3133"></path></svg></div>-->
			<div id="close"   ><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1501"><path d="M557.311759 513.248864l265.280473-263.904314c12.54369-12.480043 12.607338-32.704421 0.127295-45.248112-12.512727-12.576374-32.704421-12.607338-45.248112-0.127295L512.127295 467.904421 249.088241 204.063755c-12.447359-12.480043-32.704421-12.54369-45.248112-0.063647-12.512727 12.480043-12.54369 32.735385-0.063647 45.280796l262.975407 263.775299-265.151458 263.744335c-12.54369 12.480043-12.607338 32.704421-0.127295 45.248112 6.239161 6.271845 14.463432 9.440452 22.687703 9.440452 8.160624 0 16.319527-3.103239 22.560409-9.311437l265.216826-263.807983 265.440452 266.240344c6.239161 6.271845 14.432469 9.407768 22.65674 9.407768 8.191587 0 16.352211-3.135923 22.591372-9.34412 12.512727-12.480043 12.54369-32.704421 0.063647-45.248112L557.311759 513.248864z" fill="#575B66" p-id="1502"></path></svg></div>
		</window-header>
		<main>
			<div if(![mc_user.id]): class="login">
				<h1>登录</h1>
				<input type="text" onfocus="$('main .error').hide()" placeholder="请输入您的邮箱地址" />
				<div class="error">
					<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M512 0C229.229 0 0 229.23 0 512s229.229 512 512 512c282.77 0 512-229.23 512-512S794.77 0 512 0z m0.001 855.246c-36.035 0-65.247-29.211-65.247-65.246s29.212-65.246 65.247-65.246c36.034 0 65.245 29.211 65.245 65.246s-29.211 65.246-65.245 65.246z m70.468-258.492c0 35.199-28.799 64-63.999 64h-12.94c-35.2 0-64-28.801-64-64v-364c0-35.2 28.8-64 64-64h12.939c35.2 0 63.999 28.8 63.999 64v364z" p-id="5192"></path></svg>
					<span></span>
				</div>
				<b>如首次登陆将自动完成注册。</b>
				<div class="button" onclick="mc_login()">
					<span>下一步</span>
					<span class="loading"></span>
				</div>
			</div>
			<div if( [mc_user.id]): class="login_auto">
				<div class="avatar">
					<img src="/weiw/index_auth.php/avatar?size=180&hash={Print:mc_user:SKIN:hash}" />
				</div>
				<div class="name">{Print:mc_user:name}</div>
				<div class="button" onclick="window.index()">登陆</div>
			</div>
		</main>
	</body>
</html>