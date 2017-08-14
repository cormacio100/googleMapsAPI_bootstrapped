

/**
 * SCRIPT LAUNCHES WHEN THE PAGE LOADS
 *
 * global variables defined in displayMapAndMarker.js
 */
function prepareMap()
{
	console.log('initialising');
	
	// hide the siteDetails div until show site button is pressed
    document.getElementById('innerSiteDetails').style.display = 'none'; document.getElementById('innerSiteDetails').style.display = 'none';

    // show the loading div
    showLoading();

	// reference the initialise google map function
	initialise();

    // hide the loading div
    hideLoading();
	
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
	//var showMoreLess=document.getElementById('showMoreLess');
		
	/* create a click event for each button object */
	displayOnAirSitesBtn.onclick=function()
	{
		selectedCounty=document.getElementById('selectCounty');

        // display the loading div
       // showLoading();

        console.log('loading...');

		checkCounty();				/* see file chooseCounty.js */
		
		displayOnAirSites();		/* see file displayMapAndMarker.js */

        // hide the loading div
        //hideLoading();
	};
	
	displayControllersBtn.onclick=displayControllers;	/* see file displayMapAndMarker.js */
	
	clearSitesBtn.onclick=function()
	{
		// need to show less detail 
		//document.getElementById('toggleDiv').style.display = 'none';
		
		// hide the siteDetails div until show site button is pressed
    	document.getElementById('innerSiteDetails').style.display = 'none';
		
		clearSites();				/* see file setMarkers.js */
		
		link.setMap(null);          /* REMOVES POLYLINES  see displayMapAndMarkers.js */
	};
	
	//showMoreLess.onclick=divToggle;
	
	/* refresh OffAir Sites at a regular interval */
	setInterval(displayOffAirSites,20000);
	
};//end function