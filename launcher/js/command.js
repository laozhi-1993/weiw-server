	let loading = false;
	let command = function (com)
	{
		if (loading) {
			return;
		}
		
		if(com == "broadcast")
		{
			var value = "broadcast "+$("#command").val();
			var text  = "<div class='send'>发送了公告："+$("#command").val()+"</div>";
		}
		else
		{
			var value = $("#command").val();
			var text  = "<div class='send'>发送了命令："+$("#command").val()+"</div>";
		}
		
		
		if(value !== "")
		{
			loading = true;
			$.getJSON("/weiw/index.php",{"mods":"mc_console","command":value},function (result){
				if(result.error !== '\u0000\u0000')
				{
					$(".rcon .output pre").append("<div class='return'>"+result.error+"</div>");
					$(".rcon .output").scrollTop($(".rcon .output").prop("scrollHeight"));
				}
				
				loading = false;
			});
			
			
			$("#command").val("");
			$(".rcon .output pre").append(text);
			$(".rcon .output").scrollTop($(".rcon .output").prop("scrollHeight"));
		}
	}
	
	
	window.addEventListener('DOMContentLoaded', function() {
		$("#command").keyup(function (){
			if(event.keyCode == 13)
			{
				$("#button").click();
			}
		});
	});