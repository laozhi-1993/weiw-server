<?php defined('__MKHDIR__') or die(http_response_code(403)) ?><!DOCTYPE html>
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
		<includes-message>	<script src="js/message.js"></script>
	<div class="result">
		<style>
			.result {
				position: relative;
				top: 0;
				left: 0;
				z-index: 1;
				width: 100%;
			}
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
				<span title="关闭" onclick="removeMessage({id})">X</span>
			</div>
		</data>
	</div></includes-message>
		<includes-scrollbar>	<style>
		::-webkit-scrollbar {width: 6px}
		::-webkit-scrollbar {height: 6px}
		::-webkit-scrollbar-track {border-radius: 3px}
		::-webkit-scrollbar-track {background-color: #fff}
		::-webkit-scrollbar-thumb {border-radius: 3px}
		::-webkit-scrollbar-thumb {background-color: #999}
		body {overflow-y: scroll}
		body {padding-right: 5px}
		body {margin: 0}
	</style></includes-scrollbar>
		<div class="config">
			<fieldset>
				<legend>网站选项</legend>
				<div class="zong">
					<div class="zuo">
						<div class="server"><span>网站名字</span><input type="text" value="<?php if(isset($this->Unified['mc_config']['config']['serverName'])): ?><?php echo $this->Unified['mc_config']['config']['serverName'] ?><?php endif; ?>" id="serverName" /></div>
						<div class="server"><span>网站域名</span><input type="text" value="<?php if(isset($this->Unified['mc_config']['config']['domain'])): ?><?php echo $this->Unified['mc_config']['config']['domain'] ?><?php endif; ?>" id="domain" /></div>
						<div class="server"><span>认证地址</span><input type="text" value="<?php if(isset($this->Unified['mc_config']['config']['authUrl'])): ?><?php echo $this->Unified['mc_config']['config']['authUrl'] ?><?php endif; ?>" id="authUrl" /></div>
					</div>
					<div class="you">
						<div class="server"><span>下载地址</span><input type="text" value="<?php if(isset($this->Unified['mc_config']['config']['download'])): ?><?php echo $this->Unified['mc_config']['config']['download'] ?><?php endif; ?>" id="download" /></div>
						<div class="server"><span>初始金钱</span><input type="text" value="<?php if(isset($this->Unified['mc_config']['config']['defaultMoney'])): ?><?php echo $this->Unified['mc_config']['config']['defaultMoney'] ?><?php endif; ?>" id="defaultMoney" /></div>
						<div class="server"><span>签到金钱</span><input type="text" value="<?php if(isset($this->Unified['mc_config']['config']['checkinMoney'])): ?><?php echo $this->Unified['mc_config']['config']['checkinMoney'] ?><?php endif; ?>" id="checkinMoney" /></div>
					</div>
				</div>
				<button onclick="server()">保存</button>
			</fieldset>
			<fieldset>
				<legend>编辑道具</legend>
				<div class="zong">
					<div class="items">
						<textarea name='items'><?php if(isset($this->Unified['mc_config']['items'])): ?><?php echo $this->Unified['mc_config']['items'] ?><?php endif; ?></textarea>
					</div>
				</div>
				<button onclick="items()">保存</button>
			</fieldset>
			<fieldset>
				<legend>RCON</legend>
				<div class="zong">
					<div class="zuo">
						<div class="server"><span>地　　址</span><input type="text" value="<?php if(isset($this->Unified['mc_config']['rcon']['host'])): ?><?php echo $this->Unified['mc_config']['rcon']['host'] ?><?php endif; ?>" id="host" /></div>
						<div class="server"><span>端　　口</span><input type="text" value="<?php if(isset($this->Unified['mc_config']['rcon']['post'])): ?><?php echo $this->Unified['mc_config']['rcon']['post'] ?><?php endif; ?>" id="post" /></div>
					</div>
					<div class="you">
						<div class="server"><span>密　　码</span><input type="text" value="<?php if(isset($this->Unified['mc_config']['rcon']['password'])): ?><?php echo $this->Unified['mc_config']['rcon']['password'] ?><?php endif; ?>" id="password" /></div>
						<div class="server"><span>超时时间</span><input type="text" value="<?php if(isset($this->Unified['mc_config']['rcon']['time'])): ?><?php echo $this->Unified['mc_config']['rcon']['time'] ?><?php endif; ?>" id="time" /></div>
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
							<textarea name='private'><?php if(isset($this->Unified['mc_config']['rsa']['private'])): ?><?php echo $this->Unified['mc_config']['rsa']['private'] ?><?php endif; ?></textarea>
						</div>
					</div>
					<div class="you">
						<div class="RSA">
							<p>公钥</p>
							<textarea name='public'><?php if(isset($this->Unified['mc_config']['rsa']['public'])): ?><?php echo $this->Unified['mc_config']['rsa']['public'] ?><?php endif; ?></textarea>
						</div>
					</div>
				</div>
				<button onclick="rsa()">保存</button>
			</fieldset>
		</div>
	</body>
</html>