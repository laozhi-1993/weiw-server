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
				width: 14.2%;
			}
			.textures .skin .margin .paiban .kapian {
				background-color: #fff0f5;
				border-radius: 5px;
				font-size: medium;
				overflow: hidden;
				margin: 10px;
			}
			.textures .skin .margin .paiban .kapian .preview {
				position: relative;
				top: 0;
				margin: 20px;
				padding-top: 100%;
			}
			.textures .skin .margin .paiban .kapian .preview img 
			{
				position: absolute;
				top: 0;
				width: 100%;
			}
			.textures .skin .margin .paiban .kapian .attribute {
				background-color: #e6e9ec;
				height: 60px;
				position: relative;
				top: 0;
				padding: 5px;
			}
			.textures .skin .margin .paiban .kapian .attribute .name {
				overflow: hidden;
				text-overflow: ellipsis;
				white-space: nowrap;
				width: 100%;
			}
			.textures .skin .margin .paiban .kapian .attribute .type {
				padding: 5px 10px;
				position: absolute;
				right: 5px;
				color: #437070;
				bottom: 5px;
				border-radius: 5px;
				background-color: #FFFFFF;
			}
			.textures .skin .margin .paiban .kapian .attribute button {
				background-color: #0C9CFF;
				border-radius: 5px;
				border: none;
				cursor: pointer;
				color: #FFFFFF;
				padding: 5px 10px;
				position: absolute;
				bottom: 5px;
				left: 5px;
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
			@media screen and (max-width: 2200px) {
				.textures .skin .margin .paiban {
					width: 16.6%;
				}
			}
			@media screen and (max-width: 900px) {
				.textures .skin .margin .paiban {
					width: 20%;
				}
			}
			@media screen and (max-width: 1600px) {
				.textures .skin .margin .paiban {
					width: 25%;
				}
			}
			@media screen and (max-width: 1300px) {
				.textures .skin .margin .paiban {
					width: 33.32%;
				}
			}
			@media screen and (max-width: 1000px) {
				.textures .skin .margin .paiban {
					width: 50%;
				}
			}
			@media screen and (max-width: 500px) {
				.textures .skin .margin .paiban {
					width: 100%;
				}
			}
			@media screen and (max-width: 500px) {
				.zuiwai {
					margin: 0 10px;
				}
				.texture {
					height: calc(100% - 50px);
					margin-top: 10px;
				}
				.textures {
					height: calc(100% - 90px);
					margin-top: 0px;
				}
				.textures .skin .margin {
					margin: 0 5px;
					padding: 5px 0;
					font-size: 0;
				}
				.textures .skin .margin .paiban {
					width: 100%;
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
							<div class="preview"><img src="https://littleskin.cn/preview/{echo:[value.tid]}?height=150" /></div>
							<div class="attribute">
								<div class="name">{echo:[value.name]}</div>
								<div class="type">{echo:[value.type]}</div>
								<button onclick="skin('{echo:[value.tid]}')">使用此皮肤</button>
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
				$.getJSON("/weiw/index.php?{echo:token}",{"mods":"mc_setskin","id":id},function (result){
					if(result.error == "ok")
					{
						window.parent.zhedie_anniu();
						window.parent.document.getElementById('texture').contentWindow.location.reload();
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