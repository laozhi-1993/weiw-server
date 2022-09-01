<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_admin');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<title>RCON 控制台</title>
		<script>
			$(function (){
				$("input").keyup(function (){
					if(event.keyCode == 13)
					{
						$("#button").click();
					}
				});
			});
			
			
			function command() 
			{
				var value = $("#command").val();
				if(value !== "")
				{
					url = {"mods":"mc_rcon"};
					url['command'] = value;
					$.getJSON("/weiw/index.php?{echo:token}",url,function (result){
						$(".window").append("<p>"+result.error+"</p>");
						$(".window").scrollTop($(".window").prop("scrollHeight"));
					});
					
					
					$("#command").val("");
					$(".window").append("<p>发送了命令："+value+"</p>");
					$(".window").scrollTop($(".window").prop("scrollHeight"));
				}
			}
			function broadcast() 
			{
				var value = $("#command").val();
				if(value !== "")
				{
					url = {"mods":"mc_rcon"};
					url['command'] = "broadcast "+value;
					$.getJSON("/weiw/index.php?{echo:token}",url,function (result){
						$(".window").append("<p>"+result.error+"</p>");
						$(".window").scrollTop($(".window").prop("scrollHeight"));
					});
					
					
					$("#command").val("");
					$(".window").append("<p>发送了公告："+value+"</p>");
					$(".window").scrollTop($(".window").prop("scrollHeight"));
				}
			}
			function save() 
			{
				url = {"mods":"mc_rcon"};
				url['command'] = "save-all";
				$.getJSON("/weiw/index.php?{echo:token}",url,function (result){
					$(".window").append("<p>"+result.error+"</p>");
					$(".window").scrollTop($(".window").prop("scrollHeight"));
				});
				
				
				$(".window").append("<p>发送了命令：save-all</p>");
				$(".window").scrollTop($(".window").prop("scrollHeight"));
			}
		</script>
		<style>
			.rcon {
				position: relative;
				padding: 20px;
				height: calc(100% - 40px);
			}
			.rcon .window {
				background-color: #008b8b;
				border: 1px solid #00e1e1;
				width: calc(100% - 465px);
				height: calc(100% - 70px);
				overflow-y: scroll;
			}
			.rcon .list {
				padding: 0 20px;
				position: absolute;
				top: 20px;
				right: 20px;
				background-color: #008b8b;
				border: 1px solid #00e1e1;
				width: 415px;
				height: calc(100% - 110px);
				overflow-y: scroll;
			}
			.rcon .list .title {
				text-align: center;
				padding: 10px;
			}
			.rcon .window p {
				padding: 0;
				margin: 10px;
			}
			.rcon input {
				width: calc(100% - 14px);
				height: 20px;
				padding: 5px;
				margin: 5px 0;
			}
			.rcon button {
				cursor: pointer;
			}
			@media screen and (max-width: 1300px) {
				.list {
					display: none;
				}
				.rcon .window {
					width: auto;
				}
			}
		</style>
	</head>
	<body>
		<div class="rcon">
			<div class="window"></div>
			<div class="list">
				<div class="title">在线玩家列表 （<span class="current"></span>/<span class="maximum"></span>）</div>
				<div class="player_list"><div>{name}</div></div>
			</div>
			<input type="text" name="command" value="" id="command" />
			<button onclick="command()" id="button">发送命令</button>
			<button onclick="broadcast()">发送公告</button>
			<button onclick="save()">保存世界</button>
		</div>
	</body>
</html>