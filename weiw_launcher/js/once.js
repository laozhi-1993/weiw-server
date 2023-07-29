	function once()
	{
		let state = true;
		return function( callback )
		{
			if(state)
			{
				state = false;
				callback(() => { state = true });
			}
		}
	}