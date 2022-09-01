<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<title>我的衣服</title>
		<script>
			var zhedie = false;
			function zhedie_anniu()
			{
				if(zhedie)
				{
					$(".textures").animate({marginTop:'-30px'},200,'swing');
					$(".textures").animate({top:'100%'},200,'swing',function (){
						$(".texture").show();
						$(".overflow").hide();
					});
					zhedie = false;
				}
				else
				{
					$(".texture").hide();
					$(".textures").animate({top:'0'},200,'swing');
					$(".textures").animate({marginTop:'10px'},200,'swing',function (){
						$(".overflow").show();
					});
					zhedie = true;
				}
			}
		</script>
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
			.zuiwai {
				position: relative;
				top: 0;
				height: 100%;
				margin: 0 50px;
				overflow: hidden;
			}
			.texture {
				background-color: #FFFFFF;
				border-radius: 10px;
				box-shadow: 0 0 5px 0px #a7f6f6;
				overflow: hidden;
				margin-top: 10px;
				height: calc(100% - 50px);
			}
			.texture iframe {
				vertical-align: bottom;
				display: inline-block;
				width:  100%;
				height: 100%;
			}
			.textures {
				background-color: #FFFFFF;
				border-radius: 10px 10px 0 0;
				box-shadow: 0 0 5px 0px #a7f6f6;
				margin-top: -30px;
				padding: 30px 0;
				position: absolute;
				top: 100%;
				width: 100%;
				height: calc(100% - 55px);
			}
			.textures .anniu {
				position: absolute;
				top: 0;
				height: 30px;
				line-height: 30px;
				width: 100%;
				cursor: pointer;
				color: #20b2aa;
				text-align: center;
			}
			.textures .overflow iframe {
				width:  100%;
				height: 100%;
			}
			.textures .overflow {
				margin-right: 3px;
				display: none;
				height: 100%;
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
					height: calc(100% - 55px);
					margin-top: -30px;
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
		<div class="zuiwai">
			<div class="texture"><iframe id="texture" src="texture/index.php" allowtransparency="true" allowfullscreen="true" frameborder="0"></iframe></div>
			<div class="textures">
				<div class="anniu" onclick="zhedie_anniu()">☞点此打开或关闭皮肤库☜</div>
				<div class="overflow"><iframe id="textures" src="textures.php" allowtransparency="true" allowfullscreen="true" frameborder="0"></iframe></div>
			</div>
		</div>
	</body>
</html>