/* script displays markers on the map */

/* declare variables */
var map;	
var selectCounty;
var pageSource=null;				// variable used for displaying sites on the fault page
var prevMessageArray=[];		// needed to compare number of sites currently off air sites with previous number
										// if different then the On Air sites needs to be refreshed
var initLoad=true;					// iNdicates if the fault report page is loaded first time or not

var marker;

var link;	// for polylines

// Define variables for adding custom properties to marker objects
var objId;
var objLatitude;
var objLongitude;
var objName;
var objCounty;
var objOnAir;
var objController;
var objDCSRating;
var objGSMRating;
var objUSMRating;
var objLTERating;
var objTXNRating;
var objMPRN;
var objWentOffAir;
var objBackOnAir;
var objClusterId;
var objFieldEngId;
var objFirstName;
var objLastName;
var objTeamRegion;
var objHopsArray;

// define variables to hold DOM elements for DETAIL PANEL
var leftHeader=document.getElementById('leftHeader');
var spanTitle1=document.getElementById('spanTitle1');
var spanTitle2=document.getElementById('spanTitle2');
var spanTitle3=document.getElementById('spanTitle3');
var spanTitle4=document.getElementById('spanTitle4');
var spanTitle5=document.getElementById('spanTitle5');

var spanDetails1=document.getElementById('spanDetails1');
var spanDetails2=document.getElementById('spanDetails2');
var spanDetails3=document.getElementById('spanDetails3');
var spanDetails4=document.getElementById('spanDetails4');
var spanDetails5=document.getElementById('spanDetails5');

/*
 * Function clears the top and bottom half of the details panel
 */
function clearDetails()
{
	clearLessDetails();
	clearMoreDetails();
}

/*
 * Function adds map markers to relevant arrays for use in setMarker.js file to display them
 */
function addMarkerToArray(marker,callingFunction,objType)
{
	// add the marker to the relevant marker array
	if('displayOnAirSites'==callingFunction)
	{
		if('site'==objType)
		{
			onAirMarkers.push(marker);
		}
		else if('polyLine'==objType)
		{
			polyLineArr.push(marker);
		}
	}	
	else if('displayOffAirSites'==callingFunction)
	{	
		if('siteOffAir'==objType)
		{
			offAirMarkers.push(marker);
		}
		else if('polyLine'==objType)
		{
			polyLineArr.push(marker);
		}
	}
	else if('displayControllers'==callingFunction)
	{
		if('bsc'==objType)
		{
			bscMarkers.push(marker);
		}
		else if('rnc'==objType)
		{
			rncMarkers.push(marker);
		}
	}
	else if('displayReportedFaults'==callingFunction)
	{
		faultMarkers.push(marker);
	}		
}

/* 
 	Function receives JSON String for sites, controllers and faults and converts it to an array of relevant objects.
 	Each object then has a marker object created for it. Markers are then pushed onto a relevent marker array. 
 */
