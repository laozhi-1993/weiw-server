	function tips(text)
	{
		tips_id   = +new Date();
		tips_html = $(".result data").html();
		tips_html = tips_html.replace(/{id}/g, tips_id);
		tips_html = tips_html.replace(/{error}/g, text);


		$("html").scrollTop(0);
		$("body").scrollTop(0);
		$(".result").prepend(tips_html);
		setTimeout( tips_remove, 3000, tips_id);
	}
	function tips_remove(id)
	{
		$("#"+id).fadeOut(function (){
			$("#"+id).remove();
		});
	}