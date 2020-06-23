$(function()
{
	let windowWidth = $(document).width();
	let lastWindowWidth = windowWidth;
	let bounce = 1000;

	window.addEventListener("resize", function()
	{
		windowWidth = $(document).width();	// get the newest data

		if((windowWidth < bounce && lastWindowWidth > bounce) || (windowWidth > bounce && lastWindowWidth < bounce))
		{
			window.location.reload();	// reflesh
		}
		
	});

	if(windowWidth < bounce)
	{
		phoneNavListStyle();
	}
	

	
});