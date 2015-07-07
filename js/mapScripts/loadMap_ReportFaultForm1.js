// when the page loads
window.onload=function()
{
	console.log('loading data googlemap1.js...');

	initialise();
	
	// define page source to tell displayReportedFaults() and displayOnAirSites() functions that all functions should be displayed
	pageSource='googleMap1';

	displayReportedFaults();	// display all Faults that have been raised
};

