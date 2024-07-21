	let loadCount = 2;
	let loading = false;
	function loadMoreButton()
	{
		if (loading) {
			return;
		} else {
			loading = true;
		}
		
		$(".load-more-button button span:nth-child(1)").css("display","none");
		$(".load-more-button button span:nth-child(2)").css("display","inline-block");
		$.get(`textures.php?page=${loadCount}&findId=textures`,function(data){
			loadCount++;
			loading = false;
			$('.content-container').append(data);
			$(".load-more-button button span:nth-child(1)").css("display","inline-block");
			$(".load-more-button button span:nth-child(2)").css("display","none");
		});
	}
	function settexture(id)
	{
		$.getJSON("/weiw/index.php",{"mods":"mc_texture","id":id},function (result){
			if(result.error == "ok")
			{
				$(window.parent.document).find('#avatar img').attr('src',`/weiw/index_auth.php/avatar/${result.hash}/48`);
				showMessage('使用成功');
			}
			else
			{
				showMessage(result.error);
			}
		});
	}