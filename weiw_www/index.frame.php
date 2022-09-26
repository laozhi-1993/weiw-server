<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_user','index.php');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta name="theme-color" content="#21242B" />
		<meta name="author" content="laozhi" />
		<meta charset="utf-8" />
		<script src="/weiw/jquery.min.js"></script>
		<script>
			window.addEventListener("mc_state", function(e){
				if(e.detail === 0)
				{
					$(".start span").html("启动游戏");
				}
				if(e.detail === 1)
				{
					$(".start span").html("启动中");
				}
				if(e.detail === 2)
				{
					$(".start span").html("游戏以启动");
				}
			});
			window.addEventListener("mc_exit", function(){
				$(".start span").html("启动游戏");
			});
			window.addEventListener("mc_start", function(){
				$(".start span").html("启动中");
			});
			window.addEventListener("mc_success", function(){
				$(".start span").html("游戏以启动");
			});


			var href = window.location.href;
			var kaiguan = true;
			var datatext = true;
			
			function copyText() {//拷贝文本函数
				oInput = document.createElement('input');//创建一个input标签
				oInput.value = $('#show').text();//设置value属性
				document.body.appendChild(oInput);//挂载到body下面
				oInput.select(); // 选择对象
				document.execCommand("Copy"); // 执行浏览器复制命令
				oInput.className = 'oInput';
				oInput.style.display='none';
				tips('复制完成');
			}
			
			function data()
			{
				$.getJSON("/weiw/index.php?mods=mc_data&{echo:token}",function (result){
					$(".player_list").html('');
					$(".money").html(result.money);
					$(".current").html(result.user.current);
					$(".maximum").html(result.user.maximum);
					
					$.each(result.user.list,function (key,value){
						if(datatext) $(".player_list").append(datatext.replace(new RegExp("{name}",'g'),value));
					});
				});
				
				return data;
			}
			
			function caidan()
			{
				if(kaiguan)
				{
					kaiguan = false;
					$(".main .daohang").animate({left:'0'},200);
					$(".main .neirong").animate({left:'250'},200);
				}
				else
				{
					kaiguan = true;
					$(".main .daohang").animate({left:'-250px'},200);
					$(".main .neirong").animate({left:'0'},200);
				}
			}
			
			
			function tips(str)
			{
				if(str !== false)
				{
					$(".tips").fadeIn(100);
					$(".tips .position").animate({top:'35%'},200);
					$(".tips .position").animate({top:'30%'},100);
					$(".tips .position span").html(str);
				}
				else
				{
					$(".tips .position").css({top:'0'});
					$(".tips").hide();
				}
			}
			
			
			$(function (){
				datatext = $(".player_list").html();
				setInterval(data(),5000);
				
				
				if(href.search("goods.php") > 1){
					$("#xvanze_goods").addClass('xvanze');
				}else if(href.search("clothes.php") > 1){
					$("#xvanze_clothes").addClass('xvanze');
				}else if(href.search("users.php") > 1){
					$("#xvanze_users").addClass('xvanze');
				}else if(href.search("notice.php") > 1){
					$("#xvanze_notice").addClass('xvanze');
				}else if(href.search("config.php") > 1){
					$("#xvanze_config").addClass('xvanze');
				}else if(href.search("prop.php") > 1){
					$("#xvanze_prop").addClass('xvanze');
				}else if(href.search("console.php") > 1){
					$("#xvanze_console").addClass('xvanze');
				}else{
					$("#xvanze_home").addClass('xvanze');
				}
			});
		</script>
		<style>
			body {
				margin: 0;
				padding: 0;
				overflow: hidden;
			}
			.wei::-webkit-scrollbar {
				width:  5px;
				height: 5px;
			}
			.wei::-webkit-scrollbar-track {
				border-radius:    5px;
				background-color: #2a2a2a;
			}
			.wei::-webkit-scrollbar-thumb {
				border-radius:    5px;
				background-color: #cccccc;
			}
			.tips {
				position: fixed;
				top:   0;
				right: 0;
				z-index: 99;
				background-color: rgba(0,0,0,0.7);
				user-select: none;
				display: none;
				text-align: center;
				width:  100vw;
				height: 100vh;
			}
			.tips .position {
				position: relative;
				top:   0;
				right: 0;
				background-color: #FFFFFF;
				border: 1px solid #91B1D5;
				border-radius: 5px;
				box-shadow: 0 0 15px 0px #000000;
				display: inline-block;
				overflow: hidden;
				width: calc(100% - 40px);
				max-width: 400px;
				margin: 20px;
			}
			.tips span {
				padding: 40px 50px 80px 50px;
				display: inline-block;
				color: #202727;
			}
			.tips .position button {
				position: absolute;
				bottom: 0;
				right:  0;
				border: none;
				border-top: 1px solid #91B1D5;
				background-color: #FFFFFF;
				padding: 10px 0;
				cursor: pointer;
				color: #0066c8;
				font-size: medium;
				font-weight: bold;
				width: 100%;
			}
			.tips .position button:active {
				background-color: #91B1D5;
				color: #FFFFFF;
			}
			.main {
				position: absolute;
				top:  0;
				left: 0;
				overflow: hidden;
				width: 	100%;
				height: 100%;
			}
			.main .daohang {
				position: absolute;
				top:  0;
				left: 0;
				z-index: 90;
				user-select: none;
				width: 250px;
				height: 100%;
			}
			.main .daohang .tuichu {
				position: absolute;
				bottom: 0;
				left:   0;
				width:  100%;
				height: 40px;
				background-color: #1a3a37;
			}
			.main .daohang .tuichu a {
				display: inline-block;
				line-height: 40px;
				color: #afeeee;
				width: 100%;
				height: 40px;
				text-align: center;
				text-decoration-line: none;
				font-size: medium;
				font-weight: lighter;
			}
			.main .daohang .tuichu a:hover {
				color: #FFFFFF;
			}
			.main .daohang .tuichu a:hover path {
				fill: #FFFFFF;
			}
			.main .daohang .tuichu svg {
				width:  25px;
				height: 25px;
				margin: 8px 0;
				vertical-align: top;
			}
			.main .daohang .tuichu svg path {
				fill: #afeeee;
			}
			.main .daohang .tou {
				background-color: #2f4f4f;
				border-top: 1px solid #3b6363;
				border-bottom: 1px solid #3b6363;
				height: 30px;
				padding: 12.5px;
			}
			.main .daohang .tou svg {
				vertical-align: bottom;
				margin: 0 5px;
				width:  30px;
				height: 30px;
			}
			.main .daohang .tou svg path {
				fill: #afeeee;
			}
			.main .daohang .tou .name {
				display: inline-block;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
				width: 180px;
				line-height: 30px;
				vertical-align: bottom;
				color: #afeeee;
			}
			.main .daohang .wei {
				background-color: #2f4f4f;
				overflow: auto;
				padding: 25px 0;
				height: calc(100% - 147px);
			}
			.main .daohang .wei .xx {
				margin-bottom: 20px;
			}
			.main .daohang .wei .xx .fenlei {
				margin: 10px 15px;
				color: #ffffff;
				font-size: large;
			}
			.main .daohang .wei .xvanze {
				background-color: #596673;
				color: #FFFFFF;
			}
			.main .daohang .wei .xvanze path {
				fill: #FFFFFF;
			}
			.main .daohang .wei ul {
				list-style-type: none;
				margin:  0;
				padding: 0;
			}
			.main .daohang .wei ul li {
				height: 40px;
				margin: 5px 10px;
			}
			.main .daohang .wei ul li svg {
				width: 	20px;
				height: 20px;
				margin: 10px 5px;
				vertical-align: top;
			}
			.main .daohang .wei ul li svg path {
				fill: #afeeee;
			}
			.main .daohang .wei ul li a {
				display: inline-block;
				border-radius: 5px;
				text-decoration-line: none;
				width: calc(100% - 50px);
				height: 40px;
				padding: 0 25px;
				line-height: 40px;
				cursor: pointer;
				color: #afeeee;
				font-size: medium;
			}
			.main .daohang .wei ul li a:hover {
				background-color: #596673;
				color: #FFFFFF;
			}
			.main .daohang .wei ul li a:hover path {
				fill: #FFFFFF;
			}
			.main .neirong {
				position: relative;
				background-color: #F4F6F9;
				margin-left: 250px;
				height: 100%;
			}
			.main .neirong .header {
				border-top: 1px solid #1faece;
				border-bottom: 1px solid #1faece;
				background-color: #30a3bc;
				height: 55px;
			}
			.main .neirong .header .margin {
				height: 35px;
				line-height: 35px;
				position: relative;
				margin: 10px;
				text-align: right;
			}
			.main .neirong .header .margin .menu {
				position: absolute;
				top:  0;
				left: 0;
				cursor: pointer;
				padding: 6px 0;
				width:  33px;
				display: inline-block;
				border: 1px solid #FFFFFF;
				border-radius: 5px;
			}
			.main .neirong .header .margin .menu div {
				margin: 3px auto;
				width: 15px;
				height: 3px;
				border-radius: 2.5px;
				background-color: #FFFFFF;
			}
			.main .neirong .header .margin .domain {
				position: absolute;
				top:  0;
				left: 0;
				vertical-align: top;
				display: inline-block;
				height: 35px;
				margin: 0 5px;
				margin-left: 45px;
				color: #FFFFFF;
				font-size: x-large;
				font-family: fantasy1;
			}
			.main .neirong .header .margin .currency {
				display: inline-block;
				vertical-align: top;
				margin-right: 10px;
			}
			.main .neirong .header .margin .currency span {
				display: inline-block;
				height: 35px;
				font-size: x-large;
				font-family: UnidreamLED;
				color: #FFFFFF;
			}
			.main .neirong .header .margin .currency svg {
				width: 	35px;
				height: 35px;
				vertical-align: top;
			}
			.main .neirong .header .margin .currency svg path {
				fill: #FFFFFF;
			}
			.main .neirong .header .margin .start {
				display: inline-block;
				user-select: none;
				width: 130px;
				height: 33px;
				line-height: 33px;
				text-align: center;
				cursor: pointer;
				color: #FFFFFF;
				font-size: large;
				font-family: fantasy;
				border: 1px solid #FFFFFF;
				border-radius: 5px;
			}
			.main .neirong .header .margin .start:active {
				background-color: #2f4f4f;
				border: 1px solid #2F4F4F;
				color: #FFFFFF;
			}
			.main .neirong .header .margin .download {
				display: inline-block;
				height: 35px;
				color: #FFFFFF;
				font-size: large;
				font-family: fantasy;
			}
			.main .neirong .header .margin .download a {
				text-decoration: none;
				color: #FFFFFF;
			}
			.main .neirong .header .margin .download a span {
				display: inline-block;
				height: 35px;
			}
			.main .neirong .header .margin .download a svg {
				width: 	35px;
				height: 35px;
				vertical-align: top;
			}
			.main .neirong .header .margin .download a svg path {
				fill: #FFFFFF;
			}
			.main .neirong .body {
				position: relative;
				top:   0;
				right: 0;
				height: calc(100% - 55px);
				overflow: auto;
			}
			@keyframes daohang1 {
				0%   {left: 0;}
				100% {left: -230px;}
			}
			@keyframes neirong1 {
				0%   {margin-left: 230px;}
				100% {margin-left: 0;}
			}
			@media screen and (min-width: 1000px){
				.main .daohang {
					left: 0 !important;
				}
				.main .neirong {
					left: 0 !important;
					margin-left: 250px !important;
				}
			}
			@media screen and (max-width: 1000px){
				.main .daohang {
					animation-name: daohang1;
					animation-duration: 0.3s;
					animation-timing-function: ease-in;
					left: -250px;
				}
				.main .daohang .caidan {
					display: block;
				}
				.main .neirong {
					animation-name: neirong1;
					animation-duration: 0.3s;
					animation-timing-function: ease-in;
					margin-left: 0;
				}
			}
			@font-face {
				font-family: "fantasy1";
				src: url("font/TheCircous-4.ttf");
			}
			@font-face {
				font-family: "Freon";
				src: url("font/Freon.ttf");
			}
			@font-face {
				font-family: "UnidreamLED";
				src: url("font/UnidreamLED.ttf");
			}
			@media screen and (max-width: 800px){
				.main .neirong .header .margin .download {
					display: none;
				}
				.main .neirong .header .margin .currency {
					margin-right: 0;
				}
			}
		</style>
		<style if([mc_user.client]):>
			.body::-webkit-scrollbar {
				width:  5px;
				height: 5px;
			}
			.body::-webkit-scrollbar-track {
				border-radius:    5px;
				background-color: #0F0F0;
			}
			.body::-webkit-scrollbar-thumb {
				border-radius:    5px;
				background-color: #CCCCCC;
			}
		</style>
		<!--head-->
	</head>
	<body>
		<div class="tips">
			<div class="position">
				<span></span>
				<button onclick="tips(false)">确定</button>
			</div>
		</div>
		<div class="main">
			<div class="daohang">
				<div class="tou">
					<span class="touxiang">{include:"icons/name.svg"}</span>
					<span class="name" title="{echo:[mc_user.email]}">{echo:[mc_user.name]}</span>
				</div>
				<div class="wei">
					<div class="xx">
						<div class="fenlei">用户中心</div>
						<ul>
							<li><a href="{URL:'home.php'}" id="xvanze_home">{include:"icons/home.svg"} 用户首页</a></li>
							<li><a href="{URL:'goods.php'}" id="xvanze_goods">{include:"icons/goods.svg"} 购买道具</a></li>
							<li><a href="{URL:'clothes.php'}" id="xvanze_clothes">{include:"icons/clothes.svg"} 我的衣服</a></li>
						</ul>
					</div>
					<div class="xx">
						<div class="fenlei">浏览</div>
						<ul>
							<li><a href="https://minecraft.fandom.com/zh" target="_blank">{include:"icons/internet.svg"} 中文百科</a></li>
							<li><a href="https://littleskin.cn" target="_blank">{include:"icons/internet.svg"} littleskin 皮肤站</a></li>
						</ul>
					</div>
					<div if([mc_user.admin]): class="xx">
						<div class="fenlei">管理中心</div>
						<ul>
							<li><a href="{URL:'users.php'}" id="xvanze_users">{include:"icons/manage_users.svg"} 管理用户</a></li>
							<li><a href="{URL:'notice.php'}" id="xvanze_notice">{include:"icons/notice.svg"} 管理公告</a></li>
							<li><a href="{URL:'config.php'}" id="xvanze_config">{include:"icons/config.svg"} 配置选项</a></li>
							<li><a href="{URL:'prop.php'}" id="xvanze_prop">{include:"icons/edit.svg"} RCON 道具</a></li>
							<li><a href="{URL:'console.php'}" id="xvanze_console">{include:"icons/console.svg"} RCON 控制台</a></li>
						</ul>
					</div>
				</div>
				<div class="tuichu"><a href='{URL:"index.php":"log_out=1"}'>{include:"icons/tuichu.svg"} 退出登录</a></div>
			</div>
			<div class="neirong">
				<div class="header">
					<div class="margin">
						<div class="menu" onclick="caidan()">
							<div></div>
							<div></div>
							<div></div>
						</div>
						<div class="domain">{echo:[config.domain]}</div>
						<div class="currency">{include:"icons/bi.svg"} <span class="money">{echo:[mc_user.bi]}</span></div>
						<div if([mc_user.client]): class="start" id="start" username="{echo:[mc_user.name]}" uuid="{echo:[mc_user.id]}" token="{echo:[mc_user.token]}"><span></span></div>
						<!--else-->
						<div if(true): class="download"><a href="{echo:[config.download]}" target="_blank">{include:"icons/download.svg"} <span>下载客户端</span></a></div>
					</div>
				</div>
				<div class="body"><!--body--></div>
			</div>
		</div>
	</body>
</html><script>document.domain  = "laozhi.cc"</script>