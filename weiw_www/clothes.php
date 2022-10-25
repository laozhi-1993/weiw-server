<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_user');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans">
	<head>
		<title>我的衣服</title>
		<style>
			.button_texture {
				padding: 10px 7px;
				position: absolute;
				left: 0;
				top: 100px;
				z-index: 99;
				width: 15px;
				cursor: pointer;
				color: #FFFFFF;
				font-size: 12px;
				background-color: #7b68ee;
				border-radius: 0 10px 10px 0;
			}
			.set_texture {
				background-color: rgba(0,0,0,0.6);
				position: fixed;
				top:   0;
				right: 0;
				z-index: 99;
				width:  100%;
				height: 100%;
				display: none;
			}
			.set_texture .position {
				position: absolute;
				top: 0;
				width: 100%;
			}
			.set_texture .exhibit {
				overflow: hidden;
				margin: 5px auto;
				max-width:  400px;
				min-height: 200px;
				position: relative;
				padding-bottom: 50px;
				background-color: #FFFFFF;
				border-radius: 10px;
			}
			.set_texture .exhibit .name {
				background-color: #007fff;
				border-bottom: 1px solid #1e90ff;
				height: 50px;
				line-height: 50px;
				color: #FFFFFF;
				text-align: center;
			}
			.set_texture .exhibit .content {
				margin: 20px;
			}
			.set_texture .exhibit .content .hint {
				background-color: #ffefd5;
				border-radius: 10px;
				padding: 10px;
				margin: 10px 0;
				font-size: 10px;
				color: #dd008b;
			}
			.set_texture .exhibit .content .hint a {
				text-decoration: none;
			}
			.set_texture .exhibit .content .error {
				color: #ff0000;
				padding: 10px 2px;
				margin: 0;
				display: none;
			}
			.set_texture .exhibit .content .error span {
				vertical-align: top;
				display: inline-block;
				line-height: 18px;
				font-size: 15px;
				width: calc(100% - 30px);
			}
			.set_texture .exhibit .content .error svg {
				width:  18px;
				height: 18px;
				vertical-align: top;
			}
			.set_texture .exhibit .content .error svg path {
				 fill: #ff0000;
			}
			.set_texture .exhibit .content #tid {
				width: calc(100% - 18px);
				height: 18px;
				line-height: 18px;
				font-size: 15px;
				padding: 8px;
				border: 1px solid #56c3bf;
			}
			.set_texture .exhibit .button {
				padding: 10px 0;
				position: absolute;
				bottom: 0;
				border-top: 1px solid #f0f0f0;
				text-align: right;
				user-select: none;
				width:  100%;
				height: 30px;
			}
			.set_texture .exhibit .button span {
				position: relative;
				right: 20px;
				padding: 0 15px;
				display: inline-block;
				height: 30px;
				line-height: 30px;
				cursor: pointer;
				color: #FFFFFF;
				font-size: 15px;
				border-radius: 5px;
			}
			.set_texture .exhibit .button .sure {
				background-color: #007fff;
			}
			.set_texture .exhibit .button .closure {
				background-color: #48a772;			
			}
			
			
			.texture {
				user-select: none;
				position: relative;
				height: calc(100% - 36px);
			}
			.texture #canvas {
				vertical-align: bottom;
				height: 100%;
			}
			.texture .action {
				position: absolute;
				bottom: 0;
				padding: 5px 0;
				height: 30px;
				width: 100%;
				text-align: center;
			}
			.texture .action button {
				border-radius: 5px;
				background-color: #20b2aa;
				border: none;
				cursor: pointer;
				color: #FFFFFF;
				padding: 5px 15px;
			}
			.texture .action button:active {
				background-color: #008080;
				color: #FFFFFF;
			}
			.texture .action .icons:active svg path {
				fill: #000000;
			}
			.texture .action .icons {
				position: relative;
				top: -15px;
				display: inline-block;
				vertical-align: top;
				padding:0 5px;
			}
			.texture .action .icons svg {
				width:  50px;
				height: 50px;
				cursor: pointer;
			}
			.texture .action .icons svg path {
				fill: #7b68ee;
			}
			.textures {
				background-color: #FFFFFF;
				border-radius: 10px 10px 0 0;
				box-shadow: 0 0 5px 0px #a7f6f6;
				margin-top: -30px;
				padding-top: 30px;
				position: absolute;
				top: 100%;
				width: 100%;
				height: calc(100% - 40px);
			}
			.textures .anniu {
				position: absolute;
				top: 0;
				height: 30px;
				line-height: 30px;
				width: 100%;
				cursor: pointer;
				color: #20b2aa;
				font-size: 12px;
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
			.body {
				overflow: hidden!important;
			}
			@media screen and (max-height: 500px) {
				.set_texture .position {
					top: auto!important;
					bottom: 0;
				}
			}
		</style>
	</head>
	<body>
		<div class="button_texture" onclick="set_texture(3)">
			<span>更换材质</span>
		</div>
		<div class="set_texture">
			<div class="position">
				<div class="exhibit">
					<div class="name">更换材质</div>
					<div class="content">
						<p>输入材质的TID：</p>
						<input type="number" min="1" placeholder="TID" id="tid"/>
						<p class="hint">材质的TID需要到 <a href="https://littleskin.cn" target="_blank">LittleSkin皮肤站</a> 获取。</p>
						<p class="error">{include:"icons/error.svg"} <span></span></p>
					</div>
					<div class="button">
						<span class="closure" onclick="set_texture(2)">关闭</span>
						<span class="sure" onclick="set_texture(1)">确定</span>
					</div>
				</div>
			</div>
		</div>
		<div class="texture">
			<div id="canvas"><canvas id="skin_container"></canvas></div>
			<div class="action">
				<button onclick="action(1)">漫步</button>
				<button onclick="action(2)">跑步</button>				
				<div class="icons" onclick="action(5)">{include:"icons/elytra.svg"}</div>
				<button onclick="action(3)">飞行</button>
				<button onclick="action(4)">旋转</button>
			</div>
		</div>
		<div class="textures">
			<div class="anniu" onclick="anniu()">☞点此打开或关闭皮肤库☜</div>
			<div class="overflow"><iframe id="textures" src="textures.php" allowtransparency="true" allowfullscreen="true" frameborder="0"></iframe></div>
		</div>
		<script src="js/skinview3d.bundle.js"></script><!--https://unpkg.com/skinview3d@3.0.0-alpha.1/bundles/skinview3d.bundle.js-->
		<script>
			var Capeelytra = { backEquipment: "elytra" }; //鞘翅
			var Capecape   = { backEquipment: "cape"   }; //披风
			var Capestate  = false;
			var zhedie     = false;
			var Rotate     = false;
			Capeurl = "/weiw/index_auth.php/texture/{echo:[mc_user.CAPE.hash]}";
			
			function initializeViewer() {
				skinViewer = new skinview3d.SkinViewer({
					canvas: document.getElementById("skin_container")
				});
				
				
				skin("{echo:[mc_user.SKIN.hash]}");
				cape("{echo:[mc_user.CAPE.hash]}");
				action(1);
				action(4);
				
				
				skinViewer.fov  = 80;   //背景大小
				skinViewer.zoom = 0.60; //人物大小
				skinViewer.globalLight.intensity = 0.60; //亮度
				skinViewer.cameraLight.intensity = 0.40; //亮度
				skinViewer.loadPanorama("img/2022-08-02_15.14.31.png"); //设置背景
				skinViewer.nameTag = "{echo:[mc_user.name]}";
				
				
				skinViewer.width  = document.getElementById("canvas").offsetWidth;
				skinViewer.height = document.getElementById("canvas").offsetHeight;
				window.onresize = function (){
					skinViewer.width  = document.getElementById("canvas").offsetWidth;
					skinViewer.height = document.getElementById("canvas").offsetHeight;
				}
			}
			
			function skin(hash)
			{
				if(hash == "")
				{
					Skinurl = "img/Steve.png";
					skinViewer.loadSkin(Skinurl);
				}
				else
				{
					Skinurl = "/weiw/index_auth.php/texture/"+hash;
					skinViewer.loadSkin(Skinurl);
				}
			}
			
			function cape(hash)
			{
				if(hash != "")
				{
					Capeurl = "/weiw/index_auth.php/texture/"+hash;
					skinViewer.loadCape(Capeurl, Capecape);
				}
			}
			
			function action(type)
			{
					//IdleAnimation     动胳膊
					//WalkingAnimation  走步
					//RunningAnimation  跑步
					//FlyingAnimation   飞行
					//RotatingAnimation 旋转
					
				if(type === 0)
				{
					skinViewer.animation = new skinview3d.IdleAnimation();
					skinViewer.animation.speed = 1;
				}
				else if(type === 1)
				{
					skinViewer.animation = new skinview3d.WalkingAnimation();
					skinViewer.animation.speed = 1;
				}
				else if(type === 2)
				{
					skinViewer.animation = new skinview3d.RunningAnimation();
					skinViewer.animation.speed = 0.5;
				}
				else if(type === 3)
				{
					skinViewer.animation = new skinview3d.FlyingAnimation();
					skinViewer.animation.speed = 1;
				}
				else if(type === 4)
				{
					Rotate ? Rotate = false: Rotate = true;
					skinViewer.autoRotate = Rotate;
				}
				else if(type === 5)
				{
					if(Capestate)
					{
						skinViewer.loadCape(Capeurl, Capecape);
						Capestate = false;
					}
					else
					{
						skinViewer.loadCape(Capeurl, Capeelytra);
						Capestate = true;
					}
				}
			}
			
			function set_texture(type)
			{
				if(type == 1)
				{
					var id = $("#tid").val();
					$(".set_texture .error").hide();
					$.getJSON("/weiw/index.php?{echo:token}",{"mods":"mc_set_texture","id":id},function (result){
						if(result.error == "ok")
						{
							if(result.type == "steve")
							{
								set_texture(2);
								skin(result.hash);
							}
							if(result.type == "alex")
							{
								set_texture(2);
								skin(result.hash);
							}
							if(result.type == "cape")
							{
								set_texture(2);
								cape(result.hash);
							}
						}
						else
						{
							$(".set_texture .error span").html(result.error);
							$(".set_texture .error").show();
						}
					});
				}
				if(type == 2)
				{
					$('.set_texture').hide();
					$('.set_texture .position').css("top","0");
				}
				if(type == 3)
				{
					$(".set_texture .error").hide();
					$(".set_texture #tid").val("");
					$(".set_texture").fadeIn();
					$(".set_texture .position").animate({"top":"230px"},200);
				}
			}
			
			
			function anniu()
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
					$(".textures").animate({marginTop:'5px'},200,'swing',function (){
						$(".overflow").show();
					});
					zhedie = true;
				}
			}
			
			
			initializeViewer();
		</script>
	</body>
</html>