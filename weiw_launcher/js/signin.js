	const mainSignIn = function ()
	{
		let time = 0;
		let html = $(".signIn .button").html();
		
		
		$.getJSON("/weiw/index.php?mods=mc_sign_in",function (result){
			time = result.count_down;
			count_down = function ()
			{
				if(time <= 0)
				{
					$(".signIn .button").html(html);
					$(".signIn .button").css('background-color','#7B68EE');
				}
				else
				{
					date = new Date(parseInt(`${time}000`));
					time--;
					
					
					
					Hours   = date.getUTCHours  ().toString().padStart(2,"0");
					Minutes = date.getUTCMinutes().toString().padStart(2,"0");
					Seconds = date.getUTCSeconds().toString().padStart(2,"0");
					
					$(".signIn .button").html(`${Hours}:${Minutes}:${Seconds}`);
					$(".signIn .button").css('background-color','#2f4f4f');
				}
				
				return count_down;
			}
			
			setInterval(count_down(),1000);
		});
		
		
		return function ()
		{
			if(time <= 0)
			{
				$.getJSON("/weiw/index.php?mods=mc_sign_in&si=1",function (result){
					if(result.error == "ok")
					{
						time = result.time-1;
						$(".signIn .money").html(result.bi);
						$(".signIn .button").html("00:00:00");
						$(".signIn .button").css('background-color','#2f4f4f');
					}
				});
			}
		}
	}
	window.addEventListener('DOMContentLoaded', function() {
		$(".signIn").click(mainSignIn());
	});