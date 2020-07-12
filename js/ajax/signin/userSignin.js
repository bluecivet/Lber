$(function()
{
	$("loginButton[type='button']").on("click", function()
	{
		$.ajax(
		{
			type: "POST",
			url: "./php/signin/userSignin.php",
			success: function(response)
			{
				console.log(response);
			}
		})
	});
});