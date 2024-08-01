<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_items');
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<script src="js/jquery.min.js"></script>
		<script src="js/goods.js"></script>
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
		<div class="message"><?php include('includes/message.html') ?></div>
		<div class="scrollbar"><?php include('includes/scrollbar.html') ?></div>
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
				<tbody foreach(var.mc_items,var.key,var.value) id="{echo:var.value.name}">
					<tr>
						<td>{echo:var.value.name}</td>
						<td>{echo:var.value.price}</td>
						<td><span onclick="confirm('{echo:var.value.name}','{echo:var.value.name}','{echo:var.value.price}')">购买</span></td>
					</tr>
				</tbody>
			</table>
		</div>
	</body>
</html>