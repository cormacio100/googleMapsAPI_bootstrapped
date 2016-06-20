/* define variables */
var map;
var faultId=null;

/* function to place a marker on the map and display the latitude and longitude */
function placeMarker(location,callingFunction)
{
	// we only ever want one marker in the marker array so it needs to me cleared each time
	clearMarker(callingFunction);

	// check the status of the fault
	var faultStatus=document.getElementById('faultStatus').value;

	// create marker
	var marker = new google.maps.Marker({
		position: location,
	});
	
	if('closed'==faultStatus)
	{
		marker.setIcon('img/closed_fault_icon.png');
	}
	else
	{
		marker.setIcon('img/fault_icon.png');
	}
	
	// set the title of the fault if possible
	if(null!=faultId)
	{
		marker.setTitle('Fault '+faultId);
	}
	
	//markersArray.push(marker);
	faultMarkers.push(marker);
	
	// send to function to display the marker
	setAllMap(map,location,callingFunction);
}

/* function to initialise and load the map to the page. Function used when viewing a fault*/
function initialise2()
{
	console.log("map loading...");
	
	var callingFunction='displayReportedFaults';
	
	// create an object for map properties
	var mapProp={
		center: myCenter,
		zoom:7,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	};
	
	// create new google Maps object and pass in the location for where it will be displayed 
	// as well as the properties
	map= new google.maps.Map(document.getElementById("googleMap"),mapProp);	
	
	// create 
	// create faultLatitude and faultLongitude objects
	var faultLatitude = document.getElementById('faultLatitude');
	var faultLongitude = document.getElementById('faultLongitude');
	
	if (typeof(document.getElementById('faultId')) != 'undefined' && document.getElementById('faultId') != null)
	{
		faultId=document.getElementById('faultId').value;
	}
	
	// set the location for the marker
	var location=new google.maps.LatLng(faultLatitude.value, faultLongitude.value);

	// place the marker on the map
	placeMarker(location, callingFunction);		// write to placeMarker function

}


/* function to initialise and load the map to the page. Function used when reporting a fault*/
function initialise()
{
	console.log("map loading...");
	
	var callingFunction='displayFaultLocation';
	
	// create an object for map properties
	var mapProp={
		center: myCenter,
		zoom:7,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	};
	
	// create new google Maps object and pass in the location for where it will be displayed 
	// as well as the properties
	map= new google.maps.Map(document.getElementById("googleMap"),mapProp);	
		
	// add a listener to the map
	google.maps.event.addListener(map,'click',function(event)
	{
		placeMarker(event.latLng,callingFunction);		// write to placeMarker function
	});
}
