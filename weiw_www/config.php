<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_admin');
	$MKH ->mods('mc_rsa');
	$MKH ->mods('mc_rcon_information');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<title>配置选项</title>
		<script>
			function server()
			{
				url = {"mods":"mc_server"};
				url['serverName']    = $("#serverName").val();
				url['domain']        = $("#domain").val();
				url['home']          = $("#home").val();
				url['register']      = $("#register").val();
				url['download']      = $("#download").val();
				url['Yggdrasil']     = $("#Yggdrasil").val();
				url['initial_money'] = $("#initial_money").val();
				url['sign_in_money'] = $("#sign_in_money").val();
				$.getJSON("/weiw/index.php?{echo:token}",url,function (result){
					tips(result.error);
				});
			}
			function rcon()
			{
				url = {"mods":"mc_rcon_information"};
				url['host'] = $("#host").val();
				url['post'] = $("#post").val();
				url['pwd']  = $("#pwd").val();
				url['time'] = $("#time").val();
				$.getJSON("/weiw/index.php?{echo:token}",url,function (result){
					tips(result.error);
				});
			}
			function rsa()
			{
				url = {"mods":"mc_rsa"};
				url['private'] = $("textarea[name='private']").val();
				url['public']     = $("textarea[name='public']").val();
				$.getJSON("/weiw/index.php?{echo:token}",url,function (result){
					tips(result.error);
				});
			}
		</script>
		<style>
			.server {
				margin: 0 10px;
			}
			.server input {
				width: calc(100% - 110px);
				height: 30px;
				margin: 5px 0;
				padding:0 10px;
				border: 1px solid #666666;
				border-radius: 5px;
			}
			.server span {
				font-size: medium;
			}
			.RSA {
				margin: 0;
			}
			.RSA textarea {
				width: calc(100% - 42px);
				max-width: calc(100% - 42px);
				min-width: calc(100% - 42px);
				height: 400px;
				min-height: 300px;
				margin: 10px;
				padding: 10px;
				font-size: medium;
				display: inline-block;
				overflow-y: scroll;
				border: 1px solid #666666;
				border-radius: 5px;
			}
			.RSA p {
				margin: 10px;
				font-size: medium;
			}


			.config {
				margin: 50px;
				color: #666666;
			}
			.config fieldset {
				margin: 30px 0;
				padding: 50px;
				background-color: #FFFFFF;
				border: 2px solid #91B1D5;
				border-radius: 5px;
			}
			.config fieldset legend {
				font-size: x-large;
				text-align: center;
				padding: 0 5px;
			}
			.config fieldset button {
				background-color: #a000a0;
				border: 1px solid #a000a0;
				border-radius: 5px;
				font-size: medium;
				text-align: center;
				padding: 8px 30px;
				margin: 30px 10px 10px 10px;
				cursor: pointer;
				color: #f5f5f5;
			}
			.config fieldset button:hover {
				background-color: #730d73;
				color: #FFFFFF;
			}
			.config fieldset .zong {
				font-size: 0;
			}
			.config fieldset .zong .zuo {
				display: inline-block;
				width: 50%;
			}
			.config fieldset .zong .you {
				display: inline-block;
				width: 50%;
			}
			@media screen and (max-width: 1300px){
				.config fieldset .zong .zuo {
					width: 100%;
				}
				.config fieldset .zong .you {
					width: 100%;
				}
			}
			@media screen and (max-width: 500px){
				.config {
					margin: 10px;
				}
				.config fieldset {
					margin: 30px 0;
					padding: 0;
				}
				.server input {
					margin: 15px 0;
					width: calc(100% - 22px);
				}
			}
		</style>
	</head>
	<body>
		<div class="config">
			<fieldset>
				<legend>网站选项</legend>
				<div class="zong">
					<div class="zuo">
						<div class="server"><span>网站名字：</span><input type="text" value="{echo:[config.serverName]}" id="serverName" /></div>
						<div class="server"><span>网站域名：</span><input type="text" value="{echo:[config.domain]}" id="domain" /></div>
						<div class="server"><span>初始金币：</span><input type="text" value="{echo:[config.initial_money]}" id="initial_money" /></div>
						<div class="server"><span>签到金币：</span><input type="text" value="{echo:[config.sign_in_money]}" id="sign_in_money" /></div>
					</div>
					<div class="you">
						<div class="server"><span>首页地址：</span><input type="text" value="{echo:[config.home]}" id="home" /></div>
						<div class="server"><span>注册地址：</span><input type="text" value="{echo:[config.register]}" id="register" /></div>
						<div class="server"><span>认证地址：</span><input type="text" value="{echo:[config.Yggdrasil]}" id="Yggdrasil" /></div>
						<div class="server"><span>下载地址：</span><input type="text" value="{echo:[config.download]}" id="download" /></div>
					</div>
				</div>
				<button onclick="server()">保存</button>
			</fieldset>
			<fieldset>
				<legend>RCON</legend>
				<div class="zong">
					<div class="zuo">
						<div class="server"><span>地　　址：</span><input type="text" value="{echo:[mc_rcon_information.host]}" id="host" /></div>
						<div class="server"><span>端　　口：</span><input type="text" value="{echo:[mc_rcon_information.post]}" id="post" /></div>
					</div>
					<div class="you">
						<div class="server"><span>密　　码：</span><input type="text" value="{echo:[mc_rcon_information.pwd]}" id="pwd" /></div>
						<div class="server"><span>超时时间：</span><input type="text" value="{echo:[mc_rcon_information.time]}" id="time" /></div>
					</div>
				</div>
				<button onclick="rcon()">保存</button>
			</fieldset>
			<fieldset>
				<legend>编辑RSA秘钥</legend>
				<div class="zong RSA">
					<div class="zuo">
						<p>私钥</p>
						<textarea name='private'>{echo:[mc_rsa.private]}</textarea>
					</div>
					<div class="you">
						<p>公钥</p>
						<textarea name='public'>{echo:[mc_rsa.public]}</textarea>
					</div>
				</div>
				<button onclick="rsa()">保存</button>
			</fieldset>
		</div>
	</body>
</html>