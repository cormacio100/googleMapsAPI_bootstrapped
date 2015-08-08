
/* when the page loads */
window.onload=function()
{
	console.log('initialising');
	
	// hide the siteDetails div until show site button is pressed
    document.getElementById('innerSiteDetails').style.display = 'none';

    // hide extra details div
    document.getElementById('toggleDiv').style.display = 'none';
	
	// reference the initialise google map function
	initialise();
	
	// display markers for reported faults
	displayReportedFaults(); 				/* see file displayMapAndMarker.js */
	
	// tell the page that this is the first time loading
	initLoad=true;							/* see file displayMapAndMarker.js */
	
	// display sites that are off air once the map loads. Do not wait for the refresh below
	displayOffAirSites();					/* see file displayMapAndMarker.js */
	
	// create button objects
	var displayOnAirSitesBtn=document.getElementById('displayOnAirSitesBtn');
	var displayControllersBtn=document.getElementById('displayControllersBtn');
	var clearSitesBtn=document.getElementById('clearSitesBtn');

	/* create link object */
	var showMoreLess=document.getElementById('showMoreLess');
		
	/* create a click event for each button object */
	displayOnAirSitesBtn.onclick=function()
	{
		selectedCounty=document.getElementById('selectCounty');

		checkCounty();				/* see file chooseCounty.js */
		
		displayOnAirSites();		/* see file displayMapAndMarker.js */
	};
	
	displayControllersBtn.onclick=displayControllers;	/* see file displayMapAndMarker.js */
	
	clearSitesBtn.onclick=function()
	{
		// need to show less detail 
		document.getElementById('toggleDiv').style.display = 'none';
		
		// hide the siteDetails div until show site button is pressed
    	document.getElementById('innerSiteDetails').style.display = 'none';
		
		clearSites();				/* see file setMarkers.js */
		
		link.setMap(null);
	};
	
	showMoreLess.onclick=divToggle;			
	
	/* refresh OffAir Sites at a regular interval */
	setInterval(displayOffAirSites,20000);
	
};//end function