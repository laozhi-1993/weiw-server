	let itemsId    = false;
	let itemsIame  = false;
	let itemsPrice = false;
	
	
	function determine()
	{
		if(itemsId && itemsName && itemsPrice)
		{
			$.getJSON("/weiw/index.php",{"mods":"mc_items_purchase","id":itemsId},function (result){
				window.parent.$(".checkin .money").html(result.money);
				showMessage(result.error);
			});
		}
		
		confirm();
	}
	
	
	function confirm(id,name,price)
	{
		if(id && name && price)
		{
			itemsId    = id;
			itemsName  = name;
			itemsPrice = price;
			$(".confirm .text span").text(`确定要花费${price}金币，购买${name}吗？`);
			$(".confirm").fadeIn();
			$("body").css('padding-right', '0');
			$("body").css('overflow-x', 'hidden');
			$("body").css('overflow-y', 'hidden');
		}
		else
		{
			itemsId    = false;
			itemsName  = false;
			itemsPrice = false;
			$(".confirm").fadeOut();
			$("body").css('padding-right', '5px');
			$("body").css('overflow-x', 'auto');
			$("body").css('overflow-y', 'scroll');
		}
	}