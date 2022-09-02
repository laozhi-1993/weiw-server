<?php include("$_SERVER[DOCUMENT_ROOT]/weiw/index.php");


    $MKH = new mkh(__FILE__);
	$MKH ->mods('mc_user');
	$MKH ->send();
?>
<!DOCTYPE html>
<html lang="zh-cmn-Hans"> 
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="x-ua-compatible" content="ie=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<title>展示材质</title>
		<style>
			body {
				margin:  0;
				padding: 0;
				overflow: hidden;
			}
			.texture {
				background-color: #FFFFFF;
				user-select: none;
			}
			.texture h1 {
				margin: 0;
				padding: 5px;
				font-size: large;
				line-height: 30px;
				text-align: center;
				color: #8195c7;
				height: 30px;
				background-color: #f8f8ff;
				border-bottom: 1px solid #dbf0ee;
			}
			.texture #canvas {
				vertical-align: bottom;
				height: calc(100vh - 120px);
			}
			.texture .action {
				background-color: #f8f8ff;
				border-top: 1px solid #dbf0ee;
				padding: 5px;
				height: 70px;
				text-align: center;
			}
			.texture .action button {
				border-radius: 5px;
				background-color: #0C9CFF;
				border: none;
				cursor: pointer;
				color: #FFFFFF;
				padding: 5px 10px;
			}
			.texture .action .icons {
				display: block;
				vertical-align: top;
				text-align: center;
			}
			.texture .action .icons svg {
				width:  30px;
				height: 30px;
				cursor: pointer;
			}
			.texture .action .icons svg path {
				fill: #a6a6a6;
			}
		</style>
	</head>
	<body>
		<div class="texture">
			<h1>展示材质</h1>
			<div id="canvas"><canvas id="skin_container"></canvas></div>
			<div class="action">
				<div class="icons" onclick="cape()">{include:"icons/elytra.svg"}</div>
				<button onclick="action(1)">漫步</button>
				<button onclick="action(2)">跑步</button>				
				<button onclick="action(3)">飞行</button>
				<button onclick="action(4)">旋转</button>
			</div>
		</div>
		<script src="skinview3d.bundle.js"></script>
		<script>
			var Skin       = "{echo:[mc_user.SKIN.url]}";
			var Cape       = "{echo:[mc_user.CAPE.url]}";
			var Capeelytra = { backEquipment: "elytra" }; //鞘翅
			var Capecape   = { backEquipment: "cape"   }; //披风
			var Capestate  = false;
			
			
			function initializeViewer() {
				skinViewer = new skinview3d.FXAASkinViewer({
					canvas: document.getElementById("skin_container")
				});

				skinViewer.fov  = 70;   //背景大小
				skinViewer.zoom = 0.50; //人物大小
				skinViewer.globalLight.intensity = 0.60; //亮度
				skinViewer.cameraLight.intensity = 0.40; //亮度
				
				
				skinViewer.width  = document.getElementById("canvas").offsetWidth;
				skinViewer.height = document.getElementById("canvas").offsetHeight;
				window.onresize = function (){
					skinViewer.width  = document.getElementById("canvas").offsetWidth;
					skinViewer.height = document.getElementById("canvas").offsetHeight;
				}
				
				
				if(Skin == "")
				{
					skinViewer.loadSkin("img/Steve.png");
				}
				else
				{
					skinViewer.loadSkin(Skin.replace(/https?:\/\/[A-Za-z0-9:.]+/,""));
				}
				
				
				if(Cape != "")
				{
					skinViewer.loadCape(Cape.replace(/https?:\/\/[A-Za-z0-9:.]+/,""), Capecape);
				}
				
				orbitControl = skinview3d.createOrbitControls(skinViewer);
				orbitControl.enableRotate = true;  //设置是否允许鼠标改变人物角度
				orbitControl.enableZoom   = true;  //设置是否允许缩放人物
				orbitControl.enablePan    = false; //设置是否允许移动人物
				
				
					//primaryAnimation.paused = true; //暂停动作
					//primaryAnimation.resetAndRemove(); //停止动作
					primaryAnimation = skinViewer.animations.add(skinview3d.WalkingAnimation);  //设置人物动作
					primaryAnimation.speed = 1; //设置动画速度
					rotateAnimation  = skinViewer.animations.add(skinview3d.RotatingAnimation); //设置人物动作
					rotateAnimation.speed  = 1; //设置动画速度
				
				
				skinViewer.loadPanorama("img/2022-08-02_15.12.25.png"); //设置背景
			}
			
			
			function cape()
			{
				if(Capestate)
				{
					skinViewer.loadCape(Cape, Capecape);
					document.querySelector(".icons path").style.fill = "#a6a6a6";
					Capestate = false;
				}
				else
				{
					skinViewer.loadCape(Cape, Capeelytra);
					document.querySelector(".icons path").style.fill = "#FFFFFF";
					Capestate = true;
				}
			}
			
			
			function action(type)
			{
					//skinview3d.IdleAnimation     动胳膊
					//skinview3d.WalkingAnimation  走步
					//skinview3d.RunningAnimation  跑步
					//skinview3d.FlyingAnimation   飞行
					//skinview3d.RotatingAnimation 旋转
					
				if(type === 0)
				{
					rotateAnimation.resetAndRemove();
					primaryAnimation.resetAndRemove();
					primaryAnimation = skinViewer.animations.add(skinview3d.IdleAnimation);
					primaryAnimation.speed = 1;
				}
				else if(type === 1)
				{
					rotateAnimation.resetAndRemove();
					primaryAnimation.resetAndRemove();
					primaryAnimation = skinViewer.animations.add(skinview3d.WalkingAnimation);
					primaryAnimation.speed = 1;
				}
				else if(type === 2)
				{
					rotateAnimation.resetAndRemove();
					primaryAnimation.resetAndRemove();
					primaryAnimation = skinViewer.animations.add(skinview3d.RunningAnimation);
					primaryAnimation.speed = 0.5;
				}
				else if(type === 3)
				{
					rotateAnimation.resetAndRemove();
					primaryAnimation.resetAndRemove();
					primaryAnimation = skinViewer.animations.add(skinview3d.FlyingAnimation);
					primaryAnimation.speed = 1;
				}
				else if(type === 4)
				{
					rotateAnimation.resetAndRemove();
					rotateAnimation = skinViewer.animations.add(skinview3d.RotatingAnimation);
					rotateAnimation.speed = 1;
					primaryAnimation.resetAndRemove();
					primaryAnimation = skinViewer.animations.add(skinview3d.WalkingAnimation);
					primaryAnimation.speed = 1;
				}
			}
			
			
			initializeViewer();
		</script>
	</body>
</html>
