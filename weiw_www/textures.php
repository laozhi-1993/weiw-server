<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_textures');
	$MKH ->send(false);
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<title>皮肤库</title>
		<style>
			*::-webkit-scrollbar {
				width:  3px;
				height: 3px;
			}
			*::-webkit-scrollbar-track {
				border-radius: 3px;
				background-color: transparent;
			}
			*::-webkit-scrollbar-thumb {
				border-radius: 3px;
				background-color: #cccccc;
			}
			body {
				padding: 0;
				margin: 0;
			}
			.textures {
				background-color: #FFFFFF;
			}
			.textures .skin {
				background-color: #FFFFFF;
			}
			.textures .skin .margin {
				font-size: 0;
			}
			.textures .skin .margin .paiban {
				display: inline-block;
				width: 12.5%;
			}
			.textures .skin .margin .paiban .kapian {
				background-color: #fff0f5;
				border-radius: 5px;
				font-size: medium;
				overflow: hidden;
				margin: 10px;
			}
			.textures .skin .margin .paiban .kapian .information {
				padding: 5px;
			}
			.textures .skin .margin .paiban .kapian .information span {
				padding: 0 10px;
				line-height: 20px;
				height: 22px;
				max-width: calc(100% - 80px);
				color: #437070;
				font-size: 10px;
				display: inline-block;
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
				border-radius: 11px;
				background-color: #FFFFFF;
			}
			.textures .skin .margin .paiban .kapian .preview {
				position: relative;
				top: 0;
				margin: 5%;
				padding-top: 101%;
			}
			.textures .skin .margin .paiban .kapian .preview img 
			{
				position: absolute;
				top: 0;
				width: 100%;
				height: 100%;
			}
			.textures .skin .margin .paiban .kapian .attribute {
				background-color: #e6e9ec;
				height: 30px;
				position: relative;
				top: 0;
			}
			.textures .skin .margin .paiban .kapian .attribute button {
				background-color: #0C9CFF;
				border-radius: 0 0 5px 5px;
				border: none;
				cursor: pointer;
				color: #FFFFFF;
				text-align: center;
				height: 100%;
				width: 100%;
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
			@media screen and (max-width: 1600px) {
				.textures .skin .margin .paiban {
					width: 20%;
				}
			}
			@media screen and (max-width: 1000px) {
				.textures .skin .margin .paiban {
					width: 25%;
				}
			}
			@media screen and (max-width: 500px) {
				.textures .skin .margin .paiban {
					width: 50%;
				}
				.textures .skin .margin .paiban .kapian {
					margin: 3px;
				}
			}
		</style>
	</head>
	<body>
		<div class="textures">
			<div class="skin">
				<div class="margin">
					<div foreach([mc_textures.data],[value]): class="paiban">
						<div class="kapian">
							<div class="information">
								<span title="{echo:[value.type]}">{echo:[value.type]}</span>
								<span title="{echo:[value.name]}">{echo:[value.name]}</span>
							</div>
							<div class="preview">
								<img src="https://littleskin.cn/preview/{echo:[value.tid]}?height=150" />
							</div>
							<div class="attribute">
								<button onclick="skin('{echo:[value.tid]}')">使用</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="page">
				<a href="{URL:[index]}?page={echo:[mc_textures.current_page]-1}" class="s">&lt;上一页</a>
				<a href="{URL:[index]}?page={echo:[mc_textures.current_page]+1}" class="x">下一页&gt;</a>
			</div>
		</div>
		<script src="/weiw/jquery.min.js"></script>
		<script>
			function skin(id)
			{
				$.getJSON("/weiw/index.php?{echo:token}",{"mods":"mc_set_texture","id":id},function (result){
					if(result.error == "ok")
					{
						if(result.type == "steve")
						{
							window.parent.zhedie_anniu();
							window.parent.skin(result.hash);
						}
						if(result.type == "alex")
						{
							window.parent.zhedie_anniu();
							window.parent.skin(result.hash);
						}
						if(result.type == "cape")
						{
							window.parent.zhedie_anniu();
							window.parent.cape(result.hash);
						}
					}
					else
					{
						window.parent.tips(result.error);
					}
				});
			}
		</script>
	</body>
</html>