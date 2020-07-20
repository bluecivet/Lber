$(function()
{
	// when the document load sed up
	generalPageSetup("driver");

	// place order called in error handling api end lberAjaxOperation.js

	generalEventListenerSetup("driver");


	// map 

	let mapEle = document.getElementById("orderMap");
	let orderMap = getMap(mapEle);
	let geocoder = new google.maps.Geocoder();
	let directionsService = new google.maps.DirectionsService();
	let directionsRenderer = new google.maps.DirectionsRenderer();
	directionsRenderer.setMap(orderMap);
	
	let city = $(".currentCity input").val();
	getCenterMapByCity(orderMap, geocoder, city);

	getCurrentOrderList(orderMap, geocoder, directionsService, directionsRenderer);

	// current city input box set up
	$(".currentCity input").on("change", function()
	{
		let city = $(this).val();
		getCenterMapByCity(orderMap, geocoder, city);
		getCgetCurrentOrderList(orderMap, geocoder, directionsService, directionsRenderer);
	})
}) 





function getCurrentOrderList(map, geocoder, directionsService, directionsRenderer)
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
			currentOrderList(response, map, geocoder, directionsService, directionsRenderer);
		}
	});
}





