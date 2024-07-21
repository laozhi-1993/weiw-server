<?php include_once('weiw/index.php');
	
	
    $MKH = new mkh(__FILE__);
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta name="theme-color" content="#2C3E50" />
		<meta name="author" content="laozhi" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="utf-8" />
		<style>
			body {
				margin:  0;
				padding: 0;
			}
			header {
				height: 80px;
				background-color: #2C3E50;
			}
			header .position {
				position: relative;
				top: 0;
				margin: auto;
				max-width: 1300px;
			}
			header .position .zuo {
				margin: 0 30px;
				color: #FFFFFF;
				line-height: 80px;
				font-size: 35px;
				font-weight: bolder;
			}
			header .position .you {
				margin: 0 15px;
				padding: 15px 0;
				position: absolute;
				top: 0;
				right: 0;
				color: #FFFFFF;
				font-size: 15px;
				line-height: 50px;
			}
			header .position .you a {
				display: inline-block;
				color: inherit;
				text-decoration-line: none;
				padding: 0 15px;
			}
			header .position .you a:hover {
				border-radius: 5px;
				background-color: #1ABC9C;
			}
			header .position .you a svg {
				width:  20px;
				height: 20px;
				margin-top: 16px;
				vertical-align: top;
			}
			header .position .you a path {
				fill: #FFFFFF;
			}
			
			
			main .download {
				background-color: #1ABC9C;
				text-align: center;
				padding: 90px 0;
			}
			main .download .Icon {
				margin: auto;
				width: 256px;
				height: 256px;
			}
			main .download .Icon img {
				width: 100%;
				height: 100%;
			}
			main .download .txt {
				margin: 20px 0 50px 0;
				font-size: 50px;
				font-weight: bolder;
				color: #FFFFFF;
			}
			main .download .link:hover {
				background-color: #FFFFFF;
				color: #000000;
			}
			main .download .link:hover path {
				fill: #000000;
			}
			main .download .link {
				margin: 20px 0;
				display: inline-block;
				line-height: 60px;
				font-size: 20px;
				color: #FFFFFF;
				border: 2px solid #FFFFFF;
				border-radius: 5px;
			}
			main .download .link a {
				display: inline-block;
				padding: 0 50px;
				color: inherit;
				text-decoration-line: none;
			}
			main .download .link svg {
				width:  28px;
				height: 28px;
				margin-top: 18px;
				vertical-align: top;
			}
			main .download .link svg path {
				fill: #FFFFFF;
			}
			main .introduce {
				margin: 80px;
			}
			main .introduce .image {
				max-width: 1300px;
				margin: 0 auto;
			}
			main .introduce .image img {
				border-radius: 10px;
				width: 100%;
				display: block;
			}
			
			
			footer .information {
				border-top: 1px solid #1A252F;
				border-bottom: 1px solid #1A252F;
				background-color: #2C3E50;
				min-height: 200px;
			}
			footer .information p {
				margin: 5px 0;
			}
			footer .information a {
				color: #FFFFFF;
				display: inline-block;
				text-decoration-line: none;
			}
			footer .information a:hover {
				color: #37e2dc;
			}
			footer .information .position {
				max-width: 1300px;
				margin: 30px auto;
				font-size: 0;
			}
			footer .information .position .container {
				margin: 50px 0;
				display: inline-block;
				vertical-align: top;
			}
			footer .information .position .container:nth-child(1) {
				width: 25%;
			}
			footer .information .position .container:nth-child(2) {
				width: 25%;
			}
			footer .information .position .container:nth-child(3) {
				width: 50%;
			}
			footer .information .position .container .label {
				font-size: 20px;
				font-weight: bolder;
				margin: 10px;
				padding: 10px;
				color: #FFFFFF;
				border-bottom: 1px solid #FFFFFF;
			}
			footer .information .position .container svg {
				width:  25px;
				height: 25px;
				margin-top: 2px;
				vertical-align: top;
			}
			footer .information .position .container path {
				fill: #FFFFFF;
			}
			footer .information .position .container .content {
				font-size: 15px;
				color: #FFFFFF;
				margin: 20px;
			}
			footer .statement {
				background-color: #1A252F;
				min-height: 50px;
				line-height: 50px;
				color: #FFFFFF;
				text-align: center;
			}
			footer .statement span {
				display: inline-block;
			}
			footer .statement a {
				color: #FFFFFF;
				display: inline-block;
				text-decoration-line: none;
			}
			footer .statement a:hover {
				color: #37e2dc;
			}
			footer .statement svg {
				width:  20px;
				height: 20px;
				margin-top: 15px;
				vertical-align: top;
			}
			footer .statement path {
				fill: #FFFFFF;
			}
			@media screen and (max-width: 800px){
				header .position .zuo {
					margin: 0 15px;
					font-size: 25px;
					font-weight: bolder;
				}
				header .position .you a {
					display: none;
				}
				header .position .you a:first-child {
					display: inline-block;
					font-size: 0;
					vertical-align: top;
					border-radius: 5px;
					background-color: #1ABC9C;
				}
				main .download .txt {
					display: none;
				}
				main .introduce {
					display: none;
				}
				main .introduce .image {
					margin: 10px;
				}
				main .introduce .image img {
					border-radius: 5px;
				}
				footer .information .position .container:nth-child(1) {
					width: auto;
					display: block;
				}
				footer .information .position .container:nth-child(2) {
					width: auto;
					display: block;
				}
				footer .information .position .container:nth-child(3) {
					width: auto;
					display: block;
				}
			}
		</style>
		<title>{echo:var.config.serverName}</title>
	</head>
	<body>
		<header>
			<div class="position">
				<div class="zuo">
					<span id="test">{echo:var.config.domain}</span>
				</div>
				<div class="you">
					<a href="{echo:var.config.download}">
						<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M828.975746 894.125047 190.189132 894.125047c-70.550823 0-127.753639-57.18542-127.753639-127.752616L62.435493 606.674243c0-17.634636 14.308891-31.933293 31.93227-31.933293l63.889099 0c17.634636 0 31.93227 14.298658 31.93227 31.933293l0 95.821369c0 35.282574 28.596292 63.877843 63.87682 63.877843L765.098927 766.373455c35.281551 0 63.87682-28.595268 63.87682-63.877843l0-95.821369c0-17.634636 14.298658-31.933293 31.943526-31.933293l63.877843 0c17.634636 0 31.933293 14.298658 31.933293 31.933293l0 159.699212C956.729385 836.939627 899.538849 894.125047 828.975746 894.125047L828.975746 894.125047zM249.938957 267.509636c12.921287-12.919241 33.884738-12.919241 46.807049 0l148.97087 148.971893L445.716876 94.89323c0-17.634636 14.300704-31.94762 31.933293-31.94762l63.875796 0c17.637706 0 31.945573 14.312984 31.945573 31.94762l0 321.588299 148.97087-148.971893c12.921287-12.919241 33.875528-12.919241 46.796816 0l46.814212 46.818305c12.921287 12.922311 12.921287 33.874505 0 46.807049L552.261471 624.930025c-1.140986 1.137916-21.664416 13.68365-42.315758 13.69286-20.87647 0.010233-41.878806-12.541641-43.020816-13.69286L203.121676 361.13499c-12.922311-12.933567-12.922311-33.884738 0-46.807049L249.938957 267.509636 249.938957 267.509636z"></path></svg>
						<span>下载客户端</span>
					</a>
				</div>
			</div>
		</header>
		<main>
			<div class="download">
				<div class="txt"><span>欢迎来到 {echo:var.config.serverName} 官方网站</span></div>
				<div class="Icon"><img src="favicon.ico" /></div>
				<div class="link"><a href="{echo:var.config.download}"><svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M828.975746 894.125047 190.189132 894.125047c-70.550823 0-127.753639-57.18542-127.753639-127.752616L62.435493 606.674243c0-17.634636 14.308891-31.933293 31.93227-31.933293l63.889099 0c17.634636 0 31.93227 14.298658 31.93227 31.933293l0 95.821369c0 35.282574 28.596292 63.877843 63.87682 63.877843L765.098927 766.373455c35.281551 0 63.87682-28.595268 63.87682-63.877843l0-95.821369c0-17.634636 14.298658-31.933293 31.943526-31.933293l63.877843 0c17.634636 0 31.933293 14.298658 31.933293 31.933293l0 159.699212C956.729385 836.939627 899.538849 894.125047 828.975746 894.125047L828.975746 894.125047zM249.938957 267.509636c12.921287-12.919241 33.884738-12.919241 46.807049 0l148.97087 148.971893L445.716876 94.89323c0-17.634636 14.300704-31.94762 31.933293-31.94762l63.875796 0c17.637706 0 31.945573 14.312984 31.945573 31.94762l0 321.588299 148.97087-148.971893c12.921287-12.919241 33.875528-12.919241 46.796816 0l46.814212 46.818305c12.921287 12.922311 12.921287 33.874505 0 46.807049L552.261471 624.930025c-1.140986 1.137916-21.664416 13.68365-42.315758 13.69286-20.87647 0.010233-41.878806-12.541641-43.020816-13.69286L203.121676 361.13499c-12.922311-12.933567-12.922311-33.884738 0-46.807049L249.938957 267.509636 249.938957 267.509636z"></path></svg> <span>下载客户端</span></a></div>
			</div>
			<div class="introduce">
				<div class="image">
					<img src="https://i.imgtg.com/2023/01/31/0Oi06.jpg" />
				</div>
			</div>
		</main>
		<footer>
			<div class="information">
				<div class="position">
					<div class="container">
						<div class="label">
							<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="11293"><path d="M442.6 959.4H204.4c-81.2 0-147.4-66-147.4-147.4V212c0-81.2 66-147.4 147.4-147.4h601.2c81.2 0 147.4 66 147.4 147.4v426c0 11-9 20-20 20s-20-9-20-20V212c0-59.2-48.2-107.4-107.4-107.4H204.4c-59.2 0-107.4 48.2-107.4 107.4v600c0 59.2 48.2 107.4 107.4 107.4h238.2c11 0 20 9 20 20s-9 20-20 20z" fill="#262435" p-id="11294"></path><path d="M805.6 959.4H409.2c-11 0-20-9-20-20s9-20 20-20h396.2c59.2 0 107.4-48.2 107.4-107.4V212c0-59.2-48.2-107.4-107.4-107.4H204.4c-59.2 0-107.4 48.2-107.4 107.4v426c0 11-9 20-20 20s-20-9-20-20V212c0-81.2 66-147.4 147.4-147.4h601.2c81.2 0 147.4 66 147.4 147.4v600c-0.2 81.2-66.2 147.4-147.4 147.4z" fill="#262435" p-id="11295"></path><path d="M306.8 860.8c-40.4 0-78.2-15.6-106.6-44-28.4-28.4-44-66.2-44-106.6 0-40.4 15.6-78.2 44-106.6l119.2-119.2c7.8-7.8 20.4-7.8 28.2 0s7.8 20.4 0 28.2L228.4 632c-20.8 20.8-32.2 48.6-32.2 78.2s11.4 57.4 32.2 78.2c20.8 20.8 48.6 32.2 78.2 32.2s57.4-11.4 78.2-32.2l174.4-174.4c43.2-43.2 43.2-113.4 0-156.6-16.6-16.6-37.8-27.4-61.2-31-11-1.6-18.4-11.8-16.8-22.8 1.6-11 11.8-18.4 22.8-16.8 31.8 5 60.6 19.6 83.4 42.2 28.4 28.4 44 66.2 44 106.6 0 40.4-15.6 78.2-44 106.6l-174.4 174.4c-28 28.6-66 44.2-106.2 44.2z" fill="#262435" p-id="11296"></path><path d="M508.6 637.2c-1 0-2 0-3-0.2-31.8-5-60.6-19.6-83.4-42.2-58.8-58.8-58.8-154.4 0-213.2l174.4-174.4c58.8-58.8 154.4-58.8 213.2 0 58.8 58.8 58.8 154.4 0 213.2l-119.2 119.2c-7.8 7.8-20.4 7.8-28.2 0-7.8-7.8-7.8-20.4 0-28.2l119.2-119.2c43.2-43.2 43.2-113.4 0-156.6-43.2-43.2-113.4-43.2-156.6 0L450.6 410c-43.2 43.2-43.2 113.4 0 156.6 16.6 16.6 37.8 27.4 61.2 31 11 1.6 18.4 11.8 16.8 22.8-1.6 9.6-10.2 16.8-20 16.8z" fill="#262435" p-id="11297"></path></svg>
							<span>友情链接</span>
						</div>
						<div class="content">
							<p><a href="https://minecraft.fandom.com/zh">Minecraft Wiki 中文百科</a></p>
							<p><a href="https://littleskin.cn">littleskin 皮肤站</a></p>
							<p><a href="https://github.com/laozhi-1993/weiw-server">GitHub</a></p>
							<p><a href="https://space.bilibili.com/25792030">开发作者</a></p>
						</div>
					</div>
					<div class="container">
						<div class="label">
							<svg viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M952.102 127.526H72.732c-38.388 0-69.794 31.661-69.794 70.349v615.613c0 38.688 31.405 70.348 69.794 70.348h879.37c38.389 0 69.794-31.66 69.794-70.348V197.875c0-38.688-31.404-70.349-69.794-70.349z m-42.77 58.572L527.792 513.66c-13.042 13.171-12.986 13.2-26.072 0L120.195 186.098h789.137z m55.23 607.079L718.767 529.648c-13.639-13.741-35.712-13.741-49.353 0-13.626 13.739-13.626 36.011 0 49.724l222.408 246.519H142.056l222.396-246.519c13.641-13.712 13.641-36.013 0-49.724-13.625-13.741-35.714-13.741-49.341 0L61.21 797.558V236.107l391.141 327.279c19.728 19.855 36.567 34.592 64.588 34.592 28.019 0 40.509-14.736 60.207-34.592l387.415-327.308v557.099z" fill="" p-id="4523"></path></svg>
							<span>联系方式</span>
						</div>
						<div class="content">
							<p><a href="https://jq.qq.com/?_wv=1027&k=XkM9T57r">QQ群：303485313</a></p>
						</div>
					</div>
					<div class="container">
						<div class="content">
							<p>欢迎来到我们的我的世界服务器！我们很高兴您能够加入我们的社区。我们的服务器为您提供了一个独特的游戏体验，并且拥有专门的启动器，使您可以轻松地加入游戏。</p>
							<p>在我们的服务器中，您可以与其他玩家一起建造，探险，以及探索各种各样的世界。您可以发掘您的创造力，与社区中的其他成员一起创建一些惊人的作品，或者探索一些全新的地方，找到隐藏的宝藏和未知的危险。</p>
							<p>我们希望您能够在我们的服务器上度过一段美好的时光，并期待着与您的到来。如果您需要帮助，请随时向我们的团队成员寻求帮助。再次欢迎您来到我们的我的世界服务器！</p>
						</div>
					</div>
				</div>
			</div>
			<div class="statement">
				<span>Copyright © {echo:var.config.serverName} 2023</span>
			</div>
		</footer>
	</body>
</html>