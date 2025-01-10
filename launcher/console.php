<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


	$MKH = new mkh();
	$MKH ->mods('mc_launcher');
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<style>
			body {
				padding: 0;
				overflow: hidden !important;
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
				width: calc(100% - 210px);
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
		<includes-scrollbar><?php include('includes/scrollbar.html') ?></includes-scrollbar>
		
		<div class="rcon">
			<div class="output">
				<pre></pre>
			</div>
			<div class="operate">
				<form action="/weiw/index.php?mods=mc_console" method="GET">
					<input type="text" name="command" placeholder="Ctrl+V 粘贴" required />
					<button>发送命令</button>
					<button type="button" onclick="changepassword()">更改密码</button>
				</form>
			</div>
		</div>
		
		
		<script src="js/main.js"></script>
		<script>
			const output = document.querySelector('.output');
			const pre = document.querySelector('.output pre');
			
			handleFormSubmit("form", function(fetch, form) {
				const input = form.querySelector('input');
				
				pre.insertAdjacentHTML("beforeend", "<div class='send'>发送了命令："+input.value+"</div>");
				output.scrollTop = output.scrollHeight;
				input.value = '';
				
				fetch.then((data) => {
					if(data.error !== '\u0000\u0000')
					{
						pre.insertAdjacentHTML("beforeend", "<div class='return'>"+data.error+"</div>");
						output.scrollTop = output.scrollHeight;
					}
				}).catch((error) => {
					pre.insertAdjacentHTML("beforeend", "<div class='return'>"+error+"</div>");
					output.scrollTop = output.scrollHeight;
				});
			});
			
			function changepassword() {
				document.querySelector('input').value = "changepassword [旧密码] [新密码] [确认新密码]";
			}
		</script>
	</body>
</html>