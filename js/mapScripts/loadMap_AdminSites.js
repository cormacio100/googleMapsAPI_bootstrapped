
/* when the page loads */
window.onload=function()
{
	console.log('loading data...');

    // declare variables for DOM objects
    var viewMapBtn= document.getElementById('viewMapBtn');
    var teamRegion=document.getElementById('teamRegion');
    var selectedCounty=document.getElementById('selectedCounty');
    var myModalLabel=document.getElementById('myModalLabel');
    myModalLabel.innerHTML='Map Loading';

    /* When the "View Map of Sites Button is clicked" */
    viewMapBtn.onclick=function()
    {
        console.log('Map button clicked');
        console.log('teamRegion is '+teamRegion.innerHTML);
        console.log('selectedCounty is '+selectedCounty.innerHTML);

        initialise();   /* googleMapAdmin.js */

        selectedCounty=document.getElementById('selectedCounty');

        selectedCounty.value=selectedCounty.innerHTML;

        checkCounty();  /* chooseCounty.js */

        myModalLabel.innerHTML='Mobile Sites Displayed';
    }

	// create a faultCounty Object
	//selectedCounty=document.getElementById('faultCounty');
	
	// display sites that are off air
	//displayOffAirSites();
	
	//checkCounty();
	
	// display sites that are on air
	//displayOnAirSites();
	
	/* refresh OffAir Sites at a regular interval */
	//setInterval(displayOffAirSites,20000);

};
