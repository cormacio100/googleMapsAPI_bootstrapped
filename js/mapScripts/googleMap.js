/* define map variable */
var map;

/* function to initialise and load the map to the page */
function initialise()
{
	console.log("map loading...");
	
	var myCenter=new google.maps.LatLng(53.423596, -7.934211);
			
	// create an object for map properties
	var mapProp={
		center: myCenter,
		zoom:7,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	};
	
	// create new google Maps object and pass in the location for where it will be displayed 
	// as well as the properties
	map= new google.maps.Map(document.getElementById("googleMap"),mapProp);	
	
	// Create the search box and link it to the UI element.
  	// place the input box in the top left hand corner of the map
 	var input = (document.getElementById('addrInput'));
  	
  	// position the input box on the map
  	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);	
  	
  	// define input box as a searchBox
  	var searchBox = new google.maps.places.SearchBox((input));
  	
	var latitude=document.getElementById('faultLatitude');
	var longitude=document.getElementById('faultLongitude');
	
	var reportedFault=new google.maps.LatLng(latitude.value,longitude.value);
			
	var marker=new google.maps.Marker({
		position:reportedFault,
		icon: 'img/fault_icon.png'
	});
	console.log('4');
	
	// specify which map to place the marker on
	marker.setMap(map);
	
	// then centre the map on the marker and zoom in
	var latLng = marker.getPosition();
	map.setCenter(latLng); // setCenter takes a LatLng object
	map.setZoom(11);
	
}

	
console.log('loading data...');
	
google.maps.event.addDomListener(window,'load',initialise);
	
