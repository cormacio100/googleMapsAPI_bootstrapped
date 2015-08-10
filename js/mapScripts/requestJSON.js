
/* AJAX ready States */
var readyStates=[
	'0: UNSENT - XMLHttpRequest has been constructed',
	'1: OPENED - open() has been invoked, headers can be set, send() can now be invoked',
	'2: HEADERS RECEIVED - request has been sent & response headers have been received',
	'3: LOADING - request body is still being received',
	'4: DONE - Response has been fully received (or something went wrong- either way data transfer is complete)'
];

/* function submits AJAX request based on the datasource and callingFuncion passed to it */
function requestJSON(dataSource,callingFunction)
{
	console.log('submitting AJAX request');

	/*
	 * STEP 1 - Define Values
	 * 
	 * a - Data Source
	 * b - Http Request Obj
	 * c - asynch or non
	 * d - constant
	 */			
	var httpReq=new XMLHttpRequest();
	var asynchronous=true;
	var HTTP_REQUEST_COMPLETED=4;
	var PAGEFOUND=200;
	var PAGENOTFOUND=404;

	/*
	 * STEP 2 - DEFINE an anon function for handling a state change
	 */
	httpReq.onreadystatechange=function()
	{
		/*
		 * STEP 5 - retrieve the new ready state and check if complete
		 */
		if(HTTP_REQUEST_COMPLETED==httpReq.readyState)
		{
			/*
			 * STEP 6 - check response status and if found display on screen
			 */
			if(PAGEFOUND==httpReq.status)
			{
				// check what the calling function was so that JSON string can be sent to right function
				if('displayOnAirSites'==callingFunction)
				{
					displayData(httpReq.responseText,callingFunction);      /* see displayMapAndMarker.js */
				}
				else if('displayControllers'==callingFunction)
				{
					displayData(httpReq.responseText,callingFunction);
				}
				else if('displayOffAirSites'==callingFunction)
				{				
					displayData(httpReq.responseText,callingFunction);
				}
				else if('displayReportedFaults'==callingFunction)
				{
					displayData(httpReq.responseText,callingFunction);
				}
				else if('displayAdminSites'==callingFunction)
                {
                    displaySiteDataInATable(httpReq.responseText,callingFunction);
                }

			}
			else if(PAGENOTFOUND==httpReq.status)
			{
				document.getElementById("errorMessage").innerHTML='Error 404';
			} //end if
		} //end if
	};
	
	/*
	 * STEP 3 - Open the request
	 */
	httpReq.open('GET',dataSource,asynchronous);
	
	/*
	 * STEP 4 - Send the request
	 */
    httpReq.send();

} //end function