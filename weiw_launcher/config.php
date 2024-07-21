<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_config');
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<script src="js/jquery.min.js"></script>
		<script src="js/config.js"></script>
		<style>
			.server {
				padding: 5px 10px;
			}
			.server input {
				width: calc(100% - 100px);
				height: 35px;
				color: inherit;
				padding:0 10px;
				box-sizing: border-box;
				border: 1px solid #ffff00;
				background-color: #666;
			}
			.server span {
				display: inline-block;
				vertical-align: top;
				width: 100px;
				height: 35px;
				line-height: 35px;
				text-align: center;
				color: #505050;
				font-size: 15px;
				box-sizing: border-box;
				background-color: #ffff00;
			}
			.RSA {
				margin: 0 10px;
			}
			.RSA p {
				margin: 10px;
				font-size: medium;
			}
			.RSA textarea {
				width: 100%;
				height: 400px;
				color: inherit;
				padding: 10px;
				box-sizing: border-box;
				border: 1px solid #ffff00;
				background-color: #666;
			}
			.items {
				margin: 0 10px;
			}
			.items textarea {
				padding: 10px;
				width: 100%;
				color: inherit;
				font-size: 15px;
				min-height: 500px;
				box-sizing: border-box;
				border: 1px solid #ffff00;
				background-color: #666;
			}


			.config {
				border-radius: 5px;
				background: radial-gradient(#666,#555);
				padding: 50px;
				padding-top: 0;
				color: #fff;
				overflow: auto;
			}
			.config fieldset {
				margin-top: 50px;
				padding: 30px 10px;
				border: 2px solid #91B1D5;
				border-radius: 5px;
			}
			.config fieldset legend {
				font-size: x-large;
				text-align: center;
				padding: 0 5px;
				color: #91B1D5;
			}
			.config fieldset button {
				background-color: #b400b4;
				border: 1px solid #b400b4;
				border-radius: 5px;
				font-size: medium;
				text-align: center;
				padding: 8px 30px;
				margin: 30px 10px 10px 10px;
				cursor: pointer;
				color: #f5f5f5;
			}
			.config fieldset button:hover {
				background-color: #a62ba5;
				color: #FFFFFF;
			}
			.config fieldset .zong {
				font-size: 0;
			}
			.config fieldset .zong .zuo {
				display: inline-block;
				width: 50%;
				vertical-align:top;
			}
			.config fieldset .zong .you {
				display: inline-block;
				width: 50%;
				vertical-align:top;
			}
			@media screen and (max-width: 1300px){
				.config fieldset .zong .zuo {
					width: 100%;
				}
				.config fieldset .zong .you {
					width: 100%;
				}
			}
		</style>
	</head>
	<body>
		<div class="message"><?php include('includes/message.html') ?></div>
		<div class="config">
			<fieldset>
				<legend>网站选项</legend>
				<div class="zong">
					<div class="zuo">
						<div class="server"><span>网站名字</span><input type="text" value="{echo:var.mc_config.config.serverName}" id="serverName" /></div>
						<div class="server"><span>网站域名</span><input type="text" value="{echo:var.mc_config.config.domain}" id="domain" /></div>
						<div class="server"><span>认证地址</span><input type="text" value="{echo:var.mc_config.config.authUrl}" id="authUrl" /></div>
					</div>
					<div class="you">
						<div class="server"><span>下载地址</span><input type="text" value="{echo:var.mc_config.config.download}" id="download" /></div>
						<div class="server"><span>初始金钱</span><input type="text" value="{echo:var.mc_config.config.defaultMoney}" id="defaultMoney" /></div>
						<div class="server"><span>签到金钱</span><input type="text" value="{echo:var.mc_config.config.checkinMoney}" id="checkinMoney" /></div>
					</div>
				</div>
				<button onclick="server()">保存</button>
			</fieldset>
			<fieldset>
				<legend>编辑道具</legend>
				<div class="zong">
					<div class="items">
						<textarea name='items'>{echo:var.mc_config.items}</textarea>
					</div>
				</div>
				<button onclick="items()">保存</button>
			</fieldset>
			<fieldset>
				<legend>RCON</legend>
				<div class="zong">
					<div class="zuo">
						<div class="server"><span>地　　址</span><input type="text" value="{echo:var.mc_config.rcon.host}" id="host" /></div>
						<div class="server"><span>端　　口</span><input type="text" value="{echo:var.mc_config.rcon.post}" id="post" /></div>
					</div>
					<div class="you">
						<div class="server"><span>密　　码</span><input type="text" value="{echo:var.mc_config.rcon.password}" id="password" /></div>
						<div class="server"><span>超时时间</span><input type="text" value="{echo:var.mc_config.rcon.time}" id="time" /></div>
					</div>
				</div>
				<button onclick="rcon()">保存</button>
			</fieldset>
			<fieldset>
				<legend>编辑RSA秘钥</legend>
				<div class="zong">
					<div class="zuo">
						<div class="RSA">
							<p>私钥</p>
							<textarea name='private'>{echo:var.mc_config.rsa.private}</textarea>
						</div>
					</div>
					<div class="you">
						<div class="RSA">
							<p>公钥</p>
							<textarea name='public'>{echo:var.mc_config.rsa.public}</textarea>
						</div>
					</div>
				</div>
				<button onclick="rsa()">保存</button>
			</fieldset>
		</div>
	</body>
</html>