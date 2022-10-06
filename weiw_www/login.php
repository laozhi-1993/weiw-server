<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");

	
    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_user_exit');
	$MKH ->mods('mc_user');
	$MKH ->send(false);
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta name="keywords" content="">
		<meta name="description" content="">
		<meta name="theme-color" content="#21242B" />
		<meta name="author" content="laozhi" />
		<meta charset="utf-8" />
		<style>
			.background {
				position: fixed;
				top:  0;
				left: 0;
				width: calc(100vw - 600px);
				height: 100vh;
			}
			.background iframe {
				width:  100%;
				height: 100%;
				vertical-align: bottom;
			}
			.biankuang {
				position: fixed;
				top:   0;
				right: 0;
				border-bottom: 100vh solid #253369;
				border-left:200px solid transparent;
				width: 600px;
			}
			.content {
				display: none;
				margin: 10px auto;
				width: 100px;
			}
			.content > div {
				width:  10px;
				height: 10px;
				background-color: #FFFFFF;
				border-radius: 100%;
				display: inline-block;
				animation: action 1.5s infinite ease-in-out;
				animation-fill-mode: both;
			}
			.content .point1 {
				animation-delay: -0.3s;
			}
			.content .point2 {
				animation-delay: -0.1s;
			}
			@keyframes action {
				0%, 80%, 100% {
					transform: scale(0);
				}
				40% {
					transform: scale(1.0);
				}
			}
			body {
				background-color: #000000;
				margin:  0;
				padding: 0;
			}
			.focus {
				border: 2px solid #000000!important;
			}
			.focus legend {
				color: #000000!important;
			}
			main {
				position: absolute;
				top:   0;
				right: 0;
				user-select: none;
				overflow: hidden;
				background-color: #253369;
				width:  600px;
				height: 100vh;
				min-height: 550px;
			}
			main .kuang {
				position: relative;
				top: calc(50% - 270px);
				left: 0;
				width:  100%;
			}
			main .kuang .tips {
				color: #000000;
				padding: 10px 2px;
			}
			main .kuang .error {
				color: #ff0000;
				padding: 10px 2px;
				display: none;
			}
			main .kuang .error span {
				display: inline-block;
				line-height: 22px;
			}
			main .kuang .error svg {
				width:  22px;
				height: 22px;
				vertical-align: top;
			}
			main .kuang .error svg path {
				 fill: #ff0000;
			}
			main .kuang .margin {
				position: relative;
				top: 0;
				margin:  50px;
				padding: 50px;
				background-color: #f5f8fa;
				border-radius: 10px;
				box-shadow: 0 0 15px 0px #555555;
			}
			main .kuang .margin h1 {
				text-align: center;
				padding: 22px 0;
				margin: 0;
			}
			main .kuang .margin h5 {
				text-align: center;
			}
			main .kuang .margin fieldset
			{
				height: 51px;
				margin-Top: 10px;
				position: relative;
				padding: 0px 10px 5px 10px;
				background-color: #E8F0FE;
				border: 2px solid #6767ee;
				border-radius: 5px;
			}
			main .kuang .margin fieldset legend {
				position: absolute;
				top: 18px;
				font-size: 25px;
				line-height: 20px;
				color: #6767ee;
			}
			main .kuang .margin fieldset input {
				position: relative;
				z-index: 1;
				background-color: transparent;
				border: none;
				width:  100%;
				height: 50px;
				font-size: large;
			}
			main .kuang .margin fieldset input:focus {
				outline: none;
			}
			main .kuang .margin .anniu {
				height: 45px;
				margin: 30px;
				text-align: center;
			}
			main .kuang .margin .anniu button {
				border: none;
				background-color: #0c9cff;
				border-radius: 5px;
				font-size: large;
				color: #FFFFFF;
				cursor: pointer;
				margin:  0;
				padding: 0;
				width: 110px;
				height: 40px;
			}
			main .kuang .margin .anniu button:active {
				background-color: #00335d;
				color: #dda0dd;
			}
			.Footer {
				position: relative;
				top: 0px;
				color: #FFFFFF;
				text-align: center;
				
			}
			@media screen and (max-width: 500px){
				main {
					width: 100%;
				}
				main .kuang .margin {
					margin:  50px 5px;
					padding: 50px 5px;
				}
			}
			@media screen and (max-width: 1200px){
				.background {
					display: none;
				}
				.biankuang {
					display: none;
				}
				main {
					width: 100%;
				}
				main .kuang {
					position: relative;
					top: calc(50% - 270px);
					left: 0;
					margin: 0 auto;
					max-width: 650px;
				}
			}
		</style>
		<title>登录 - {echo:[config.serverName]}</title>
	</head>
	<body>
		<div class="background"><iframe src="texture/Fireworks.php" allowtransparency="true" allowfullscreen="true" frameborder="0"></iframe></div>
		<div class="biankuang"></div>
		<main>
			<div class="kuang">
				<div class="margin">
					<h1>登录</h1>
					<div if([GET.type] == 'register'):>
						<fieldset>
							<legend>请输入用户名</legend>
							<input type="text" name="register" onkeypress="" />
						</fieldset>
						<div class="error">{include:"icons/error.svg"} <span></span></div>
						<div class="tips">由于此电子邮件地址首次登录本站，请输入一个用户名以完成注册。</div>
						<div class="anniu">
							<button onclick="button(true)">
								<span>下一步</span>
								<div class="content">
									<div class="point1"></div>
									<div class="point2"></div>
									<div class="point3"></div>
								</div>
							</button>
						</div>
					</div>
					<!--else-->
					<div if([GET.type] == 'code'):>
						<fieldset>
							<legend>请输入验证码</legend>
							<input type="text" name="code" onkeypress="" />
						</fieldset>
						<div class="error">{include:"icons/error.svg"} <span></span></div>
						<div class="tips">已经发送了一个验证码到你的电子邮箱里。</div>
						<div class="anniu">
							<button onclick="button(true)">
								<span>下一步</span>
								<div class="content">
									<div class="point1"></div>
									<div class="point2"></div>
									<div class="point3"></div>
								</div>
							</button>
						</div>
					</div>
					<!--else-->
					<div if(true):>
						<fieldset>
							<legend>电子邮件地址</legend>
							<input type="email" name="email" onkeypress="" />
						</fieldset>
						<div class="error">{include:"icons/error.svg"} <span></span></div>
						<div class="tips">如首次登录本站将自动完成注册。</div>
						<div class="anniu">
							<button onclick="button(true)">
								<span>下一步</span>
								<div class="content">
									<div class="point1"></div>
									<div class="point2"></div>
									<div class="point3"></div>
								</div>
							</button>
						</div>
					</div>
					<h5><a if([mc_user.email]): href="home.php">{echo:[mc_user.email]}</a></h5>
				</div>
				<div class="Footer">Copyright© 2022 laozhi 版权所有</div>
			</div>
		</main>
		<script src="/weiw/jquery.min.js"></script>
		<script>
			$(function(){
				var href     = window.location.href;
				var kaiguan  = true;
				var tupian   = [];
				var suijishu = Math.floor(Math.random() * 3);
				tupian[0] = "https://i.imgtg.com/2022/04/29/z5eqN.png";
				tupian[1] = "https://i.imgtg.com/2022/04/29/z5h2s.jpg";
				tupian[2] = "https://i.imgtg.com/2022/04/28/zah2p.jpg";
				$(".background").css("background","url("+tupian[suijishu]+")");
				$(".background").css("background-repeat","no-repeat");
				$(".background").css("background-position","center");
				$(".background").css("background-size","cover");
				
				
				if($("fieldset input").val() != "")
				{
					$("fieldset").css({"height":"60px"});
					$("fieldset").css({"margin-top":"1px"});
					$("fieldset legend").css({"position":"relative"});
					$("fieldset legend").css({"top":"0"});
					$("fieldset legend").css({"font-size":"18px"});
					$("fieldset input").css({"height":"40px"});
				}
				$("fieldset input").focus(function (){
					$("fieldset").addClass("focus");
					if($("fieldset input").val() == "")
					{
						$("fieldset legend").animate({"top":"-10px","fontSize":"18px"},200,function(){
							$("fieldset").css({"height":"60px"});
							$("fieldset").css({"margin-top":"1px"});
							$("fieldset legend").css({"position":"relative"});
							$("fieldset legend").css({"top":"0"});
							$("fieldset input").css({"height":"40px"});
						});
					}
				});
				$("fieldset input").blur(function (){
					$("fieldset").removeClass("focus");
					if($("fieldset input").val() == "")
					{
						$("fieldset").css({"height":"51px"});
						$("fieldset").css({"margin-top":"10px"});
						$("fieldset legend").animate({"top":"18px","fontSize":"25px"},200);
						$("fieldset legend").css({"position":"absolute"});
						$("fieldset input").css({"height":"50px"});
					}
				});
				$(".anniu button").click(function(){
					if(kaiguan)
					{
						kaiguan = false;
						$("fieldset").css("border","2px solid #6767ee");
						$("fieldset legend").css("color","#6767ee");
						$(".error").hide();
						$.getJSON("/weiw/index.php?{echo:token}",{"mods":"mc_login","type":$('input').attr("name"),"val":$('input').val()},function(result){
							if(result['error'] == '注册完成'){
								window.location.replace("index.php");
							}else if(result['error'] == '登录完成'){
								window.location.replace("index.php");
							}else if(result['error'] == '验证码已发送'){
								window.location.href = "login.php?type=code";
							}else if(result['error'] == 'register'){
								window.location.href = "login.php?type=register";
							}else{
								$("fieldset").css("border","2px solid #ff0000");
								$("fieldset legend").css("color","#ff0000");
								$(".error").show();
								$(".error span").html(result['error']);
								kaiguan = true;
							}
							button(false);
						});
					}
				});
			});
			
			
			function button(a)
			{
				if(a)
				{
					$(".content").show();
					$(".anniu span").hide();
				}
				else
				{
					$(".anniu span").show();
					$(".content").hide();
				}
			}
		</script>
	</body>
</html>