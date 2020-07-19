$(function()
{
	// when the document load sed up
	generalPageSetup("driver");

	// place order called in error handling api end lberAjaxOperation.js

	generalEventListenerSetup("driver");


	// map 

	let map = document.getElementById("orderMap");
	let mapSetup = 
	{
		center: new google.maps.LatLng(51.508742,-0.120850),
		zoom: 12,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	let orderMap = new google.maps.Map(map, mapSetup);


	let geocoder = new google.maps.Geocoder();
	let city = $(".currentCity input").val();
	getCenterMapByCity(orderMap, geocoder, city);

	getCurrentOrderList(orderMap, geocoder);

	// current city input box set up
	console.log("set up on change event");
	$(".currentCity input").on("change", function()
	{
		let city = $(this).val();
		getCenterMapByCity(orderMap, geocoder, city);
		getCurrentOrderList(orderMap, geocoder);
	})
}) 


function getCenterMapByCity(map, geocoder, city)
{
	geocoder.geocode({"address":city}, function(result, state)
	{
		console.log("in geocoder");
		console.log(result);
		console.log(state);
		if(state==google.maps.GeocoderStatus.OK)
		{
			console.log("setting center");
			map.setCenter(result[0].geometry.location);
		}
	})
}



function getCurrentOrderList(map, geocoder)
{
	// clear current list first
	console.log("get order list");
	$(".currentOrderList .orderList").html("");
	let city = $(".currentCity input").val();
	$.ajax(
	{
		type: "GET",
		url: "php/panel/getCurrentOrderList.php",
		data: "city="+city,
		success: function(response)
		{
			currentOrderList(response, map, geocoder);
		}
	});
}





