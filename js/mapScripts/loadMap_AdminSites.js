
/* when the page loads */
window.onload=function()
{
	console.log('loading data...');

    // declare variables for DOM objects
    var viewMapBtn= document.getElementById('viewMapBtn');
    var teamRegion=document.getElementById('teamRegion');
    selectedCounty=document.getElementById('selectedCounty');
    //var myModalLabel=document.getElementById('myModalLabel');
   // myModalLabel.innerHTML='Map Loading';


    /* When the "View Map of Sites Button is clicked" */
    viewMapBtn.onclick=function()
    {
        console.log('Map button clicked');
        console.log('teamRegion is '+teamRegion.innerHTML);
        console.log('selectedCounty is '+selectedCounty.value);

        initialise();   /* googleMapAdmin.js */

       // county=document.getElementById('selectedCounty');

       // console.log('county is '+county);

        //displayOffAirSites();

        //selectedCounty.value=displaySelectedCounty.innerHTML;

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
