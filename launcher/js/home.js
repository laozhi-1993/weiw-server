	var Capeelytra = { backEquipment: "elytra" }; //鞘翅
	var Capecape   = { backEquipment: "cape"   }; //披风
	var Capestate  = false;
	var Rotate     = false;
	
	
	function initializeViewer()
	{
		skinViewer = new skinview3d.SkinViewer({
			canvas: document.getElementById("skinContainer")
		});
		
		
		setSkinHash(document.getElementById("skinContainer").getAttribute("skinHash"));
		setCapeHash(document.getElementById("skinContainer").getAttribute("capeHash"));
		action(1);
//		action(4);
		
		
		skinViewer.fov  = 80;   //背景大小
		skinViewer.zoom = 0.80; //人物大小
		skinViewer.globalLight.intensity = 0.60; //亮度
		skinViewer.cameraLight.intensity = 0.40; //亮度
		
		
		skinViewer.width  = document.getElementById("canvas").offsetWidth;
		skinViewer.height = document.getElementById("canvas").offsetHeight;
		window.onresize = function (){
			skinViewer.width  = document.getElementById("canvas").offsetWidth;
			skinViewer.height = document.getElementById("canvas").offsetHeight;
		}
	}
	
	
	function setSkinHash(hash)
	{
		Skinurl = `/weiw/index_auth.php/texture/${hash}`;
		skinViewer.loadSkin(Skinurl);
	}
	
	function setCapeHash(hash)
	{
		if(hash != "")
		{
			Capeurl = `/weiw/index_auth.php/texture/${hash}`;
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
	
	function texture(type)
	{
		if(type === 1)
		{
			$.getJSON("/weiw/index.php",{"mods":"mc_texture","id":$('.settexture input').val()},function (result){
				if(result.error == "ok")
				{
					if(result.type == 'steve' || result.type == 'alex')
					{
						$(window.parent.document).find('#avatar img').attr('src',`/weiw/index_auth.php/avatar/${result.hash}/48`);
						setSkinHash(result.hash);
					}
					
					if(result.type == 'cape') setCapeHash(result.hash);
				}
				else showMessage(result.error);
			});
			
			$('.settexture input').val("");
			$('.settexture').fadeOut();
		}
		
		if(type === 2) $('.settexture').fadeOut();
		if(type === 3) $('.settexture').slideToggle(150);
	}
	
	window.addEventListener('DOMContentLoaded', initializeViewer);