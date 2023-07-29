<?php defined('__MKHDIR__') or die(http_response_code(404)) ?><?php isset($this->_Unified['mc_users']['users']) or $this->_Unified['mc_users']['users'] = false ?><?php isset($this->_Unified['value']) or $this->_Unified['value'] = false ?><?php isset($this->_Unified['index']) or $this->_Unified['index'] = false ?><?php isset($this->_Unified['mc_users']['page']['s']) or $this->_Unified['mc_users']['page']['s'] = false ?><?php isset($this->_Unified['mc_users']['page']['x']) or $this->_Unified['mc_users']['page']['x'] = false ?>
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
					$.getJSON("/weiw/index.php?<?php echo token ?>",{"mods":"mc_user_data","name":name},function (result){
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
				$.getJSON("/weiw/index.php?<?php echo token ?>",{"mods":"mc_user_data","name":name,"bi":bi},function (result){
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
					<div class="number-user">共 <?php echo $this->_Unified['mc_users']['number'] ?> 个用户</div>
					<div class="number-page">第 <?php echo $this->_Unified['mc_users']['page']['total'] ?>/<?php echo $this->_Unified['mc_users']['page']['current'] ?> 页</div>
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
					<?php if(is_array($this->_Unified['mc_users']['users']) && count($this->_Unified['mc_users']['users'])): ?><?php foreach($this->_Unified['mc_users']['users'] as $this->_Unified['value']): ?><tbody>
						<tr>
							<td><?php echo $this->_Unified['value']['name'] ?></td>
							<td><?php echo $this->_Unified['value']['email'] ?></td>
							<td><?php echo $this->_Unified['value']['bi'] ?></td>
							<td><?php echo $this->_Unified['value']['login_time'] ?></td>
							<td><?php echo $this->_Unified['value']['register_time'] ?></td>
						</tr>
					</tbody><?php endforeach; ?><?php endif; ?>
				</table>
			</div>
			<div class="page">
				<a href="<?php echo $this->_Unified['index'] ?>?<?php echo $this->_Unified['mc_users']['page']['s'] ?>" class="s">&lt;上一页</a>
				<a href="<?php echo $this->_Unified['index'] ?>?<?php echo $this->_Unified['mc_users']['page']['x'] ?>" class="x">下一页&gt;</a>
			</div>
		</div>
	</body>
</html>