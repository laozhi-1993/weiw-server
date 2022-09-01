<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_admin');
	$MKH ->mods('mc_prop');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<title>RCON 道具</title>
		<script>
			var html = '';
			var text = '';
			var stateadd    = true;
			var statemodify = true;
			var statedelete = true;
			$(function (){
				html = $(".rconmodify").html();
			});
			
			function rconadd(zt)
			{
				if(zt)
				{
					$(".rconadd").fadeIn();
					$(".rconadd .position").animate({"top":"200px"},200);
				}
				else
				{
					$(".rconadd").hide();
					$(".rconadd .position").css({"top":"150px"});
					$(".rconadd .error").text('');
				}
			}
			function rconmodify(zt,id)
			{
				if(zt)
				{
					text   = html;
					result = {};
					result['id']       = id;
					result['name']     = $("#"+id+"_1").html();
					result['describe'] = $("#"+id+"_2").html();
					result['price']    = $("#"+id+"_3").html();
					result['command']  = $("#"+id+"_4").html();
					
					$.each(result,function (key,value){
						reg  = new RegExp("{"+key+"}",'g');
						text = text.replace(reg,value);
					});
					
					
					$(".rconmodify").html(text);
					$(".rconmodify").fadeIn();
					$(".rconmodify .position").animate({"top":"200px"},200);
				}
				else
				{
					$(".rconmodify").hide();
					$(".rconmodify .position").css({"top":"150px"});
					$(".rconmodify .error").text('');
				}
			}
			function add()
			{
				if(stateadd && !(stateadd = false))
				{
					url = {"mods":"mc_prop_add"};
					url['name']     = $(".rconadd input[name=name]").val();
					url['describe'] = $(".rconadd input[name=describe]").val();
					url['price']    = $(".rconadd input[name=price]").val();
					url['command']  = $(".rconadd input[name=command]").val();
					$.getJSON("/weiw/index.php?{echo:token}",url,function (result){
						if(result.error == '添加完成')
						{
							window.location.reload();
						}
						else
						{
							$(".rconadd .error").text(result.error);
						}
						
						rconadd(false);
						stateadd = true;
					});
				}
			}
			function modify(id)
			{
				if(statemodify && !(statemodify = false))
				{
					url = {"mods":"mc_prop_modify"};
					url['id']       = id;
					url['name']     = $(".rconmodify input[name=name]").val();
					url['describe'] = $(".rconmodify input[name=describe]").val();
					url['price']    = $(".rconmodify input[name=price]").val();
					url['command']  = $(".rconmodify input[name=command]").val();
					$.getJSON("/weiw/index.php?{echo:token}",url,function (result){
						if(result.error == '修改完成')
						{
							window.location.reload();
						}
						else
						{
							$(".rconmodify .error").text(result.error);
						}
						
						rconmodify(false);
						statemodify = true;
					});
				}
			}
			function rcondelete(id)
			{
				if(statedelete && !(statedelete = false))
				{
					if(confirm("确定要删除吗？"))
					{
						url = {"mods":"mc_prop_delete"};
						url['id'] = id;
						$.getJSON("/weiw/index.php?{echo:token}",url,function (result){
							if(result.error == '删除完成')
							{
								window.location.reload();
							}
							else
							{
								tips(result.error);
							}
							
							rconmodify(false);
							statedelete = true;
						});
					}
					else
					{
						statedelete = true;
					}
				}
			}
		</script>
		<style>
			.rcon {
				position: fixed;
				top:   0;
				right: 0;
				z-index: 99;
				background-color: rgba(0,0,0,0.7);
				width:  100%;
				height: 100%;
				display: none;
			}
			.rcon .position {
				position: absolute;
				top: 150px;
				z-index: 1;
				width: 100%;
			}
			.rcon .position .data {
				margin: 0 auto;
				max-width: 500px;
				min-height: 300px;
				background-color: #FFFFFF;
				border-radius: 5px;
			}
			.rcon .position .data .content {
				margin: 30px;
				height: calc(100% - 160px);
			}
			.rcon .position .data .content .input {
				margin: 0px;
				padding: 5px 10px;
			}
			.rcon .position .data .content .input span {
				display: inline-block;
				width: 80px;
				height: 37px;
				line-height: 37px;
				padding: 0 10px;
				background-color: #f5f5f5;
				border-radius: 5px;
			}
			.rcon .position .data .content .input input {
				display: inline-block;
				width: calc(100% - 130px);
				height: 35px;
				padding: 0 10px;
				vertical-align: top;
				border: 1px solid #000000;
				border-radius: 5px;
			}
			.rcon .position .data .head {
				padding: 0 20px;
				height: 49px;
				line-height: 49px;
				border-bottom: 1px solid #eae9ef;
				text-align: center;
				color: #855465;
			}
			.rcon .position .data .operation {
				height: 49px;
				border-top: 1px solid #eae9ef;
				padding: 0 20px;
				text-align: right;
				user-select: none;
			}
			.rcon .position .data .operation .error {
				display: inline-block;
				color: #ff0000;
				padding: 0 10px;
			}
			.rcon .position .data .operation .close {
				background-color: #9c9c9c;
				border-radius: 5px;
				color: #FFFFFF;
				cursor: pointer;
				margin:  10px 0px;
				padding: 0;
				width: 60px;
				height: 30px;
				line-height: 30px;
				display: inline-block;
				text-align: center;
			}
			.rcon .position .data .operation .delete {
				background-color: #ff0000;
				border-radius: 5px;
				color: #FFFFFF;
				cursor: pointer;
				margin:  10px 0px;
				padding: 0;
				width: 60px;
				height: 30px;
				line-height: 30px;
				display: inline-block;
				text-align: center;
			}
			.rcon .position .data .operation .confirm {
				background-color: #ff00ff;
				border-radius: 5px;
				color: #FFFFFF;
				cursor: pointer;
				margin:  10px 0;
				padding: 0;
				width: 60px;
				height: 30px;
				line-height: 30px;
				display: inline-block;
				text-align: center;
			}
			
			.rcons {
				margin: 50px;
				margin-top: 20px;
			}
			.rcons .list {
				padding: 50px;
				padding-top: 30px;
				background-color: #FFFFFF;
				border-radius: 10px;
				box-shadow: 0 0 5px 0px #a7f6f6;
			}
			.rcons .list span {
				display: inline-block;
				cursor: pointer;
				width: 35px;
				height: 60px;
				line-height: 60px;
			}
			.rcons .list .add {
				background-color: #ff00ff;
				border-radius: 5px;
				display: inline-block;
				color: #FFFFFF;
				cursor: pointer;
				user-select: none;
				padding: 10px 15px;
				margin: 20px 0;
				margin-top: 0;
			}
			.rcons .list .add:hover {
				animation-name: anniu;
				animation-duration: 0.3s;
				animation-timing-function: ease-in;
				background-color: #cc00cc;
			}
			.rcons .list table {
				table-layout: fixed;
				width: 100%;
				border-collapse: collapse;
			}
			.rcons .list table td {
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
				padding: 0 20px;
				height: 60px;
			}
			.rcons .list table td:last-child {
				width: 35px;
				text-align: right;
			}
			.rcons .list table thead {
				color: #e541e5;
				border-bottom: 1px solid #eae9ef;
				background-color: #edf6f5;
			}
			.rcons .list table tbody {
				color: #00808c;
				border-bottom: 1px solid #eae9ef;
			}
			.rcons .list table tbody:hover {
				animation-name: tbody;
				animation-duration: 0.3s;
				animation-timing-function: ease-in;
				background-color: #edf6f5;
			}
			@keyframes tbody {
				0%   {background-color: #FFFFFF;}
				100% {background-color: #edf6f5;}
			}
			@keyframes anniu {
				0%   {background-color: #ff00ff;}
				100% {background-color: #cc00cc;}
			}
			@media screen and (max-width: 1200px) {
				.rcons .list table td:nth-child(4) {
					display: none;
				}
			}
			@media screen and (max-width: 1100px) {
				.rcons .list table td:nth-child(3) {
					display: none;
				}
			}
			@media screen and (max-width: 1000px) {
				.rcons .list table td:nth-child(2) {
					display: none;
				}
			}
			@media screen and (max-height: 600px) {
				.rcon .position {
					top: auto!important;
					bottom: 5px;
				}
			}
			@media screen and (max-width: 500px) {
				.rcon .position .data .content {
					margin: 5px;
					height: calc(100% - 160px);
				}
				.rcons {
					margin: 5px;
				}
				.rcons .list {
					padding: 20px;
					border-radius: 5px;
				}
			}
		</style>
	</head>
	<body>
		<div class="rcon rconadd">
			<div class="position">
				<div class="data">
					<div class="head">添加道具</div>
					<div class="content">
						<div class="input">
							<span>名称</span>
							<input type="text" name="name" />
						</div>
						<div class="input">
							<span>描述</span>
							<input type="text" name="describe" />
						</div>
						<div class="input">
							<span>价格</span>
							<input type="number" name="price" />
						</div>
						<div class="input">
							<span>命令</span>
							<input type="text" name="command" />
						</div>
					</div>
					<div class="operation">
						<div class="error"></div>
						<div class="close" onclick="rconadd(false)">关闭</div>
						<div class="confirm" onclick="add()">添加</div>
					</div>
				</div>
			</div>
		</div>
		<div class="rcon rconmodify">
			<div class="position">
				<div class="data">
					<div class="head">修改道具</div>
					<div class="content">
						<div class="input">
							<span>名称</span>
							<input type="text" name="name" value="{name}" />
						</div>
						<div class="input">
							<span>描述</span>
							<input type="text" name="describe" value="{describe}" />
						</div>
						<div class="input">
							<span>价格</span>
							<input type="number" name="price" value="{price}" />
						</div>
						<div class="input">
							<span>命令</span>
							<input type="text" name="command" value="{command}" />
						</div>
					</div>
					<div class="operation">
						<div class="error"></div>
						<div class="close" onclick="rconmodify(false)">关闭</div>
						<div class="delete" onclick="rcondelete('{id}')">删除</div>
						<div class="confirm" onclick="modify('{id}')">修改</div>
					</div>
				</div>
			</div>
		</div>
		<div class="rcons">
			<div class="list">
				<div class="add" onclick="rconadd(true)">添加道具</div>
				<table>
					<thead>
						<tr>
							<td>名称</td>
							<td>描述</td>
							<td>价格</td>
							<td>命令</td>
							<td>操作</td>
						</tr>
					</thead>
					<tbody foreach([mc_prop],[value]): id="{echo:[value.id]}">
						<tr>
							<td id="{echo:[value.id]}_1">{echo:[value.name]}</td>
							<td id="{echo:[value.id]}_2">{echo:[value.describe]}</td>
							<td id="{echo:[value.id]}_3">{echo:[value.price]}</td>
							<td id="{echo:[value.id]}_4">{echo:[value.command]}</td>
							<td><span onclick="rconmodify(true,'{echo:[value.id]}')">编辑</span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>