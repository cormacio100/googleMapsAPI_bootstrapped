
/* initialise and display the map */
function initialise()
{
	console.log('map loading');
	
	// focus center of map on center of the country e.g. Athlone
	var myCenter=new google.maps.LatLng(53.427822, -7.938372);
	
	// create a map property object
	var mapProp={
		center: myCenter,
		zoom: 6,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	
	// create new google map object
	map = new google.maps.Map(document.getElementById('googleMapAdmin'),mapProp);
}//end function
