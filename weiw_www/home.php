<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_user');
	$MKH ->mods('mc_notice');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<title>用户首页</title>
		<script>
			var time = 0;
			var sudokg = true;
			$(function (){
				$.getJSON("/weiw/index.php?mods=mc_sign_in&{echo:token}",function (result){
					time = result.count_down;
					setInterval(count_down(),1000);
				});
				$(".sudo").click(function(){
					if(sudokg)
					{
						command = $(this).attr("command");
						sudokg  = false;
						$.getJSON("/weiw/index.php?mods=mc_sudo&command="+command+"&{echo:token}",function (result){
							if(result.error != "ok")
							{
								tips(result.error);
							}
							sudokg = true;
						});
					}
				});
			});
			
			function tpa(thiss)
			{
				html = "";
				name = $(thiss).attr("name");
				if($("style[name='"+name+"']").length == 0)
				{
					setTimeout(function (){
						$("style[name='"+name+"']").remove();
					},5000);
					
					html += "<style name='"+name+"'>";
					html += ".operation[name='"+name+"'] span:nth-child(1) {display: none!important}";
					html += ".operation[name='"+name+"'] span:nth-child(2) {display: inline-block!important}";
					html += "</style>";
					
					$("head").append(html);
					$.getJSON("/weiw/index.php?mods=mc_sudo&command=tpa "+name+"&{echo:token}",function (result){
						if(result.error != "ok") tips(result.error);
					});
				}
			}
			
			function count_down()
			{
				if(time <= 0)
				{
					$(".count_down").hide();
					$(".si").show();
				}
				else
				{
					time--;
					$(".si").hide();
					$(".count_down").show();
					$(".second").html(time);
				}
				
				return count_down;
			}
			
			function sign_in()
			{
				if(time <= 0)
				{
					$.getJSON("/weiw/index.php?mods=mc_sign_in&si=1&{echo:token}",function (result){
						if(result.error == "ok")
						{
							time = 86400;
							$(".money").html(result.bi);
						}
					});
				}
			}
		</script>
		<style>
			.region {
				margin: 10px;
				padding: 10px;
				border-radius: 10px;
			}
			.home {
				position: relative;
			}
			.home .left {
				position: absolute;
				top:  0;
				left: 0;
				width: 55%;
			}
			.home .right {
				position: absolute;
				top:   0;
				right: 0;
				width: 45%;
			}
			.home .control {
				text-align: center;
				padding: 10px;
			}
			.information {
				background-color: #FFFFFF;
				border: 1px solid #cacad0;
				border-radius: 5px;
				margin: 20px;
			}
			.information .name {
				background-color: #F0F0F0;
				border-bottom: 1px solid #cacad0;
				height: 35px;
				line-height: 35px;
				color: #008080;
				text-align: center;
			}
			.information .content {
				margin: 10px;
				min-height: 500px;
			}
			.information .footer {
				background-color: #F0F0F0;
				position: relative;
				padding: 10px;
			}
			.sign_in {
				display: inline-block;
				height: 40px;
				cursor: pointer;
				user-select: none;
				line-height: 40px;
				font-size: 18px;
				text-align: center;
				color: #FFFFFF;
			}
			.sign_in svg {
				width:  25px;
				height: 25px;
				vertical-align: top;
				padding: 7.5px 0;
			}
			.sign_in path {
				 fill: #FFFFFF;
			}
			.sign_in .count_down {
				border-radius: 5px;
				background-color: #0C9CFF;
				padding: 0 30px;
				display: none;
			}
			.sign_in .si {
				border-radius: 5px;
				background-color: #2d5ff5;
				padding: 0 30px;
			}
			.time {
				border-radius: 5px;
				border: 1px solid #cacad0;
				background-color: #FFFFFF;
				padding: 0 10px;
				position: absolute;
				right: 10px;
				display: inline-block;
				height: 38px;
				line-height: 38px;
				text-align: center;
				color: #008080;
			}
			.time svg {
				width:  20px;
				height: 20px;
				vertical-align: top;
				padding: 9px 0;
			}
			.time path {
				 fill: #008080;
			}
			.sudo {
				background-color: #FFFFFF;
				border: 1px solid #cacad0;
				border-radius: 5px;
				display: inline-block;
				padding: 20px;
				margin: 10px;
				width: 300px;
				height: 80px;
				line-height: 80px;
				text-align: center;
				cursor: pointer;
				user-select: none;
				color: #006374;
				font-size: 35px;
			}
			.sudo:active {
				background-color: #2f4f4f;
				color: #FFFFFF;
			}
			.player_list {
				padding: 10px;
				min-height: 30px;
				user-select: none;
			}
			.player_list .user {
				position: relative;
				height: 30px;
				line-height: 30px;
				color: #778899;
			}
			.player_list .user:hover {
				border-radius: 5px;
				background-color: #f5f5f5;
			}
			.player_list .user .role {
				position: absolute;
				top:  0;
				left: 0;
				padding: 0 10px;
			}
			.player_list .user .operation {
				position: absolute;
				top:   0;
				right: 0;
				cursor: pointer;
				padding: 0 10px;
			}
			.player_list .user .operation span:nth-child(1) {
				display: inline-block;
			}
			.player_list .user .operation span:nth-child(2) {
				display: none;
			}
			@media screen and (max-width: 1620px){
				.home .left {
					position: relative;
					top: 0;
					margin-right: 0;
					width: auto;
				}
				.home .right {
					position: relative;
					top: 0;
					width: auto;
				}
			}
			@media screen and (max-width: 800px){
				.information {
					margin: 10px;
				}
				.sudo {
					margin: 0;
					margin-bottom: 10px;
					width: auto;
					display: block;
				}
			}
			@media screen and (max-width: 600px){
				.time {
					position: relative;
					right: 0;
					margin-top: 10px;
					display: block;
				}
				.sign_in {
					display: block;
				}
			}
		</style>
	</head>
	<body>
		<div class="home">
			<div class="left">
				<div class="control">
					<div class="sudo" command="workbench">打开工作台</div>
					<div class="sudo" command="enderchest">打开末影箱</div>
					<div class="sudo" command="back">上一位置</div>
					<div class="sudo" command="home home">传送回家</div>
					<div class="sudo" command="tpaccept">接受传送</div>
					<div class="sudo" command="tpr">随机传送</div>
					<div class="sudo" command="gsit">坐在地上</div>
					<div class="sudo" command="glay">躺在地上</div>
					<div class="sudo" command="gcrawl">趴在地上</div>
					<div class="sudo" command="gspin">原地旋转</div>
					<div class="sudo" command="afk">暂时离开</div>
					<div class="sudo" command="suicide">立即狗带</div>
				</div>
			</div>
			<div class="right">
				<div class="information">
					<div class="name">在线玩家列表 (<span class="current"></span>/<span class="maximum"></span>)</div>
					<div class="player_list">
						<div class="user">
							<div class="role">{name}</div>
							<div class="operation" name="{name}" onclick="tpa(this)">
								<span>请求传送</span>
								<span>请求已发送</span>
							</div>
						</div>
					</div>
				</div>
				<div class="information">
					<div class="name">公告</div>
					<div class="content">{echo:[mc_notice.content]}</div>
					<div class="footer">
						<div class="sign_in">
							<div class="count_down">{include:"icons/sign_in.svg"} <span class="second"></span> 秒后可签到</div>
							<div class="si" onclick="sign_in()">{include:"icons/sign_in.svg"} 签到</div>
						</div>
						<div class="time" title="最后一次修改日期">
							<span>{include:"icons/modify_date.svg"} {echo:[mc_notice.date]}</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>