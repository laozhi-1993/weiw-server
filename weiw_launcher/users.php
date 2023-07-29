<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_admin');
	$MKH ->mods('mc_users');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<script src="js/jquery.min.js"></script>
		<script>
			var html = $(".user").html();
			var text = '';
			
			
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
				bi   = $("#modify").val();
				text = html;
				$.getJSON("/weiw/index.php?{echo:token}",{"mods":"mc_user_data","name":name,"bi":bi},function (result){
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
			.users {
				margin: 0;
				color: #fff;
			}
			.users .list {
				padding: 50px;
				padding-bottom: 50px;
				border-radius: 5px;
				background: radial-gradient(#666,#555);
			}
			.users .list .number {
				position: relative;
				height: 50px;
				font-size: large;
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
			.users .list table {
				width: 100%;
				border-collapse: collapse;
			}
			.users .list table td {
				max-width: 120px;
				white-space: nowrap;
				overflow: hidden;
				text-overflow: ellipsis;
				padding: 0 20px;
				height: 60px;
			}
			.users .list table td:nth-child(4) {
				text-align: right;
			}
			.users .list table td:nth-child(5) {
				text-align: right;
			}
			.users .list table thead {
				color: #ddd;
				background-color: #666;
			}
			.users .list table tbody {
				color: #ddd;
				border-bottom: 1px solid #666;
			}
			.users .list table tbody:hover {
				color: #ddd;
				background-color: #666;
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
		</style>
	</head>
	<body>
		<div class="users">
			<div class="list">
				<div class="number">
					<div class="number-user">共 {Print:mc_users:number} 个用户</div>
					<div class="number-page">第 {Print:mc_users:page:total}/{Print:mc_users:page:current} 页</div>
				</div>
				<table>
					<thead>
						<tr>
							<td>名称</td>
							<td>邮箱</td>
							<td>金币</td>
							<td>登陆时间</td>
							<td>注册时间</td>
						</tr>
					</thead>
					<tbody foreach([mc_users.users],[value]):>
						<tr>
							<td>{Print:value:name}</td>
							<td>{Print:value:email}</td>
							<td>{Print:value:bi}</td>
							<td>{Print:value:login_time}</td>
							<td>{Print:value:register_time}</td>
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