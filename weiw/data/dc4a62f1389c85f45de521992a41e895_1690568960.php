<?php defined('__MKHDIR__') or die(http_response_code(404)) ?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<script src="js/jquery.min.js"></script>
		<script src="js/tips.js"></script>
		<script>
			function server()
			{
				url = {"mods":"mc_set_server"};
				url['serverName']    = $("#serverName").val();
				url['domain']        = $("#domain").val();
				url['download']      = $("#download").val();
				url['Yggdrasil']     = $("#Yggdrasil").val();
				url['initial_money'] = $("#initial_money").val();
				url['sign_in_money'] = $("#sign_in_money").val();
				url['user_dir']      = $("#user_dir").val();
				url['textures_dir']  = $("#textures_dir").val();
				$.getJSON("/weiw/index.php?<?php echo token ?>",url,function (result){
					tips(result.error);
				});
			}
			function rcon()
			{
				url = {"mods":"mc_set_rcon"};
				url['host'] = $("#host").val();
				url['post'] = $("#post").val();
				url['pwd']  = $("#pwd").val();
				url['time'] = $("#time").val();
				$.getJSON("/weiw/index.php?<?php echo token ?>",url,function (result){
					tips(result.error);
				});
			}
			function smtp()
			{
				url = {"mods":"mc_set_smtp"};
				url['server']     = $("#server").val();
				url['serverport'] = $("#serverport").val();
				url['usermail']   = $("#usermail").val();
				url['user']       = $("#user").val();
				url['password']   = $("#password").val();
				$.getJSON("/weiw/index.php?<?php echo token ?>",url,function (result){
					tips(result.error);
				});
			}
			function rsa()
			{
				url = {"mods":"mc_set_rsa"};
				url['private'] = $("textarea[name='private']").val();
				url['public']  = $("textarea[name='public']").val();
				$.getJSON("/weiw/index.php?<?php echo token ?>",url,function (result){
					tips(result.error);
				});
			}
			function prop()
			{
				url = {"mods":"mc_set_prop"};
				url['value'] = $("textarea[name='prop']").val();
				$.getJSON("/weiw/index.php?<?php echo token ?>",url,function (result){
					tips(result.error);
				});
			}
		</script>
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
			.prop {
				margin: 0 10px;
			}
			.prop textarea {
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
		<div class="result">
			<style>
				.result data {
					display: none;
				}
				.result div {
					margin-bottom: 10px;
					position: relative;
					padding: 10px;
					padding-right: 30px;
					background-color: #FFFFFF;
					border-radius: 5px;
				}
				.result div span:first-child {
					color: #52808C;
				}
				.result div span:last-child {
					position: absolute;
					top: 0;
					right: 5px;
					display: inline-block;
					cursor: pointer;
					padding: 10px;
					color: #52808C;
				}
			</style>
			<data>
				<div id="{id}">
					<span>{error}</span>
					<span title="关闭" onclick="tips_remove({id})">X</span>
				</div>
			</data>
		</div>
		<div class="config">
			<fieldset>
				<legend>网站选项</legend>
				<div class="zong">
					<div class="zuo">
						<div class="server"><span>网站名字</span><input type="text" value="<?php echo $this->_Unified['config']['serverName'] ?>" id="serverName" /></div>
						<div class="server"><span>网站域名</span><input type="text" value="<?php echo $this->_Unified['config']['domain'] ?>" id="domain" /></div>
						<div class="server"><span>认证地址</span><input type="text" value="<?php echo $this->_Unified['config']['Yggdrasil'] ?>" id="Yggdrasil" /></div>
						<div class="server"><span>下载地址</span><input type="text" value="<?php echo $this->_Unified['config']['download'] ?>" id="download" /></div>
					</div>
					<div class="you">
						<div class="server"><span>初始金币</span><input type="text" value="<?php echo $this->_Unified['config']['initial_money'] ?>" id="initial_money" /></div>
						<div class="server"><span>签到金币</span><input type="text" value="<?php echo $this->_Unified['config']['sign_in_money'] ?>" id="sign_in_money" /></div>
						<div class="server"><span>用户目录</span><input type="text" value="<?php echo $this->_Unified['config']['user_dir'] ?>" id="user_dir" /></div>
						<div class="server"><span>材质目录</span><input type="text" value="<?php echo $this->_Unified['config']['textures_dir'] ?>" id="textures_dir" /></div>
					</div>
				</div>
				<button onclick="server()">保存</button>
			</fieldset>
			<fieldset>
				<legend>编辑道具</legend>
				<div class="zong">
					<div class="prop">
						<textarea name='prop'><?php echo $this->_Unified['mc_set_prop'] ?></textarea>
					</div>
				</div>
				<button onclick="prop()">保存</button>
			</fieldset>
			<fieldset>
				<legend>SMTP</legend>
				<div class="zong">
					<div class="zuo">
						<div class="server"><span>地　　址</span><input type="text" value="<?php echo $this->_Unified['mc_set_smtp']['server'] ?>" id="server" /></div>
						<div class="server"><span>端　　口</span><input type="text" value="<?php echo $this->_Unified['mc_set_smtp']['serverport'] ?>" id="serverport" /></div>
						<div class="server"><span>邮　　箱</span><input type="text" value="<?php echo $this->_Unified['mc_set_smtp']['usermail'] ?>" id="usermail" /></div>
					</div>
					<div class="you">
						<div class="server"><span>账　　号</span><input type="text" value="<?php echo $this->_Unified['mc_set_smtp']['user'] ?>" id="user" /></div>
						<div class="server"><span>密　　码</span><input type="text" value="<?php echo $this->_Unified['mc_set_smtp']['password'] ?>" id="password" /></div>
					</div>
				</div>
				<button onclick="smtp()">保存</button>
			</fieldset>
			<fieldset>
				<legend>RCON</legend>
				<div class="zong">
					<div class="zuo">
						<div class="server"><span>地　　址</span><input type="text" value="<?php echo $this->_Unified['mc_set_rcon']['host'] ?>" id="host" /></div>
						<div class="server"><span>端　　口</span><input type="text" value="<?php echo $this->_Unified['mc_set_rcon']['post'] ?>" id="post" /></div>
					</div>
					<div class="you">
						<div class="server"><span>密　　码</span><input type="text" value="<?php echo $this->_Unified['mc_set_rcon']['pwd'] ?>" id="pwd" /></div>
						<div class="server"><span>超时时间</span><input type="text" value="<?php echo $this->_Unified['mc_set_rcon']['time'] ?>" id="time" /></div>
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
							<textarea name='private'><?php echo $this->_Unified['mc_set_rsa']['private'] ?></textarea>
						</div>
					</div>
					<div class="you">
						<div class="RSA">
							<p>公钥</p>
							<textarea name='public'><?php echo $this->_Unified['mc_set_rsa']['public'] ?></textarea>
						</div>
					</div>
				</div>
				<button onclick="rsa()">保存</button>
			</fieldset>
		</div>
	</body>
</html>