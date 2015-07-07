/*
 * SCRIPT SETS AND CLEAR MARKERS FROM THE MAP 
 * SCRIPT CLEARS MARKER DETAILS 
 */
var onAirMarkers=[];		// array to hold marker objects for sites on air
var offAirMarkers=[];		// array to hold marker objects for sites off air
var bscMarkers=[];			// array to hold markers objects for bsc controllers  
var rncMarkers=[];			// array to hold markers objects for rnc controllers 
var faultMarkers=[];		// array to hold markers objects for reported faults	
var polyLineArr=[];			// array to hold polyLines
var selectedCounty;			// the county selected by the user

var refreshOnAirSites=false;		// variable is set to true whenever on air sites need to be refresh

/* function clears the top section of details pane */
function clearLessDetails()
{
	/* CHECK DOM Object exists before populating */
	
	if (typeof(leftHeader) != 'undefined' && leftHeader != null)
	{
		leftHeader.innerHTML='Details';
	}
	if (typeof(leftHeader2) != 'undefined' && leftHeader2 != null)
	{
		leftHeader2.innerHTML='Fault Details';
	}
	if (typeof(spanTitle1) != 'undefined' && spanTitle1 != null)
	{
		spanTitle1.innerHTML='Click on Markers to Display Details';
	}
	if (typeof(spanTitle2) != 'undefined' && spanTitle2 != null)
	{
		spanTitle2.innerHTML='';
	}	
	if (typeof(spanTitle3) != 'undefined' && spanTitle3 != null)
	{
		spanTitle3.innerHTML='';
	}	
	if (typeof(spanTitle4) != 'undefined' && spanTitle4 != null)
	{
		spanTitle4.innerHTML='';
	}	
	if (typeof(spanTitle5) != 'undefined' && spanTitle5 != null)
	{
		spanTitle5.innerHTML='';
	}	
	if (typeof(spanTitle6) != 'undefined' && spanTitle6 != null)
	{
		spanTitle6.innerHTML='';
	}	
	if (typeof(spanTitle7) != 'undefined' && spanTitle7 != null)
	{
		spanTitle7.innerHTML='';
	}	
	if (typeof(spanTitle8) != 'undefined' && spanTitle8 != null)
	{
		spanTitle8.innerHTML='';
	}	
	
	
	if (typeof(spanDetails1) != 'undefined' && spanDetails1 != null)
	{
		spanDetails1.innerHTML='';
	}	
	if (typeof(spanDetails2) != 'undefined' && spanDetails2 != null)
	{
		spanDetails2.innerHTML='';
	}	
	if (typeof(spanDetails3) != 'undefined' && spanDetails3 != null)
	{
		spanDetails3.innerHTML='';
	}	
	if (typeof(spanDetails4) != 'undefined' && spanDetails4 != null)
	{
		spanDetails4.innerHTML='';
	}	
	if (typeof(spanDetails5) != 'undefined' && spanDetails5 != null)
	{
		spanDetails5.innerHTML='';
	}	
	if (typeof(spanDetails6) != 'undefined' && spanDetails6 != null)
	{
		spanDetails6.innerHTML='';
	}	
	if (typeof(spanDetails7) != 'undefined' && spanDetails7 != null)
	{
		spanDetails7.innerHTML='';
	}	
	if (typeof(spanDetails8) != 'undefined' && spanDetails8 != null)
	{
		spanDetails8.innerHTML='';
	}	

}

/* function clears the lower section of details pane */
function clearMoreDetails()
{
	if (typeof(spanTitle9) != 'undefined' && spanTitle9 != null)
	{
		spanTitle9.innerHTML='';
	}	
	if (typeof(spanTitle10) != 'undefined' && spanTitle10 != null)
	{
		spanTitle10.innerHTML='';
	}	
	if (typeof(spanTitle11) != 'undefined' && spanTitle11 != null)
	{
		spanTitle11.innerHTML='';
	}	
	if (typeof(spanTitle12) != 'undefined' && spanTitle12 != null)
	{
		spanTitle12.innerHTML='';
	}	
	if (typeof(spanTitle13) != 'undefined' && spanTitle13 != null)
	{
		spanTitle13.innerHTML='';
	}	
	if (typeof(spanTitle14) != 'undefined' && spanTitle14 != null)
	{
		spanTitle14.innerHTML='';
	}	
	if (typeof(spanTitle15) != 'undefined' && spanTitle15 != null)
	{
		spanTitle15.innerHTML='';
	}	
	if (typeof(spanTitle16) != 'undefined' && spanTitle16 != null)
	{
		spanTitle16.innerHTML='';
	}	
	if (typeof(spanTitle17) != 'undefined' && spanTitle17 != null)
	{
		spanTitle17.innerHTML='';
	}	
	if (typeof(spanTitle18) != 'undefined' && spanTitle18 != null)
	{
		spanTitle18.innerHTML='';
	}	
	if (typeof(spanTitle19) != 'undefined' && spanTitle19 != null)
	{
		spanTitle19.innerHTML='';
	}	
	
	
	if (typeof(spanDetails9) != 'undefined' && spanDetails9 != null)
	{
		spanDetails9.innerHTML='';
	}	
	if (typeof(spanDetails10) != 'undefined' && spanDetails10 != null)
	{
		spanDetails10.innerHTML='';
	}	
	if (typeof(spanDetails11) != 'undefined' && spanDetails11 != null)
	{
		spanDetails11.innerHTML='';
	}	
	if (typeof(spanDetails12) != 'undefined' && spanDetails12 != null)
	{
		spanDetails12.innerHTML='';
	}	
	if (typeof(spanDetails13) != 'undefined' && spanDetails13 != null)
	{
		spanDetails13.innerHTML='';
	}	
	if (typeof(spanDetails14) != 'undefined' && spanDetails14 != null)
	{
		spanDetails14.innerHTML='';
	}	
	if (typeof(spanDetails15) != 'undefined' && spanDetails15 != null)
	{
		spanDetails15.innerHTML='';
	}	
	if (typeof(spanDetails16) != 'undefined' && spanDetails16 != null)
	{
		spanDetails16.innerHTML='';
	}	
	if (typeof(spanDetails17) != 'undefined' && spanDetails17 != null)
	{
		spanDetails17.innerHTML='';
	}	
	if (typeof(spanDetails18) != 'undefined' && spanDetails18 != null)
	{
		spanDetails18.innerHTML='';
	}	
	if (typeof(spanDetails19) != 'undefined' && spanDetails19 != null)
	{
		spanDetails19.innerHTML='';
	}			

}

