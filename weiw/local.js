$.ajaxSetup({cache:true});
$.fn.local = function(anniu,Ztai1,Ztai2)
{
	if (!!(window.history && history.pushState))
	{
		var xmlhttp = false;
		var get = function(url,post)
		{
			xmlhttp && xmlhttp.abort();
			xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					try
					{
						var html = JSON.parse(xmlhttp.responseText);
						$("mkh-head").html(html['head']);
						$("mkh-body").html(html['body']);
					}
					catch(e)
					{
						console.log(xmlhttp.responseText);
						alert(e);
					}
					
					
					if(Ztai2) Ztai2();
				}
				else
				{
					if(Ztai1) Ztai1( xmlhttp.readyState, xmlhttp.status);
				}
			}
			
			if(post)
			{
				xmlhttp.open("POST",url,true);
				xmlhttp.setRequestHeader('local', 'local');
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.send(post);
			}
			else
			{
				xmlhttp.open("GET",url,true);
				xmlhttp.setRequestHeader('local', 'local');
				xmlhttp.send();
			}
		}
		
		
		window.addEventListener("popstate", function()
		{
			get(window.location.href);
		});
		
		
		$(this).on('click',anniu,function()
		{
			url      = document.createElement("a");
			url.href = $(this).attr("href");
			post     = $(this).attr("post")
			get(url.href,post);
			
			
			if(window.location.href != url.href)
			{
				window.history.pushState(null, null, url.href);
				$("*").scrollTop (0);
				$("*").scrollLeft(0);
			}
			
			return false;
		});
	}
}