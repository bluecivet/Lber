$(function()
{
	$(".quectionBox").on("click", function()
	{
		let answerBox = $(this).next();
		answerBox.children().eq(0).slideToggle();
		$(this).find("i").toggleClass("fa-rotate-270");
		
	});
})
