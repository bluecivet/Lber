$(function()
{
	$(".navList li").on("click", function()
	{
		$(".navList li").attr("class", "");
		$(this).toggleClass("active");

		// writing which area to show
		let index = $(this).attr("data-index");
		console.log(index);
		$(".displayArea > div").hide();
		$(".displayArea").children().eq(index).show();
	});


});
