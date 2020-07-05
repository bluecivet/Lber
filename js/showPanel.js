$(function()
{
	$(".navList li").on("click", function()
	{
		$(".navList li").attr("class", "");
		$(this).toggleClass("active");

		// writing which area to show

	});
});