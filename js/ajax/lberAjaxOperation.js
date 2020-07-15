
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
function placeOrderFormSubmit(form)
{
	let formData = new FormData(form);
	//formData.append("orderDiscription");
	console.log(formData.get("orderDiscription"));
	console.log($("#orderDiscription").val());
	console.log($("#orderDiscription").html());
	$.ajax(
	{
		type: "POST",
		url: "php/panel/placeOrder.php",
		data: formData,
		contentType: false,
		processData: false,
		error: function(response)
		{
			console.log(response);
		},
		success: function(response)
		{
			placeOrder(response);
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

}


// function change personal setting
function changePersonalInformation(response)
{

}


// adding point
function addingPoint(response)
{

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