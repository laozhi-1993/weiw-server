	var Capeelytra = { backEquipment: "elytra" }; //鞘翅
	var Capecape   = { backEquipment: "cape"   }; //披风
	var Capestate  = false;
	var Rotate     = false;
	
	
	function initializeViewer()
	{
		skinViewer = new skinview3d.SkinViewer({
			canvas: document.getElementById("skinContainer")
		});
		
		
		loadTexture();
		action(1);
		
		
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
	
	function loadTexture()
	{
		fetch('/weiw/index.php?mods=mc_user')
			.then(response => {
				if (!response.ok) {
					throw new Error('Network response was not ok ' + response.statusText);
				}
				return response.json();
			})
			.then(data => {
				if(data.CAPE.hash != "")
				{
					skinViewer.loadCape(`/weiw/index_auth.php/texture/${data.CAPE.hash}`);
				}
				else
				{
					skinViewer.loadCape(null);
				}

				if(data.SKIN.hash)
				{
					skinViewer.loadSkin(`/weiw/index_auth.php/texture/${data.SKIN.hash}`);
					$(window.parent.document).find('#avatar img').attr('src',`/weiw/index_auth.php/avatar/${data.SKIN.hash}/48`);
				}
			})
			.catch(error => {
				console.error(error);
			});
	}
	
	function texture(type)
	{
		if(type === 0)
		{
			fetch("/weiw/index.php?mods=mc_texture_resetting")
				.then(response => {
					if (!response.ok) {
						throw new Error('Network response was not ok ' + response.statusText);
					}
					return response.json();
				})
				.then(data => {
					if(data.error == "ok")
					{
						loadTexture();
					}
					else showMessage(data.error);
				})
				.catch(error => {
					console.error(error);
				});
		}
		
		if(type === 1)
		{
			fetch("/weiw/index.php?mods=mc_texture&id="+$('.settexture input').val())
				.then(response => {
					if (!response.ok) {
						throw new Error('Network response was not ok ' + response.statusText);
					}
					return response.json();
				})
				.then(data => {
					if(data.error == "ok")
					{
						loadTexture();
					}
					else showMessage(data.error);
				})
				.catch(error => {
					console.error(error);
				});
			
			$('.settexture input').val("");
			$('.settexture').fadeOut();
		}
		
		if(type === 2) $('.settexture').fadeOut();
		if(type === 3) $('.settexture').slideToggle(150);
	}
	
	window.addEventListener('DOMContentLoaded', initializeViewer);