<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_prop');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<title>购买道具</title>
		<script>
			var statepurchase = true;
			function purchase(id,name,price)
			{
				if(statepurchase && !(statepurchase = false))
				{
					if(confirm("确定要花费"+price+'金币购买"'+name+'"吗？'))
					{
						url = {"mods":"mc_prop_purchase"};
						url['id'] = id;
						$.getJSON("/weiw/index.php?{echo:token}",url,function (result){
							tips(result.error);
							statepurchase = true;
						});
					}
					else
					{
						statepurchase = true;
					}
				}
			}
		</script>
		<style>
			center h1 {
				color: #FF00FF;
				padding-top: 30px;
			}
			.rcons {
				margin: 50px;
				margin-top: 20px;
			}
			.rcons .list {
				padding: 50px;
				padding-top: 60px;
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
			@media screen and (max-width: 500px) {
				.rcon .position .data .content {
					margin: 5px;
					height: calc(100% - 160px);
				}
				.rcons {
					margin: 10px;
				}
				.rcons .list {
					padding: 20px;
					border-radius: 5px;
				}
			}
		</style>
	</head>
	<body>
		<center><h1>道具商店 </h1></center>
		<div class="rcons">
			<div class="list">
				<table>
					<thead>
						<tr>
							<td>名称</td>
							<td>描述</td>
							<td>价格</td>
							<td>操作</td>
						</tr>
					</thead>
					<tbody foreach([mc_prop],[value]): id="{echo:[value.id]}">
						<tr>
							<td>{echo:[value.name]}</td>
							<td>{echo:[value.describe]}</td>
							<td>{echo:[value.price]}</td>
							<td><span onclick="purchase('{echo:[value.id]}','{echo:[value.name]}','{echo:[value.price]}')">购买</span></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>