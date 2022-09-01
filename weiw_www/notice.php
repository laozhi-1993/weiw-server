<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_admin');
	$MKH ->mods('mc_notice');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<title>管理公告</title>
		<script>
			var current = false;
			var position = false;
			var range = false;
			var test = false;
			$(function (){
				cancel();
				document.getElementById("edit").onclick = aaa;
				document.onkeydown = function (e) {
					if(current && e.keyCode === 8)
					{
						if($(current).html() == "")
						{
							$(current).remove();
							current = false;
						}
					}
				}
			});
			function aaa()
			{
				startNode = document.querySelector("#test");
				range = window.getSelection();
				position = range.getRangeAt(0);
				//position.setStartAfter(range.anchorNode);
				//console.log(range.anchorNode);
			}
			function paste(text)
			{
				position.insertNode(position.createContextualFragment(text));
				range.collapseToEnd();
			}
			function cancel()
			{
				$(".add").hide();
				$(".region").attr("contenteditable","true");
				$(".region").focus(function (){ current = this });
			}
			function region()
			{
				background1 = $("#background1").val();
				background2 = $("#background2").val();
				background3 = $("#background3").val();
				time = +new Date();


				$("#edit").append('<div id="region_'+time+'" class="region" style="background-color: #'+background1+'; color: #'+background2+'; font-size: '+background3+'px;">文本</div>');
				$(".region").attr("contenteditable","true");
				cancel();
			}
			function button()
			{
				$(".region").attr("contenteditable","false");
				url = {};
				url['mods'] = 'mc_notice_change';
				url['content'] = $(".edit").html();
				$(".region").attr("contenteditable","true");
				$.getJSON("/weiw/index.php?{echo:token}",url,function (result){
					if(result.error == "ok")
					{
						tips("保存完成");
					}
					else tips(result.error);
				});
			}
		</script>
		<style>
			.notice {
				margin: 50px;
				height: 80%;
			}
			.notice .edit {
				background-color: #FFFFFF;
				border: 1px solid #cacad0;
				border-radius: 5px;
				min-height: 100%;
				margin: 5px 0;
				padding: 10px;
			}
			.region {
				margin: 10px;
				padding: 10px;
				border-radius: 10px;
			}
			.add {
				position: fixed;
				top:   0;
				right: 0;
				z-index: 99;
				background-color: rgba(0,0,0,0.7);
				width:  100%;
				height: 100%;
				display: none;
			}
			.add .position {
				position: absolute;
				top: 150px;
				z-index: 1;
				width: 100%;
			}
			.add .position .data {
				margin: 0 auto;
				max-width: 500px;
				min-height: 300px;
				background-color: #FFFFFF;
				border-radius: 5px;
			}
			.add .position .data .content {
				margin: 30px;
				height: calc(100% - 160px);
			}
			.add .position .data .content .input {
				margin: 0px;
				padding: 5px 10px;
			}
			.add .position .data .content .input span {
				display: inline-block;
				width: 80px;
				height: 37px;
				line-height: 37px;
				padding: 0 10px;
				background-color: #f5f5f5;
				border-radius: 5px;
			}
			.add .position .data .content .input input {
				display: inline-block;
				width: calc(100% - 130px);
				height: 35px;
				padding: 0 10px;
				vertical-align: top;
				border: 1px solid #000000;
				border-radius: 5px;
			}
			.add .position .data .head {
				padding: 0 20px;
				height: 49px;
				line-height: 49px;
				border-bottom: 1px solid #eae9ef;
				text-align: center;
				color: #855465;
			}
			.add .position .data .operation {
				height: 49px;
				border-top: 1px solid #eae9ef;
				padding: 0 20px;
				text-align: right;
				user-select: none;
			}
			.add .position .data .operation .close {
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
			.add .position .data .operation .delete {
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
			.add .position .data .operation .confirm {
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
		</style>
	</head>
	<body>
		<div class="add">
			<div class="position">
				<div class="data">
					<div class="head">添加背景</div>
					<div class="content">
						<div class="input">
							<span>背景颜色</span>
							<input type="text" id="background1" value="006d83"/>
						</div>
						<div class="input">
							<span>文字颜色</span>
							<input type="text" id="background2" value="FFFFFF"/>
						</div>
						<div class="input">
							<span>文字大小</span>
							<input type="number" id="background3" value="20"/>
						</div>
					</div>
					<div class="operation">
						<div class="close" onclick="cancel()">关闭</div>
						<div class="confirm" onclick="region()">完成</div>
					</div>
				</div>
			</div>
		</div>
		<div class="notice">
			<div class="edit" id="edit">
				{echo:[mc_notice.content]}
			</div>
			<button onclick="button()">保存</button>
			<button onclick="$('.add').fadeIn()">添加</button>
			<button onclick="$(current).css('font-size','xx-small')">小字体</button>
			<button onclick="$(current).css('font-size','medium')">中字体</button>
			<button onclick="$(current).css('font-size','xx-large')">大字体</button>
			<button onclick="$(current).css('text-align','center')">居中</button>
			<button onclick="$(current).css('text-align','left')">靠左</button>
			<button onclick="$(current).css('text-align','right')">靠右</button>
		</div>
	</body>
</html>