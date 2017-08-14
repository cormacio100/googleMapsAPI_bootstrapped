/**
 * when the page loads
 * global variables defined in displayMapAndMarker.js
 */
function prepareMap()
{
	console.log('loading data...');
	
	// hide instructions div 
	document.getElementById('clickInstructions').style.display = 'none';
	
	// load the map and add a listener to it
	initialise();	
	
	// display sites off air
	displayOffAirSites();
	
	// create a faultCounty Object
	selectedCounty=document.getElementById('faultCounty');
	
	// check which county was loaded and zoom appropriately
	selectedCounty.onchange=function()
	{
		// zoom in on selected county
		checkCounty();
		
		// display sites on air for relevant county
		displayOnAirSites();
	};
	
	// create object for submit button
	var submitBtn = document.getElementById('submitFaultReport');

    /* refresh OffAir Sites at a regular interval */
    setInterval(displayOffAirSites,20000);
};
