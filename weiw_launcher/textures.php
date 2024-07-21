<?php include_once("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh();
	$MKH ->mods('mc_launcher');
	$MKH ->mods('mc_textures');
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<script src="js/jquery.min.js"></script>
		<script src="js/textures.js"></script>
		<style>
			body {
				padding-bottom: 50px;
				overflow-y: scroll;
				overflow-x: hidden;
			}
			center {
				padding-top: 35px;
				padding-bottom: 15px;
				font-size: medium;
				color: #DAA520;
			}
			.other {
				color: #ddd;
				font-size: 12px;
				padding: 10px;
				margin-bottom: 5px;
				border-radius: 5px;
				background-color: #666;
			}
			.textures {
				margin-right: -10px;
				font-size: 0;
				overflow: hidden;
			}
			.textures .paiban {
				display: inline-block;
				width: 25%;
			}
			.textures .paiban .kapian {
				background-color: #666;
				border-radius: 5px;
				font-size: medium;
				overflow: hidden;
				margin-right: 10px;
				margin-bottom: 10px;
			}
			.textures .paiban .kapian .information {
				padding: 5px;
			}
			.textures .paiban .kapian .information span {
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
				background-color: #FFFFE0;
			}
			.textures .paiban .kapian .preview {
				position: relative;
				top: 0;
				margin: 5%;
				padding-top: 101%;
			}
			.textures .paiban .kapian .preview img 
			{
				position: absolute;
				top: 0;
				width: 100%;
				height: 100%;
			}
			.textures .paiban .kapian .attribute {
				background-color: #e6e9ec;
				height: 30px;
				position: relative;
				top: 0;
			}
			.textures .paiban .kapian .attribute button {
				background-color: #0C9CFF;
				border-radius: 0 0 5px 5px;
				border: none;
				cursor: pointer;
				color: #FFFFFF;
				height: 100%;
				width: 100%;
				user-select: none;
			}
			
			.load-more-button {
				margin: 20px auto;
				text-align: center;
			}
			.load-more-button button {
				width: 200px;
				height: 40px;
				cursor: pointer;
				color: #f7f7ff;
				user-select: none;
				border: none;
				border-radius: 5px;
				background-color: #ff00ff;
			}
			
			.loading {
				display: none;
				position: relative;
				top: -18px;
				left: 0;
				color: #fff;
				font-size: 7px;
			}
			.loading,
			.loading:before,
			.loading:after {
				border-radius: 50%;
				width:  10px;
				height: 10px;
				animation-fill-mode: both;
				animation: loading 1.8s infinite ease-in-out;
			}
			.loading:before,
			.loading:after {
				content: '';
				position: absolute;
				top: 0;
			}
			.loading:before {
				left: -20px;
				animation-delay: -0.32s;
			}
			.loading:after {
				left: 20px;
				animation-delay: 0.16s;
			}
			@keyframes loading {
				0%, 80%, 100% { box-shadow: 0 2.5em 0 -1.3em }
				40% { box-shadow: 0 2.5em 0 0 }
			}
			@media screen and (min-width: 1300px) {
				.textures .paiban {
					width: 20%;
				}
			}
			@media screen and (min-width: 1800px) {
				.textures .paiban {
					width: 10%;
				}
			}
		</style>
	</head>
	<body>
		<div class="message"><?php include('includes/message.html') ?></div>
		<div class="other">
			<span>材质来源于<a href="javascript:window.parent.OpenAPI('https://mcskin.cn/')">红石皮肤站</a>。</span>
		</div>
		<div class="content-container">
			<div class="textures" id="textures">
				<center>[{echo:var.mc_textures.current_page}/{echo:var.mc_textures.last_page}]</center>
				<div foreach(var.mc_textures.data,var.key,var.value) class="paiban">
					<div class="kapian">
						<div class="information">
							<span title="{echo:var.value.type}">{echo:var.value.type}</span>
							<span title="{echo:var.value.name}">{echo:var.value.name}</span>
						</div>
						<div class="preview">
							<img src="https://mcskin.cn/preview/{echo:var.value.tid}?height=150" />
						</div>
						<div class="attribute">
							<button onclick="settexture('{echo:var.value.tid}')">使用</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="load-more-button">
			<button onclick="javascript:loadMoreButton()">
				<span>加载更多</span>
				<span class="loading"></span>
			</button>
		</div>
	</body>
</html>