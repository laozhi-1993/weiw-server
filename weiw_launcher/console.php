<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_admin');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<script src="js/jquery.min.js"></script>
		<script src="js/once.js"></script>
		<script>
			var command_once = once();
			var command = function (com)
			{
				command_once((open) => {
					if(com == "broadcast")
					{
						var value = "broadcast "+$("#command").val();
						var text  = "<div class='send'>发送了公告："+$("#command").val()+"</div>";
					}
					else if(com)
					{
						var value = com;
						var text  = "<div class='send'>发送了命令："+com+"</div>";
					}
					else
					{
						var value = $("#command").val();
						var text  = "<div class='send'>发送了命令："+$("#command").val()+"</div>";
					}
					
					
					if(value !== "")
					{
						$.getJSON("/weiw/index.php?{echo:token}",{"mods":"mc_console","command":value},function (result){
							if(result.error !== '\u0000\u0000')
							{
								$(".rcon .output pre").append("<div class='return'>"+result.error+"</div>");
								$(".rcon .output").scrollTop($(".rcon .output").prop("scrollHeight"));
							}
							
							open();
						});
						
						
						$("#command").val("");
						$(".rcon .output pre").append(text);
						$(".rcon .output").scrollTop($(".rcon .output").prop("scrollHeight"));
					}
					else open();
				});
			}
			
			
			window.addEventListener('DOMContentLoaded', function() {
				$("#command").keyup(function (){
					if(event.keyCode == 13)
					{
						$("#button").click();
					}
				});
			});
		</script>
		<style>
			body {
				padding: 0;
				overflow: hidden;
				height: 100vh;
			}
			.rcon {
				position: relative;
				height: 100%;
			}
			.rcon .output {
				height: calc(100% - 50px);
				overflow-y: scroll;
			}
			.rcon .output pre {
				background: radial-gradient(#666,#555);
				border-radius: 5px;
				box-sizing: border-box;
				margin: 0;
				margin-right: 5px;
				min-height: 100%;
				padding: 10px;
			}
			.rcon .output pre div {
				margin: 0;
				margin-top: 5px;
				margin-bottom: 5px;
			}
			.rcon .output pre .send {
				color: #bde619;
				font-size: 18px;
			}
			.rcon .output pre .return {
				border-radius: 5px;
				background-color: #343541;
				padding: 15px;
				color: #a9e5ed;
				font-size: 16px;
			}
			.rcon .operate {
				position: relative;
				font-size: 0;
			}
			.rcon .operate input {
				width: calc(100% - 315px);
				height: 35px;
				padding: 5px 10px;
				margin: 5px 0;
				color: #fff;
				font-size: 16px;
				box-sizing: border-box;
				border: 2px solid #666;
				border-radius: 5px;
				background-color: #555;
			}
			.rcon .operate input::placeholder {
				color: #bbb;
			}
			.rcon .operate button {
				padding: 15px;
				padding-top: 5px;
				padding-bottom: 5px;
				margin-left: 5px;
				width: 100px;
				height: 35px;
				cursor: pointer;
				color: #fff;
				font-size: 12px;
				box-sizing: border-box;
				border: none;
				border-radius: 5px;
				background: radial-gradient(#666,#555);
			}
			.rcon .operate button:hover {
				color: #ff8033;
			}
		</style>
	</head>
	<body>
		<div class="rcon">
			<div class="output">
				<pre></pre>
			</div>
			<div class="operate">
				<input type="text" placeholder="Ctrl+V 粘贴" id="command" />
				<button onclick="command()" id="button">发送命令</button>
				<button onclick="command('broadcast')">发送公告</button>
				<button onclick="command('save-all')">保存世界</button>
			</div>
		</div>
	</body>
</html>