function displayData(stringJSON,callingFunction)
{
	var messageArray=JSON.parse(stringJSON);
	var i;
	
	// in order to refresh the markers on the map they need to first be cleared from the map
	clearMarker(callingFunction);		/* see file setMarkers.js */
	
	// if displayOffAirSites function is called need to check if more of less sites have gone off air since the last call
	// if yes then also need to refresh the sites that are on air
	if('displayOffAirSites'==callingFunction)
	{
		// compare the current MessageArray containing Off Air Sites to the old one
		// if not the same then set the variable for refreshOnAirSites
		if(messageArray.length!=prevMessageArray.length)
		{
			if(false==initLoad)
			{
				console.log('OffAir sites has changed so now On Air Sites will refresh');
				displayOnAirSites();
				
				// make sure markers get cleared
				refreshOnAirSites=true;		/* see file setMarkers.js */
			}
		}

        /* ######################################################### */
        /* TO DO -- COMPARE CONTENTS OF ARRAY THAT THEY ARE THE SAME */
        /* ######################################################### */

        console.log('refreshOnAirSites is '+refreshOnAirSites);

		// set the new message array to be the previous for the next instance
		prevMessageArray = messageArray;
		
		// left the page know that the offAir markers have now had an initial load
		initLoad=false;
		
	} //end if
	
	// loop through JSON array and create an object with properties for each
	for(i=0;i<messageArray.length;i++)
	{
		// define var to hold position of marker
		var markerPos;
		
		// define image icon to display
		var imgIcon;
	
		// check which type of Object needs to be created and create it with relevant position and Icon.
		if('displayControllers'==callingFunction)
		{
			var controllerObj=messageArray[i];	
			
			// define marker position for each object
			markerPos=new google.maps.LatLng(controllerObj.objLatitude,controllerObj.objLongitude);
			
			// create marker objects for Controllers
			if('bsc'==controllerObj.controllerType)
			{
				objType='bsc';
				imgIcon = getIcon(objType,controllerObj);
			}
			else if('rnc'==controllerObj.controllerType)
			{
				objType='rnc';
				imgIcon = getIcon(objType,controllerObj);
			}
			
			// create custom properties to add to each fault marker
			createCustomProperties(objType,controllerObj);		
		}
		else if('displayReportedFaults'==callingFunction)
		{
			// create a fault object for each index of the messageArray
			var faultObj=messageArray[i];
			
			// define marker position for each object
			var markerPos=new google.maps.LatLng(faultObj.objLatitude,faultObj.objLongitude);
			
			objType='fault';
			imgIcon = getIcon(objType,faultObj);
			
			// create custom properties to add to each fault marker
			createCustomProperties(objType,faultObj);           /* see file markerProperties.js */
		}
		else if('displayOnAirSites'==callingFunction || 'displayOffAirSites'==callingFunction)
		{
			// SITES
			
			// create a variable to hold object retrieved from JSON call
			var siteObj=messageArray[i];
			
			// define marker position for each object
			markerPos=new google.maps.LatLng(siteObj.objLatitude,siteObj.objLongitude);
			
			objType='site';
			imgIcon = getIcon(objType,siteObj);

			// check if sites off air has changes since last refresh. If yes then green markers also needs to be refreshed 
			if('displayOffAirSites'==callingFunction)
			{
				objType='siteOffAir';
			} 

			// create custom properties for each marker
			createCustomProperties(objType,siteObj);	
		}
		
		/*####################################
			create a marker for each object
		  ####################################*/
		if('displayOnAirSites'==callingFunction || 'displayOffAirSites'==callingFunction)
		{			
			marker = new google.maps.Marker({
				position: markerPos,
				icon: imgIcon,
				id: objId,										// custom property
				name: objName,									// custom property
				county: objCounty,								// custom property
				latitude: objLatitude,							// custom property
				longitude: objLongitude,						// custom property
				onAir: objOnAir,								// custom property
				controller: objController,						// custom property
				dcsRating: objDCSRating,						// custom property
				gsmRating: objGSMRating,						// custom property
				usmRating: objUSMRating,						// custom property
				lteRating: objLTERating,						// custom property
				txnRating: objTXNRating,						// custom property
				mprn: objMPRN,									// custom property
				clusterId: objClusterId,						// custom property
				fieldEngId: objFieldEngId,						// custom property
				fieldEngineer: objFirstName+' '+objLastName,	// custom property
				teamRegion: objTeamRegion,						// custom property
				hopsArray: objHopsArray,						// custom property
				wentOffAir: objWentOffAir,  					// custom property
				backOnAir: objBackOnAir,						// custom property
				type: objType,									// custom property
				title: 'Site '+objId, 
			});	
		}
		else if('displayReportedFaults'==callingFunction)
		{
			marker = new google.maps.Marker({
				position: markerPos,
				icon: imgIcon,
				id: objId,					// custom property
				msisdn: objMsisdn,			// custom property
				latitude: objLatitude,		// custom property
				longitude: objLongitude,	// custom property
				faultType: objFaultType,	// custom property
				type: objType,				// custom property 
				title: 'Fault '+objId,
			});

		}
		else if('displayControllers'==callingFunction)
		{			
			marker = new google.maps.Marker({
				position: markerPos,
				icon: imgIcon,
				id: objId,					// custom property
				latitude: objLatitude,		// custom property
				longitude: objLongitude,	// custom property
				msc: objMSC,			// custom property
				type: objType,				// custom property 
			});
			
			if('bsc'==objType)
			{
				marker.setTitle('BSC '+objId);
			}
			else if('rnc'==objType)
			{
				marker.setTitle('RNC'+objId);
			}

		}	
		
		// Add a listener to each marker that will display object details on page when the marker is clicked
		google.maps.event.addListener(marker, "click", function (event) 
		{
			var pLine=[];	// array to hold the lat and longitude of sites in hopsArray for drawing polyLine
			
			this.setAnimation(google.maps.Animation.BOUNCE);	
			
			// make sure the details pane is expanded
			document.getElementById('innerSiteDetails').style.display = 'block';
			
			// check the type of object being displayed and change the headings accordingly
			if('site'==this.type || 'siteOffAir'==this.type)
			{
				// clear the details pane
				clearDetails();				/* see file setMarkers.js */

                // show the  extra details link
                document.getElementById('morePanel').style.display = 'block';

                // set the SPECIFIC LABELS in the details window
				if (typeof(leftHeader) != 'undefined' && leftHeader != null)
			    {
					//leftHeader.innerHTML='Site Details';
                    leftHeader.innerHTML='<a href="#mainDetails" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"><span class="glyphicon glyphicon-phone"></span>Site Details</a>';
				}
				if (typeof(spanTitle1) != 'undefined' && spanTitle1 != null)
			    {
					spanTitle1.innerHTML='<span class="detailsDesc">Site ID: </span>';
				}
				if (typeof(spanTitle2) != 'undefined' && spanTitle2 != null)
			    {
					spanTitle2.innerHTML='<span class="detailsDesc">Site Latitude: </span>';
				}
				if (typeof(spanTitle3) != 'undefined' && spanTitle3 != null)
			    {
					spanTitle3.innerHTML='<span class="detailsDesc">Site Longitude: </span>';
				}
				if (typeof(spanTitle4) != 'undefined' && spanTitle4 != null)
			    {
					spanTitle4.innerHTML='<span class="detailsDesc">Site Name: </span>';
				}
				if (typeof(spanTitle5) != 'undefined' && spanTitle5 != null)
			    {
					spanTitle5.innerHTML='<span class="detailsDesc">County: </span>';
				}
				if (typeof(spanTitle6) != 'undefined' && spanTitle6 != null)
			    {
					spanTitle6.innerHTML='<span class="detailsDesc">On Air?: </span>';
				}
				if (typeof(spanTitle7) != 'undefined' && spanTitle7 != null)
			    {
					spanTitle7.innerHTML='<span class="detailsDesc">Controller: </span>';
				}
				if (typeof(spanTitle8) != 'undefined' && spanTitle8 != null)
			    {
					spanTitle8.innerHTML='<span class="detailsDesc">Sites Lower On Link: </span>';
				}
				if (typeof(spanTitle9) != 'undefined' && spanTitle9 != null)
			    {
					spanTitle9.innerHTML='<span class="detailsDesc">DCS Rating: </span>';
				}
				if (typeof(spanTitle10) != 'undefined' && spanTitle10 != null)
			    {
					spanTitle10.innerHTML='<span class="detailsDesc">GSM Rating: </span>';
				}
				if (typeof(spanTitle11) != 'undefined' && spanTitle11 != null)
			    {
					spanTitle11.innerHTML='<span class="detailsDesc">USM Rating: </span>';
				}
				if (typeof(spanTitle12) != 'undefined' && spanTitle12 != null)
			    {
					spanTitle12.innerHTML='<span class="detailsDesc">LTE Rating: </span>';
				}
				if (typeof(spanTitle13) != 'undefined' && spanTitle13 != null)
			    {
					spanTitle13.innerHTML='<span class="detailsDesc">TXN Rating: </span>';
				}
				if (typeof(spanTitle14) != 'undefined' && spanTitle14 != null)
			    {
					spanTitle14.innerHTML='<span class="detailsDesc">Cluster ID: </span>';
				}
				if (typeof(spanTitle15) != 'undefined' && spanTitle15 != null)
			    {
					spanTitle15.innerHTML='<span class="detailsDesc">Field Engineer: </span>';
				}
				if (typeof(spanTitle16) != 'undefined' && spanTitle16 != null)
			    {
					spanTitle16.innerHTML='<span class="detailsDesc">Team Region: </span>';
				}
				if (typeof(spanTitle17) != 'undefined' && spanTitle17 != null)
			    {
					spanTitle17.innerHTML='<span class="detailsDesc">MPRN: </span>';
				}
				if (typeof(spanTitle18) != 'undefined' && spanTitle18 != null)
			    {
					spanTitle18.innerHTML='<span class="detailsDesc">Date Off Air: </span>';
				}
				if (typeof(spanTitle19) != 'undefined' && spanTitle19 != null)
			    {
					spanTitle19.innerHTML='<span class="detailsDesc">Date Back On Air: </span>';
				}

				// set the SPECIFIC VALUES in the details window
				if (typeof(spanDetails4) != 'undefined' && spanDetails4 != null)
			    {
			    	spanDetails4.innerHTML=this.name;
			    }		
			    if (typeof(spanDetails5) != 'undefined' && spanDetails5 != null)
			    {
			    	spanDetails5.innerHTML=this.county;
			    }	
			    if (typeof(spanDetails6) != 'undefined' && spanDetails6 != null)
			    {
			    	spanDetails6.innerHTML=this.onAir;
			    }	
			   	if (typeof(spanDetails7) != 'undefined' && spanDetails7 != null)
			    {
			    	spanDetails7.innerHTML=this.controller;
			    }	
			    if (typeof(spanDetails8) != 'undefined' && spanDetails8 != null)
			    {
			    	// convert the sites hopsArray to a string
					var sitesOnLink='';

			    	// display the sites on the link
			    	for(i=0;i<this.hopsArray.length;i++)
			    	{
			    		// check the site id is properly defined
			    		if(this.hopsArray[i]['siteId']!='undefined' && this.hopsArray[i]['siteId'] != null)
			    		{
			    			sitesOnLink+=' '+this.hopsArray[i]['siteId'];
			    		
			    			// populate the PLine array for drawing PolyLines  
			    			pLine.push(new google.maps.LatLng(this.hopsArray[i]['latitude'],this.hopsArray[i]['longitude']));
			    		}
			    	}	

					// write string to page
				  	spanDetails8.innerHTML=sitesOnLink;
			    }	
			   	if (typeof(spanDetails9) != 'undefined' && spanDetails9 != null)
			    {
			    	spanDetails9.innerHTML=this.dcsRating;
			    }	
				if (typeof(spanDetails10) != 'undefined' && spanDetails10 != null)
			    {
			    	spanDetails10.innerHTML=this.gsmRating;
			    }	
			    if (typeof(spanDetails11) != 'undefined' && spanDetails11 != null)
			    {
			    	spanDetails11.innerHTML=this.usmRating;
			    }	
			    if (typeof(spanDetails12) != 'undefined' && spanDetails12 != null)
			    {
			    	spanDetails12.innerHTML=this.lteRating;
			    }	
			    if (typeof(spanDetails13) != 'undefined' && spanDetails13 != null)
			    {
			    	spanDetails13.innerHTML=this.txnRating;
			    }	
			  	if (typeof(spanDetails14) != 'undefined' && spanDetails14 != null)
			    {
			    	spanDetails14.innerHTML=this.clusterId;
			    }	
			    if (typeof(spanDetails15) != 'undefined' && spanDetails15 != null)
			    {
			    	spanDetails15.innerHTML=this.fieldEngineer;
			    }	
			   	if (typeof(spanDetails16) != 'undefined' && spanDetails16 != null)
			    {
			    	spanDetails16.innerHTML=this.teamRegion;
			    }	
			    if (typeof(spanDetails17) != 'undefined' && spanDetails17 != null)
			    {
			    	spanDetails17.innerHTML=this.mprn;
			    }	
			    if (typeof(spanDetails18) != 'undefined' && spanDetails18 != null)
			    {
			    	spanDetails18.innerHTML=this.wentOffAir;
			    }	
			    if (typeof(spanDetails19) != 'undefined' && spanDetails19 != null)
			    {
			    	spanDetails19.innerHTML=this.backOnAir;
			    }	

				// show the co-ordinates of linked sites in the console
				//for(i=0;i<pLine.length;i++)
				//{
					//console.log('co-ordinates'+pLine[i]);
				//}
	
				// display Polyline between sites that are on the same link
				link=new google.maps.Polyline({
					path:pLine,
					strokeColor:"#0000FF",
					strokeOpacity: 0.8,
					strokeWeight:2
				});
				
				// first need to clear any PolyLines from map
				clearPolyLine();								/* see file setMarkers.js	*/			
				
				// add the polyLine to an array for display
				addMarkerToArray(link,callingFunction,'polyLine');
				
				// display PolyLine between Markers
				for(var j=0; j<polyLineArr.length;j++)
				{
					polyLineArr[j].setMap(map);
				}
				
				// clear polyLines after 10 seconds
				setInterval(clearPolyLine,10000);	
			
			}
			else if('bsc'==this.type)
			{ 
				// clear the details pane
				clearDetails();				/* see file setMarkers.js */

                // hide extra details link
                document.getElementById('morePanel').style.display = 'none';

				leftHeader.innerHTML='<a href="#mainDetails" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"><span class="glyphicon glyphicon-phone"></span>BSC Controller Details</a>';
		    	spanTitle1.innerHTML='<span class="detailsDesc">BSC ID: </span>';
		    	spanTitle2.innerHTML='<span class="detailsDesc">BSC Latitude: </span>';
		    	spanTitle3.innerHTML='<span class="detailsDesc">BSC Longitude: </span>';
		    	spanTitle4.innerHTML='<span class="detailsDesc">MSC: </span>';

		    	// set the SPECIFIC MSC values in the details window -
				if (typeof(spanDetails4) != 'undefined' && spanDetails4 != null)
			    {
			    	spanDetails4.innerHTML=this.msc;
			    }		
			}
			else if('rnc'==this.type)
			{
				// clear the details pane
				clearDetails();				/* see file setMarkers.js */

                // hide extra details link
                document.getElementById('morePanel').style.display = 'none';

				leftHeader.innerHTML='<a href="#mainDetails" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"><span class="glyphicon glyphicon-phone"></span>RNC Controller Details</a>';
		    	spanTitle1.innerHTML='<span class="detailsDesc">RNC ID: </span>';
		    	spanTitle2.innerHTML='<span class="detailsDesc">RNC Latitude: </span>';
		    	spanTitle3.innerHTML='<span class="detailsDesc">RNC Longitude: </span>';
		    	spanTitle4.innerHTML='<span class="detailsDesc">MSC: </span>';

                // set the SPECIFIC MSC values in the details window
                if (typeof(spanDetails4) != 'undefined' && spanDetails4 != null)
                {
                    spanDetails4.innerHTML=this.msc;
                }
            }
			else if('fault'== this.type)
			{
				// clear the details pane
				clearDetails();				/* see file setMarkers.js */

                // hide extra details link
                document.getElementById('morePanel').style.display = 'none';

				// set the titles in the details window
				leftHeader.innerHTML='<a href="#mainDetails" class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"><span class="glyphicon glyphicon-phone"></span>Fault Details</a>';
				spanTitle1.innerHTML='<span class="detailsDesc">Fault ID:';
				spanTitle2.innerHTML='<span class="detailsDesc">Fault Latitude:';
				spanTitle3.innerHTML='<span class="detailsDesc">Fault Longitude:';
				spanTitle4.innerHTML='<span class="detailsDesc">Mobile Phone Number:';
				spanTitle5.innerHTML='<span class="detailsDesc">Fault Type:';
				
				// set the SPECIFIC values in the details window
				if (typeof(spanDetails4) != 'undefined' && spanDetails4 != null)
			    {
			    	spanDetails4.innerHTML=this.msisdn;
			    }		    
				if (typeof(spanDetails5) != 'undefined' && spanDetails5 != null)
			    {
			    	spanDetails5.innerHTML=this.faultType;
			    }
			}
			
			// populate the COMMON values
			if (typeof(spanDetails1) != 'undefined' && spanDetails1 != null)
		    {
		    	// if type is fault then user should be able to click on ID and view the fault report
		    	if('fault'== this.type)
		    	{
		    		spanDetails1.innerHTML='<a href="./mapReportFault?formId=2&action=review&faultId='+this.id+'">'+this.id+'</a>';
		    	}
		    	else
				{		    	
		    		spanDetails1.innerHTML=this.id;
		    	}
		    }	
			if (typeof(spanDetails2) != 'undefined' && spanDetails2 != null)
		    {
		    	spanDetails2.innerHTML=this.latitude;
		    }
			if (typeof(spanDetails3) != 'undefined' && spanDetails3 != null)
		    {
		    	spanDetails3.innerHTML=this.longitude;
		    }
		});
		
		
		// Add a listener to each marker to remove animation from it when the mouse moves away from it
		google.maps.event.addListener(marker,"mouseout",function(event)
		{
			this.setAnimation(null);
			this.setDraggable(false);
		});

		// add the marker to the relevant marker array
		addMarkerToArray(marker,callingFunction,objType);
		
	} // end for
	
	// send to function to display the markers
	showMarkers(callingFunction);
}