/* function sets the map for all markers in the relevant array */
function setAllMap(map,location,callingFunction)
{
	if('displayOnAirSites'==callingFunction)
	{
		// display green markers 
		for(var i=0; i<onAirMarkers.length;i++)
		{
			//alert(onAirMarkers[i].toSource());
			onAirMarkers[i].setMap(map);
		}
	}
	else if('displayOffAirSites'==callingFunction)
	{
		for(var i=0; i<offAirMarkers.length;i++)
		{
			offAirMarkers[i].setMap(map);
		}
	} 
	else if('displayControllers'==callingFunction)
	{
		// add the rnc markers to the map		
		for(var i=0; i<rncMarkers.length;i++)
		{
			rncMarkers[i].setMap(map);
		}
		
		// add the bsc markers to the map
		for(var j=0; j<bscMarkers.length;j++)
		{
			bscMarkers[j].setMap(map);
		}
	}
	else if('clearSites'==callingFunction)
	{
		// check that map object is null or undefined. 
		// if so then it will remove the map markers
		if(map===undefined || map===null)
		{
			for(var i=0; i<onAirMarkers.length;i++)
			{
				onAirMarkers[i].setMap(map);
			}	
			for(var j=0; j<offAirMarkers.length;j++)
			{
				offAirMarkers[j].setMap(map);
			}	
			for(var k=0; k<rncMarkers.length;k++)
			{
				rncMarkers[k].setMap(map);
			}
			for(var l=0; l<bscMarkers.length;l++)
			{
				bscMarkers[l].setMap(map);
			}
			for(var m=0; m<polyLineArr.length;m++)
			{
				polyLineArr[m].setMap(map);
			}
		
			// 1 - call a function to clear the text from the details div
			clearLessDetails();
			// ensure the bottom half of the deatils pane is clear
			clearMoreDetails();
			// show less details
			divToggle();
			
			// 2 - the county selection should change back to ALL and the map should zoom out and center on athlone
			selectedCounty=document.getElementById('selectCounty');
			selectedCounty.value='ALL';
			checkCounty();
			
		}// end if
	}
	else if('displayFaultLocation'==callingFunction)
	{
		// create faultLatitude and faultLongitude objects
		var faultLatitude = document.getElementById('faultLatitude');
		var faultLongitude = document.getElementById('faultLongitude');
		
		for(var i=0; i<faultMarkers.length;i++)
		{
			faultMarkers[i].setMap(map);
			
			if(map===undefined || map===null)
			{
				// if the marker is being cleared the text should be removed from the input boxes also
				faultLatitude.value='';
				faultLongitude.value='';
			}
			else
			{
				// otherwise the input boxes should display the lat and longitude
				faultLatitude.value=location.lat();
				faultLongitude.value=location.lng();
			}
		}
	} 
	else if('displayReportedFaults' == callingFunction)
	{
		for(var i=0; i<faultMarkers.length;i++)
		{
			faultMarkers[i].setMap(map);
		}	
	}	// end if
	else if('clearPolyLine' == callingFunction)
	{
		for(var i=0; i<polyLineArr.length;i++)
		{
			polyLineArr[i].setMap(map);
		}
	}

} // end if 

/* function displays Markers depending on calling function */
function showMarkers(callingFunction)
{
	setAllMap(map,null,callingFunction);
}

/* function clears markers from map and removes any reference to them */
function clearMarker(callingFunction)
{
	// remove the markers from the map
	setAllMap(null,null,callingFunction);
	
	//alert('refreshOnAirSites '+refreshOnAirSites);
	
	// check which array of markers needs to be emptied
	if('displayOnAirSites'==callingFunction)
	{
		onAirMarkers=[];
		polyLineArr=[];
	}
	else if('displayOffAirSites'==callingFunction)
	{
		offAirMarkers=[];
		polyLineArr=[];
	}
	else if('displayControllers'==callingFunction)
	{
		bscMarkers=[];
		rncMarkers=[];
	}
	else if('clearSites'==callingFunction)
	{
		onAirMarkers=[];
		offAirMarkers=[];
		bscMarkers=[];
		rncMarkers=[];
		polyLineArr=[];
	}
	else if('displayFaultLocation'==callingFunction || 'displayReportedFault' == callingFunction)
	{
		faultMarkers=[];
	}
}

/* function clears polyLine from map to refresh it */
function clearPolyLine()
{
	// set the calling function variable
	callingFunction='clearPolyLine';
	
	// remove the markers from the map
	setAllMap(null,null,callingFunction);
	
	// clear the array
	polyLineArr=[];
}
