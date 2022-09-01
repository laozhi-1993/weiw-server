<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_user');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<title>我的密码</title>
		<script>
			var zhuangtai  = true;
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
			function Refresh()
			{
				if(zhuangtai)
				{
					zhuangtai = false;
					$.getJSON("/weiw/index.php?{echo:token}",{"mods":"mc_refresh_password"},function(result){
						if(result['error'] == '刷新完成'){
							$("#show").text(result['password']);
							tips(result['error']);
						} else {
							tips(result['error']);
						}
						zhuangtai = true;
					});
				}
			}
			function password(kaiguan)
			{
				if(kaiguan)
				{
					$("#password").text("********************************");
					$(".password .kaiguan span").eq(0).hide();
					$(".password .kaiguan span").eq(1).show();
					$(".password .text span").eq(0).show();
					$(".password .text span").eq(1).hide();
				}
				else
				{
					$("#password").text($("#password").attr("password"));
					$(".password .kaiguan span").eq(0).show();
					$(".password .kaiguan span").eq(1).hide();
					$(".password .text span").eq(0).hide();
					$(".password .text span").eq(1).show();
				}
			}
		</script>
		<style>
			.password {
				position: relative;
				top: 100px;
				margin: 10px;
			}
			.password .margin {
				position: relative;
				padding: 30px 5px;
				padding-top: 120px;
				margin: 0 auto;
				max-width: 500px;
				text-align: center;
				overflow: hidden;
				background-color: #FFFFFF;
				border-radius: 10px;
				box-shadow: 0 0 5px 0px #a7f6f6;
			}
			.password .margin h3 {
				position: absolute;
				top:    0;
				right:  0;
				margin: 0;
				padding: 45px 0 25px 0;
				width: 100%;
				color: #f8f8ff;
				user-select: none;
				background-color: #4169e1;
			}
			.password .margin .text {
				line-height: 30px;
				display: inline-block;
				padding: 0 5px;
				border-bottom: 1px solid #6767ee;
			}
			.password .margin .text #show {
				display: none;
			}
			.password .margin .kaiguan {
				margin: 10px 0;
			}
			.password .margin .kaiguan span {
				cursor: pointer;
				user-select: none;
			}
			.password .margin .kaiguan span:nth-child(1) {
				display: none;
			}
			.password .margin .kaiguan svg {
				width:  35px;
				height: 35px;
			}
			.password .margin .kaiguan svg path {
				 fill: #2ED1C7;
			}
			.password .margin .anniu {
				margin: 30px;
				margin-top: 5px;
				height: 45px;
				text-align: center;
				user-select: none;
			}
			.password .margin .anniu button {
				border: none;
				background-color: #0c9cff;
				border-radius: 5px;
				font-size: small;
				color: #FFFFFF;
				cursor: pointer;
				margin: 5px 0;
				padding: 0;
				width: 100px;
				height: 35px;
			}
			.password .margin .anniu button:active {
				background-color: #00335d;
				color: #dda0dd;
			}
		</style>
	</head>
	<body>
		<div class="password">
			<div class="margin">
				<h3>此密码用来登录我的世界客户端</h3>
				<div class="kaiguan">
					<span title="密码已显示" onclick="password(true )">{include:"icons/show.svg"}</span>
					<span title="密码已隐藏" onclick="password(false)">{include:"icons/hide.svg"}</span>
				</div>
				<div class="text">
					<span id="hide">********************************</span>
					<span id="show">{echo:[mc_user.password]}</span>
				</div>
				<div class="anniu">
					<button onclick="copyText()">
						<span>复制密码</span>
					</button>
					<button onclick="Refresh()">
						<span>刷新密码</span>
					</button>
				</div>
			</div>
		</div>
	</body>
</html>