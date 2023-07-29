<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_prop');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<script src="js/jquery.min.js"></script>
		<script src="js/tips.js"></script>
		<script>
			var prop_id    = false;
			var prop_name  = false;
			var prop_price = false;
			
			
			function determine()
			{
				if(prop_id && prop_name && prop_price)
				{
					$.getJSON("/weiw/index.php?{echo:token}",{"mods":"mc_prop_purchase","id":prop_id},function (result){
						window.parent.$(".signIn .money").html(result.bi);
						tips(result.error);
					});
				}
				
				confirm();
			}
			
			
			function confirm(id,name,price)
			{
				if(id && name && price)
				{
					prop_id    = id;
					prop_name  = name;
					prop_price = price;
					$(".confirm .text span").text(`确定要花费${price}金币，购买${name}吗？`);
					$(".confirm").fadeIn();
					$("body").css('padding-right', '0');
					$("body").css('overflow-x', 'hidden');
					$("body").css('overflow-y', 'hidden');
				}
				else
				{
					prop_id    = false;
					prop_name  = false;
					prop_price = false;
					$(".confirm").fadeOut();
					$("body").css('padding-right', '5px');
					$("body").css('overflow-x', 'auto');
					$("body").css('overflow-y', 'scroll');
				}
			}
		</script>
		<style>
			.confirm {
				position: fixed;
				top:   0;
				right: 0;
				z-index: 99;
				display: none;
				width: 	100%;
				height: 100%;
			}
			.confirm .background {
				background-color: rgba(0,0,0,0.7);
				position: absolute;
				cursor: pointer;
				width:  100%;
				height: 100%;
			}
			.confirm svg {
				position: absolute;
				top:   5px;
				right: 5px;
				x-index: 1;
				cursor: pointer;
				width:  20px;
				height: 20px;
			}
			.confirm svg path {
				fill: #008080;
			}
			.confirm svg:hover path {
				fill: #ff0000;
			}
			.confirm .padding {
				padding: 0 10px;
				height: 100%;
			}
			.confirm .padding .margin {
				background-color: #FFFFFF;
				border-radius: 10px;
				position: relative;
				top: 50%;
				x-index: 1;
				text-align: center;
				overflow: hidden;
				margin: -150px auto 0 auto;
				max-width: 500px;
			}
			.confirm .padding .margin .text {
				padding: 50px 10px;
			}
			.confirm .padding .margin .Button {
				background-color: #008080;
				height: 40px;
				line-height: 40px;
				color: #FFFFFF;
				cursor: pointer;
			}
			.rcons {
				padding: 50px;
				padding-bottom: 50px;
				border-radius: 5px;
				background: radial-gradient(#666,#555);
			}
			.rcons span {
				display: inline-block;
				cursor: pointer;
				width: 35px;
				height: 60px;
				line-height: 60px;
			}
			.rcons table {
				width: 100%;
				height: 100%;
				border-collapse: collapse;
			}
			.rcons table td {
				max-width: 150px;
				white-space: nowrap;
				overflow: hidden;
				text-overflow: ellipsis;
				padding: 0 20px;
				height: 60px;
			}
			.rcons table td:last-child {
				text-overflow: clip;
				width: 35px;
				text-align: right;
			}
			.rcons table thead {
				color: #ddd;
				background-color: #666;
			}
			.rcons table tbody {
				color: #ddd;
				border-bottom: 1px solid #666;
			}
			.rcons table tbody:hover {
				color: #ddd;
				background-color: #666;
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
		<div class="confirm">
			<div class="background" onclick="confirm()"></div>
			<div class="padding">
				<div class="margin">
					<div class="text">
						<svg onclick="confirm()" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M576 512l277.333333 277.333333-64 64-277.333333-277.333333L234.666667 853.333333 170.666667 789.333333l277.333333-277.333333L170.666667 234.666667 234.666667 170.666667l277.333333 277.333333L789.333333 170.666667 853.333333 234.666667 576 512z"></path></svg>
						<span></span>
					</div>
					<div class="Button" onclick="determine()">
						<span>立即购买</span>
					</div>
				</div>
			</div>
		</div>
		<div class="rcons">
			<table>
				<thead>
					<tr>
						<td>道具名称</td>
						<td>价格</td>
						<td>操作</td>
					</tr>
				</thead>
				<tbody foreach([mc_prop],[value]): id="{Print:value:name}">
					<tr>
						<td>{Print:value:name}</td>
						<td>{Print:value:price}</td>
						<td><span onclick="confirm('{Print:value:name}','{Print:value:name}','{Print:value:price}')">购买</span></td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>
</html>