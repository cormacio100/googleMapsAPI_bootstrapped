
/* initialise and display the map */
function initialise()
{
	console.log('map loading');
	
	// focus center of map on center of the country e.g. Athlone
	var myCenter=new google.maps.LatLng(53.423596,-7.934211);
	
	// create a map property object
	var mapProp={
		center: myCenter,
		zoom: 7,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	// create new google map object
	map = new google.maps.Map(document.getElementById('googleMap'),mapProp);
}//end function
