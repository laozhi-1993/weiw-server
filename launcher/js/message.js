	function showMessage(text)
	{
		messageId   = +new Date();
		messageHtml = $(".result data").html();
		messageHtml = messageHtml.replace(/{id}/g, messageId);
		messageHtml = messageHtml.replace(/{error}/g, text);


		$("html").scrollTop(0);
		$("body").scrollTop(0);
		$(".result").prepend(messageHtml);
		setTimeout( removeMessage, 3000, messageId);
	}
	function removeMessage(id)
	{
		$("#"+id).fadeOut(function (){
			$("#"+id).remove();
		});
	}