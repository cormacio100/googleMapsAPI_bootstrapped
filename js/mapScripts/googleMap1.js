/* define map variable */
var global_map;

/* function to initialise and load the map to the page */
function initialise()
{
	var myCenter=new google.maps.LatLng(53.423596, -7.934211);
			
	// create an object for map properties
	var mapProp={
		center: myCenter,
		zoom:7,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	};
	
	// create new google Maps object and pass in the location for where it will be displayed 
	// as well as the properties
	global_map = new google.maps.Map(document.getElementById("googleMap"),mapProp);	

	console.log("map loaded...");
}
