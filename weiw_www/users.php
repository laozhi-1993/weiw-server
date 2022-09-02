<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_admin');
	$MKH ->mods('mc_users');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<title>用户管理</title>
		<script>
			var html = '';
			var text = '';
			$(function (){
				html = $(".user").html();
			});
			
			
			function user(name)
			{
				if(name)
				{
					text = html;
					$.getJSON("/weiw/index.php?{echo:token}",{"mods":"mc_user_data","name":name},function (result){
						if(result.error)
						{
							tips(result.error);
						}
						else
						{
							$.each(result,function (key,value){
								reg  = new RegExp("{"+key+"}",'g');
								text = text.replace(reg,value);
							});
							
							
							$(".user").html(text);
							$(".user").show();
						}
					});
				}
				else
				{
					$(".user").hide();
				}
			}
			
			
			function modify(name)
			{
				text = html;
				$.getJSON("/weiw/index.php?{echo:token}",{"mods":"mc_user_data","name":name,"bi":$("#modify").val()},function (result){
					if(result.error)
					{
						tips(result.error);
					}
					else
					{
						$.each(result,function (key,value){
							reg  = new RegExp("{"+key+"}",'g');
							text = text.replace(reg,value);
						});
						
						
						$(".user").html(text);
						$(".modify").hide();
					}
				});
			}
		</script>
		<style>
			.user {
				position: fixed;
				top:   0;
				right: 0;
				z-index: 99;
				display: none;
				width:  100%;
				height: 100%;
				background-color: rgba(0,0,0,0.8);
			}
			.user .position {
				position: absolute;
				top: 150px;
				z-index: 1;
				width: 100%;
			}
			.user .data {
				margin: 10px auto;
				max-width:  500px;
				background-color: #FFFFFF;
				border-radius: 5px;
				overflow: hidden;
			}
			.user .data button {
				background-color: #a15ab2;
				border: none;
				color: #FFFFFF;
				cursor: pointer;
				width:  100%;
				height: 40px;
			}
			.user .data button:hover {
				background-color: #656598;
				color: #FFFFFF;
			}
			.user .data svg {
				width: 	20px;
				height: 20px;
				vertical-align: top;
				cursor: pointer;
			}
			.user .data svg path {
				fill: #91B1D5;
			}
			.user .data .margin {
				margin: 30px;
			}
			.user .data table {
				width: 100%;
			}
			.user .data table caption {
				margin: 20px;
				margin-top: 0;
				color: #e541e5;
				font-size: x-large;
			}
			.user .data table td {
				color: #00808c;
				padding: 5px 0;
			}
			.user .data table td:first-child {
				color: #e541e5;
				width: 80px;
			}
			.user .modify {
				display: none;
				max-width: 500px;
				margin: 0 auto;
				background-color: #FFFFFF;
				border-radius: 5px;
			}
			.user .modify .margin {
				padding: 20px 30px;
			}
			.user .modify input {
				border: 1px solid #eae9ef;
				border-radius: 5px;
				padding: 0 5px;
				width:  calc(100% - 80px);
				height: 30px;
			}
			.user .modify button {
				background-color: #ff00ff;
				border: 1px solid #ff00ff;
				border-radius: 5px;
				width:  60px;
				height: 30px;
				cursor: pointer;
				color: #FFFFFF;
			}
			.user .modify button:hover {
				animation-name: anniu;
				animation-duration: 0.3s;
				animation-timing-function: ease-in;
				background-color: #cc00cc;
			}
			.users {
				margin: 50px;
				margin-top: 20px;
			}
			.users .lookup {
				padding: 78px 0 30px 0;
				background-color: #F4F6F9;
				max-width: 600px;
				margin: 0 auto;
			}
			.users .lookup .margin {
				position: relative;
				font-size: 0;
			}
			.users .lookup .margin input {
				width: calc(100% - 112px);
				padding: 0 10px;
				height: 40px;
				line-height: 40px;
				font-size: large;
				border: 1px solid #FF00FF;
				border-radius: 5px 0 0 5px;
				background-color: #E8F0FE;
			}
			.users .lookup .margin input:focus {
				outline: none;
			}
			.users .lookup .margin button {
				position: absolute;
				right: 0;
				width:  90px;
				height: 42px;
				line-height: 40px;
				font-size: medium;
				color: #FFFFFF;
				cursor: pointer;
				border: none;
				border-radius: 0 5px 5px 0;
				background-color: #FF00FF;
			}
			.users .lookup .margin button:hover {
				animation-name: anniu;
				animation-duration: 0.3s;
				animation-timing-function: ease-in;
				background-color: #cc00cc;
			}
			.users .list {
				padding: 50px;
				padding-top: 30px;
				background-color: #FFFFFF;
				border-radius: 10px;
				box-shadow: 0 0 5px 0px #a7f6f6;
			}
			.users .list .number {
				position: relative;
				height: 50px;
				font-size: large;
				color: #1f4f4e;
			}
			.users .list .number-user {
				position: absolute;
				top:  0;
				left: 0;
			}
			.users .list .number-page {
				position: absolute;
				top:   0;
				right: 0;
			}
			.users .list span {
				display: block;
				cursor: pointer;
				width: 35px;
				height: 60px;
				line-height: 60px;
			}
			.users .list table {
				table-layout: fixed;
				width: 100%;
				border-collapse: collapse;
			}
			.users .list table td {
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
				padding: 0 20px;
				height: 60px;
			}
			.users .list table td:last-child {
				width: 35px;
			}
			.users .list table thead {
				color: #e541e5;
				border-bottom: 1px solid #eae9ef;
				background-color: #edf6f5;
			}
			.users .list table tbody {
				color: #00808c;
				border-bottom: 1px solid #eae9ef;
			}
			.users .list table tbody:hover {
				animation-name: tbody;
				animation-duration: 0.3s;
				animation-timing-function: ease-in;
				background-color: #edf6f5;
			}
			.page {
				margin: 20px auto;
				text-align: center;
				font-size: 0;
			}
			.page a {
				display: inline-block;
				padding: 10px 20px;
				font-size: medium;
				cursor: pointer;
				color: #f7f7ff;
				text-decoration-line: none;
			}
			.page a:hover {
				animation-name: anniu;
				animation-duration: 0.3s;
				animation-timing-function: ease-in;
				background-color: #cc00cc;
			}
			.page .s {
				background-color: #ff00ff;
				border-radius: 5px 0 0 5px;
			}
			.page .x {
				background-color: #ff00ff;
				border-radius: 0 5px 5px 0;
			}
			@keyframes tbody {
				0%   {background-color: #FFFFFF;}
				100% {background-color: #edf6f5;}
			}
			@keyframes anniu {
				0%   {background-color: #ff00ff;}
				100% {background-color: #cc00cc;}
			}
			@media screen and (max-width: 1800px) {
				.users .list table td:nth-child(6) {
					display: none;
				}
			}
			@media screen and (max-width: 1500px) {
				.users .list table td:nth-child(5) {
					display: none;
				}
			}
			@media screen and (max-width: 1200px) {
				.users .list table td:nth-child(4) {
					display: none;
				}
			}
			@media screen and (max-width: 1100px) {
				.users .list table td:nth-child(3) {
					display: none;
				}
			}
			@media screen and (max-width: 1000px) {
				.users .list table td:nth-child(2) {
					display: none;
				}
			}
			@media screen and (max-height: 600px) {
				.user .position {
					top: auto;
					bottom: 10px;
				}
			}
			@media screen and (max-width: 500px) {
				.users {
					margin: 5px;
					margin-top: 0px;
				}
				.users .list {
					padding: 20px;
					border-radius: 5px;
				}
				.users .lookup {
					padding: 5px 0;
				}
				.users .lookup .margin {
					max-width: 600px;
				}
			}
		</style>
	</head>
	<body>
		<div class="user">
			<div class="position">
				<div class="data">
					<div class="margin">
						<table>
							<caption>用户信息</caption>
							<tr>
								<td>用户名称：</td>
								<td>{name}</td>
							</tr>
							<tr>
								<td>邮箱地址：</td>
								<td>{email}</td>
							</tr>
							<tr>
								<td>金钱数量：</td>
								<td>{bi} <span title="修改金钱" onclick="$('.modify').toggle()">{include:"icons/modify.svg"}</span></td>
							</tr>
							<tr>
								<td>登录IP：</td>
								<td>{login_ip}</td>
							</tr>
							<tr>
								<td>登录时间：</td>
								<td>{login_time}</td>
							</tr>
							<tr>
								<td>注册时间：</td>
								<td>{register_time}</td>
							</tr>
						</table>
					</div>
					<button onclick="user()">关闭</button>
				</div>
				<div class="modify">
					<div class="margin">
						<input type="number" value="{bi}" id="modify" />
						<button onclick="modify('{name}')">保存</button>
					</div>
				</div>
			</div>
		</div>
		<div class="users">
			<div class="lookup">
				<div class="margin">
					<input type="text" placeholder="名称" id="user" />
					<button onclick="user($('#user').val())">查找</button>
				</div>
			</div>
			<div class="list">
				<div class="number">
					<div class="number-user">总共 {echo:[mc_users.number]} 个用户</div>
					<div class="number-page">第 {echo:[mc_users.page.total]}/{echo:[mc_users.page.current]} 页</div>
				</div>
				<table>
					<thead>
						<tr>
							<td>名称</td>
							<td>邮箱</td>
							<td>金币</td>
							<td>登陆IP</td>
							<td>登陆时间</td>
							<td>注册时间</td>
							<td>操作</td>
						</tr>
					</thead>
					<tbody foreach([mc_users.users],[value]):>
						<tr>
							<td>{echo:[value.name]}</td>
							<td>{echo:[value.email]}</td>
							<td>{echo:[value.bi]}</td>
							<td>{echo:[value.login_ip]}</td>
							<td>{echo:[value.login_time]}</td>
							<td>{echo:[value.register_time]}</td>
							<td><span onclick="user('{echo:[value.name]}')">编辑</span></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="page">
				<a href="{URL:[index]:[mc_users.page.s]}" class="s">&lt;上一页</a>
				<a href="{URL:[index]:[mc_users.page.x]}" class="x">下一页&gt;</a>
			</div>
		</div>
	</body>
</html>