/* function sets dataSource to display sites on air */
function displayOnAirSites()
{
	console.log('refreshing sites on Air');
	
	// IF THE FUNCTION WAS CALLED FROM THE FAULT REPORT PAGE
	if('faultPage'==pageSource || 'googleMap1'==pageSource)
	{
		selectCounty='ALL';
	}
	else
	{
		// DOM object the value comes from depends on the form
		if (typeof(document.getElementById('selectCounty')) != 'undefined' && document.getElementById('selectCounty') != null)
		{
			selectCounty = document.getElementById('selectCounty').value;
		}	
		else if (typeof(document.getElementById('faultCounty')) != 'undefined' && document.getElementById('faultCounty') != null)
		{
			selectCounty = document.getElementById('faultCounty').value;
			
			// need to swap county name to abbreviated version e.g. Carlow to CW
			if(selectCounty.length>2)
			{
				selectCounty=convertCountyVal(selectCounty);
			}
		}			
	}

	// declare the local data source
	var dataSource = './mapFindMobileSites?selectCounty='+selectCounty;
	
	// declare the local name of the calling function
	var callingFunction='displayOnAirSites';
	
	// call the function to subit the AJAX request to retrieve the data
	// pass the dataSource & the calling function so that It knows which display function to use
	// and add markers to relevant array
	requestJSON(dataSource,callingFunction);

}//end function

