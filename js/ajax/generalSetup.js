function generalPageSetup(userType)
{
	let url = "";
	if(userType == "user")
		url = "php/panel/userPanel.php";
	else if(userType == "driver")
		url = "php/panel/driverPanel.php";

	
	$.ajax(
	{
		type: "GET",
		url: url,
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
				let date = new Date();
				let year = date.getFullYear();
				let month = date.getMonth() + 1;  // it have to be add 1 because it start from 0
				let time = date.getDate(); 	
				$(".panel .name").html("Hi, " + name);
				$(".panel .date").html(year + "-" + month + "-" + time);
			}
			catch(e)
			{
				console.log(response);
			}
		}
	});
	
}



function generalEventListenerSetup(userType)
{
	// order history
	$(".panelOption > .navList > li[data-index='1']").on("click", function(event)
	{
		// clear up the page
		$(".orderHistory .orders").html("");
		sendAjax(userType, "php/panel/orderHistory.php", orderHistory);
	});


	// current order
	$(".panelOption > .navList > li[data-index='2']").on("click", function(event)
	{
		// clear up the page
		$(".currentOrder .orders").html("");
		sendAjax(userType, "php/panel/currentOrder.php", currentOrder);
	});


	// get personal setting
	$(".panelOption > .navList > li[data-index='3']").on("click", function(event)
	{
		sendAjax(userType, "php/panel/getPersonalInformation.php", orderhistory);
	});



	// adding point
	$(".panelOption > .navList > li[data-index='4']").on("click", function(event)
	{
		sendAjax(userType, "php/panel/addingPoint.php", orderhistory);
	});


	// change personal setting
	$(".personalSetting .doneButton").on("click", function(event)
	{
		sendAjax(userType, "php/panel/changePersonalInformation.php", orderhistory);
	})
}