
// this is a api for user and driver

function sendAjax(userType, url, success)
{
	$.ajax(
	{
		type: "GET",
		url: url,
		data: "userType="+userType,
		success: success,
		error: function(response)
		{
			console.log(response);
		},
	});
}


// submit place order
function formSubmit(form, url, success, userType)
{
	let formData = new FormData(form);

	// check if a correct usertype is enter
	if(userType == "driver")
		formData.append("userType", "driver");
	else if(userType == "user")
		formData.append("userType", "user");

	$.ajax(
	{
		type: "POST",
		url: url,
		data: formData,
		contentType: false,
		processData: false,
		error: function(response)
		{
			console.log(response);
		},
		success: function(response)
		{
			success(response);
		}
	});
}


// place order
function placeOrder(response)
{
	if(response == "good")
	{
		alert("your order is processed!");
		window.location.assign(window.location);
	}
	else
	{
		console.log(response);
	}
}


// get order history
function orderHistory(response)
{
	console.log(response);
	try
	{
		let data = JSON.parse(response);
		for(let i = 0; i < data.length; i++)
		{
			let anOrder = generateOrder(data[i]);
			$(".orderHistory > .orders").append(anOrder);
			console.log("finish append");
		}
	}
	catch(e)
	{
		console.log(response)
	}
	
}


// currentOrder

function currentOrder(response)
{
	try
	{
		let data = JSON.parse(response);
		for(let i = 0; i < data.length; i++)
		{
			let anOrder = generateOrder(data[i]);
			$(".currentOrder > .orders").append(anOrder);
			console.log("finish append");
		}
	}
	catch(e)
	{
		console.log(response)
	}
}


// function get personal setting
function getPersonalInformation(response)
{
	try
	{
		let data = JSON.parse(response);
		let userName = data.userName;
		let email = data[0].email;
		let phone = data[0].phone;

		$(".personalSetting .email input").val(email);
		$(".personalSetting .phone input").val(phone);
		$(".personalSetting .userName input").val(userName);

	}
	catch(e)
	{
		console.log(response);
	}
}


// function change personal setting
// this function is when response success return
// sending the form is in panelFormErrorHandle.js
function changePersonalInformation(response)
{
	if(response == "good")
	{
		alert("your setting is changed");
		window.location.replace("html/login.html");
		return;
	}
	
	try
	{
		let data = JSON.parse(response);

		for(key in data)
		{
			let labelClass = ".personalSetting ."+key+ " label";
			$(labelClass).html(data[key]);
			$(labelClass).toggleClass("errorMessage");
		}
	}
	catch(e)
	{
		console.log(response)
	}
}


//
function currentPoint(response)
{
	try 
	{
		let data = JSON.parse(response);
		let point = data.point;
		$(".banking .currentPointLabel").html(point);
	}
	catch(e)
	{
		console.log(response);
	}
}


// adding point
function addingPoint(response)
{
	if(response == "good")
	{
		alert("your point has been added!");
		window.location.replace(window.location);
		return;
	}
	else
	{
		alert("some error happend! please try again");
		console.log(response);
		return;
	}
}



///////////////////////////////////////////////////////////////////////////


function generateOrder(data)
{
	console.log(data);
	let anOrder = $("<div class = 'anOrder'></div>");
	let section = 
	[
		{
			className : "orderName", 
			orderLabel: "order name: ", 
			labelContent: data.orderName,
			container: "label"
		},
		{
			className : "carrying", 
			orderLabel: "carrying: ", 
			labelContent: data.carring,
			container: "label"
		},
		{
			className : "orderDate", 
			orderLabel: "order date: ", 
			labelContent: data.placeOrderTime,
			container: "label"
		},
		{
		   className : "deliveryDate",
		   orderLabel: "delivery date:",
		   labelContent: data.deliveryDate,
		   container: "label"
		},
		{
			className : "from", 
			orderLabel: "from: ", 
			labelContent: data.fromAddress,
			container: "address"
		},
		{
			className : "to",
			orderLabel: "to: ",
			labelContent: data.toAddress,
			container: "address"
		},
		{
			className : "orderDiscription",
			orderLabel: "description",
			labelContent: data.description,
			container: "p"
		}
	];

	console.log(section);

	for(let i = 0; i < section.length; i++)
	{
		let className = section[i].className;
		let label = section[i].orderLabel;
		let content = section[i].labelContent;
		let container = section[i].container;

		// create 
		let sectionBox = $("<div class='"+className+"'></div>");
		let sectionLabel = $("<label class = 'orderLabel'></label>");
		sectionLabel.html(label);
		let sectionContent = $("<"+container+" class = 'labelContent'></"+container+">");
		sectionContent.html(content);
		sectionBox.append(sectionLabel);
		sectionBox.append(sectionContent);
		anOrder.append(sectionBox);
	}
	return anOrder;
}