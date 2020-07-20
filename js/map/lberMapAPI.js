function getMap(mapEle)
{
	let mapSetup = 
	{
		center: new google.maps.LatLng(51.508742,-0.120850),
		zoom: 12,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	return new google.maps.Map(mapEle, mapSetup);
}


function getCenterMapByCity(map, geocoder, city)
{
	geocoder.geocode({"address":city}, function(result, state)
	{
		if(state==google.maps.GeocoderStatus.OK)
		{
			console.log("setting center");
			map.setCenter(result[0].geometry.location);
		}
	})
}


function acceptOrderMapMarkerSetup(data, map, marker, infowindow, directionsService, directionsRenderer)
{
	marker.addListener('click', function() 
	{
		directionsRenderer.setMap(map);

	    infowindow.open(map, marker);
	    google.maps.event.addListener(infowindow, 'closeclick', function() 
	    {
	          console.log("info close");
	          directionsRenderer.setMap(null);
	    });

	    var request = 
	    {
	        origin: data.fromAddress,
	        destination: data.toAddress,
	        travelMode: 'DRIVING'
	    };

	     directionsService.route(request, function(result, status) 
	     {
	       if (status == 'OK') 
	       {
	         directionsRenderer.setDirections(result);
	       }
	     });

	});

}