/* function sets dataSource to display controllers */
function displayControllers()
{
	// declare the dataSource
	var dataSource='./mapFindControllers';
	
	// declare which function is making AJAX call
	var callingFunction='displayControllers';
	
	// call function to submit AJAX request
	requestJSON(dataSource,callingFunction);
}//end function

/* function clears sites from map display */
function clearSites()
{
	var callingFunction='clearSites';
	
	// send calling function to function to clear markers
	clearMarker(callingFunction);
}//end function

/* function sets dataSource to display off air sites */
function displayOffAirSites()
{
	clearPolyLine();	// clear the polylines
	
	// declare the dataSource
	var dataSource = './mapFindOffAirSites';
	
	// declare which function is making the AJAX call
	var callingFunction = 'displayOffAirSites';
	
	// call the function to submit AJAX request
	requestJSON(dataSource,callingFunction);
	
	// after first load tell page that this is not the first load any more
	intiLoad=false;
	
}//end function

/* function displays reported faults */
function displayReportedFaults()
{
	var dataSource;
	
	//declare the dataSource
	if('googleMap1'==pageSource)
	{
		dataSource="./findFaultsByEmailForMapMarkers&pageSource=googleMap1";
	}
	else
	{
		dataSource="./findFaultsByEmailForMapMarkers";
	}
	// declare the calling function
	var callingFunction='displayReportedFaults';
	
	// call the function to submit AJAX request
	requestJSON(dataSource,callingFunction);
}




