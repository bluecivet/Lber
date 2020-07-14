function generalSetup(userType)
{
	let url = "";
	if(url == "user")
		url = "php/panel/userPanel.php";
	else if(url == "driver")
		url = "php/panel/driverPanel.php";
	
	$.ajax(
	{
		type: "GET",
		url: "",
		error: function(response)
		{
			console.log(response);
		},
		success: function(response)
		{
			try
			{
				let obj = JSON.parse(response);
				let name = obj.name;
				$(".panel .name").html("Hi, " + name);
			}
			catch(e)
			{
				console.log(response);
			}
		}
	})
}