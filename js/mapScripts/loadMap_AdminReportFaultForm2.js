
/* when the page loads */
function prepareMap()
{
	console.log('loading data...');
	
	// hide instructions div 
	document.getElementById('clickInstructions').style.display = 'none';
	
	initialise2();	
	
	// create a faultCounty Object
	selectedCounty=document.getElementById('faultCounty');
	
	// display sites that are off air
	displayOffAirSites();
	
	checkCounty();
	
	// display sites that are on air
	displayOnAirSites();
	
	/* refresh OffAir Sites at a regular interval */
	setInterval(displayOffAirSites,20000);

};
