/* 
 * Script is used for centering and zooming in on a chosen county 
 */

/* define center for each County */
//var myCenter=new google.maps.LatLng(53.423596, -7.934211);
var myCenter = {lat:53.423596, lng:-7.934211};
//var clareCenter = new google.maps.LatLng(52.897656, -9.001446);
var clareCenter = {lat:52.897656, lng:-9.001446};
//var corkCenter = new google.maps.LatLng(51.888218, -8.500987);
var corkCenter = {lat:51.888218, lng:-8.500987};
//var cavanCenter = new google.maps.LatLng(54.004074, -7.414240);
var cavanCenter = {lat:54.004074, lng:-7.414240};
//var carlowCenter = new google.maps.LatLng(52.835880, -6.919208);
var carlowCenter = {lat:52.835880, lng:-6.919208};
//var donegalCenter = new google.maps.LatLng(54.897377, -7.998693);
var donegalCenter = {lat:54.897377, lng:-7.998693};
//var dublinCenter = new google.maps.LatLng(53.347896, -6.276414);
var dublinCenter = {lat:53.347896, lng:-6.276414};
//var galwayCenter = new google.maps.LatLng(53.271637, -9.060255);
var galwayCenter = {lat:53.271637, lng:-9.060255};
//var kildareCenter = new google.maps.LatLng(53.161312, -6.905107);
var kildareCenter = {lat:53.161312, lng:-6.905107};
//var kilkennyCenter = new google.maps.LatLng(52.653602, -7.245838);
var kilkennyCenter = {lat:52.653602, lng:-7.245838};
//var kerryCenter = new google.maps.LatLng(52.014322, -9.769697);
var kerryCenter = {lat:52.014322, lng:-9.769697};
//var longfordCenter = new google.maps.LatLng(53.727550, -7.795861);
var longfordCenter = {lat:53.727550, lng:-7.795861};
//var louthCenter = new google.maps.LatLng(53.912289, -6.471961);
var louthCenter = {lat:53.912289, lng:-6.471961};
//var limerickCenter = new google.maps.LatLng(52.659897, -8.624132);
var limerickCenter = {lat:52.659897, lng:-8.624132};
//var leitrimCenter = new google.maps.LatLng(54.185595, -8.064960);
var leitrimCenter = {lat:54.185595, lng:-8.064960};
//var laoisCenter = new google.maps.LatLng(52.981514, -7.371835);
var laoisCenter = {lat:52.981514, lng:-7.371835};
//var meathCenter = new google.maps.LatLng(53.626562, -6.764452);
var meathCenter = {lat:53.626562, lng:-6.764452};
//var monaghanCenter = new google.maps.LatLng(54.171889, -6.910285);
var monaghanCenter = {lat:54.171889, lng:-6.910285};
//var mayoCenter = new google.maps.LatLng(53.949901, -9.334534);
var mayoCenter = {lat:53.949901, lng:-9.334534};
//var offalyCenter = new google.maps.LatLng(53.203317, -7.658506);
var offalyCenter = {lat:53.203317, lng:-7.658506};
//var roscommonCenter = new google.maps.LatLng(53.708854, -8.230562);
var roscommonCenter = {lat:53.708854,lng:-8.230562};
//var sligoCenter = new google.maps.LatLng(54.273512, -8.482532);
var sligoCenter = {lat:54.273512, lng:-8.482532};
//var tipperaryCenter = new google.maps.LatLng(52.662315, -7.961775);
var tipperaryCenter = {lat:52.662315, lng:-7.961775};
//var waterfordCenter = new google.maps.LatLng(52.253049, -7.113459);
var waterfordCenter = {lat:52.253049, lng:-7.113459};
//var westmeathCenter = new google.maps.LatLng(53.513374, -7.483095);
var westmeathCenter = {lat:53.513374, lng:-7.483095};
//var wicklowCenter = new google.maps.LatLng(52.990023, -6.360773);
var wicklowCenter = {lat:52.990023, lng:-6.360773};
//var wexfordCenter = new google.maps.LatLng(52.334171, -6.474478);
var wexfordCenter = {lat:52.334171, lng:-6.474478};

/* function converts full county name to abbreviated couty name - for use in Review Reported Fault page */
function convertCountyVal(countyVal)
{
	var convertedCountyVal;
	
	if('Clare' == countyVal)
	{
		convertedCountyVal = 'CE';
	}
	else if('Cork' == countyVal)
	{
		convertedCountyVal = 'CK';
	}
	else if('Cavan' == countyVal)
	{
		convertedCountyVal = 'CN';
	}
	else if('Carlow' == countyVal)
	{
		convertedCountyVal = 'CW';
	}
	else if('Donegal' == countyVal)
	{
		convertedCountyVal = 'DL';
	}
	else if('Dublin' == countyVal)
	{
		convertedCountyVal = 'DN';
	}
	else if('Galway' == countyVal)
	{
		convertedCountyVal = 'GY';
	}
	else if('Kildare' == countyVal)
	{
		convertedCountyVal = 'KE';
	}
	else if('Kilkenny' == countyVal)
	{
		convertedCountyVal = 'KK';
	}
	else if('Kerry' == countyVal)
	{
		convertedCountyVal = 'KY';
	}
	else if('Longford' == countyVal)
	{
		convertedCountyVal = 'LD';
	}
	else if('Leitrim' == countyVal)
	{
		convertedCountyVal = 'LM';
	}
	else if('Limerick' == countyVal)
	{
		convertedCountyVal = 'LK';
	}
	else if('Louth' == countyVal)
	{
		convertedCountyVal = 'LH';
	}
	else if('Laois' == countyVal)
	{
		convertedCountyVal = 'LS';
	}
	else if('Meath' == countyVal)
	{
		convertedCountyVal = 'MH';
	}
	else if('Mayo' == countyVal)
	{
		convertedCountyVal = 'MO';
	}
	else if('Monaghan' == countyVal)
	{
		convertedCountyVal = 'MN';
	}
	else if('Offaly' == countyVal)
	{
		convertedCountyVal = 'OY';
	}
	else if('Roscommon' == countyVal)
	{
		convertedCountyVal = 'RN';
	}
	else if('Sligo' == countyVal)
	{
		convertedCountyVal = 'SO';
	}
	else if('Tipperary' == countyVal)
	{
		convertedCountyVal = 'TY';
	}
	else if('Waterford' == countyVal)
	{
		convertedCountyVal = 'WD';
	}
	else if('Westmeath' == countyVal)
	{
		convertedCountyVal = 'WH';
	}
	else if('Wexford' == countyVal)
	{
		convertedCountyVal = 'WD';
	}
	else if('Wicklow' == countyVal)
	{
		convertedCountyVal = 'WW';
	}
	return convertedCountyVal;
}


/* function checks which county was selected */
function checkCounty()
{
	var countyVal = selectedCounty.value;
	
	// check if the county needs to be converted from code to county name
	if(countyVal.length==2)
	{
		//countyVal = convertCountyVal(countyVal);
	}
	
	if('SELECT' == countyVal || 'ALL' == countyVal)
	{
		map.setCenter(myCenter);
		map.setZoom(7);
	}
	else if('Clare' == countyVal || 'CE' == countyVal)
	{
		map.setCenter(clareCenter);
		map.setZoom(9);
	}
	else if('Cork' == countyVal || 'CK' == countyVal)
	{
		map.setCenter(corkCenter);
		map.setZoom(9);	
	}
	else if('Cavan' == countyVal || 'CN' == countyVal)
	{
		map.setCenter(cavanCenter);
		map.setZoom(9);	
	}
	else if('Carlow' == countyVal || 'CW' == countyVal)
	{
		map.setCenter(carlowCenter);
		map.setZoom(9);	
	}
	else if('Donegal' == countyVal || 'DL' == countyVal)
	{
		map.setCenter(donegalCenter);
		map.setZoom(9);	
	}
	else if('Dublin' == countyVal || 'DN' == countyVal)
	{
		map.setCenter(dublinCenter);
		map.setZoom(9);	
	}
	else if('Galway' == countyVal || 'GY' == countyVal)
	{
		map.setCenter(galwayCenter);
		map.setZoom(9);	
	}
	else if('Kildare' == countyVal || 'KE' == countyVal)
	{
		map.setCenter(kildareCenter);
		map.setZoom(9);	
	}
	else if('Kilkenny' == countyVal || 'KK' == countyVal)
	{
		map.setCenter(kilkennyCenter);
		map.setZoom(9);	
	}
	else if('Kerry' == countyVal || 'KY' == countyVal)
	{
		map.setCenter(kerryCenter);
		map.setZoom(9);	
	}
	else if('Longford' == countyVal || 'LD' == countyVal)
	{
		map.setCenter(longfordCenter);
		map.setZoom(9);	
	}
	else if('Louth' == countyVal || 'LH' == countyVal)
	{
		map.setCenter(louthCenter);
		map.setZoom(9);	
	}
	else if('Limerick' == countyVal || 'LK' == countyVal)
	{
		map.setCenter(limerickCenter);
		map.setZoom(9);	
	}
	else if('Leitrim' == countyVal || 'LM' == countyVal)
	{
		map.setCenter(leitrimCenter);
		map.setZoom(9);	
	}
	else if('Laois' == countyVal || 'LS' == countyVal)
	{
		map.setCenter(laoisCenter);
		map.setZoom(9);	
	}
	else if('Meath' == countyVal || 'MH' == countyVal)
	{
		map.setCenter(meathCenter);
		map.setZoom(9);	
	}
	else if('Monaghan' == countyVal || 'MN' == countyVal)
	{
		map.setCenter(monaghanCenter);
		map.setZoom(9);	
	}
	else if('Mayo' == countyVal || 'MO' == countyVal)
	{
		map.setCenter(mayoCenter);
		map.setZoom(9);	
	}
	else if('Offaly' == countyVal || 'OY' == countyVal)
	{
		map.setCenter(offalyCenter);
		map.setZoom(9);	
	}
	else if('Roscommon' == countyVal || 'RN' == countyVal)
	{
		map.setCenter(roscommonCenter);
		map.setZoom(9);	
	}
	else if('Sligo' == countyVal || 'SO' == countyVal)
	{
		map.setCenter(sligoCenter);
		map.setZoom(9);	
	}
	else if('Tipperary' == countyVal || 'TY' == countyVal)
	{
		map.setCenter(tipperaryCenter);
		map.setZoom(9);	
	}
	else if('Waterford' == countyVal || 'WD' == countyVal)
	{
		map.setCenter(waterfordCenter);
		map.setZoom(9);	
	}
	else if('Westmeath' == countyVal || 'WH' == countyVal)
	{
		map.setCenter(westmeathCenter);
		map.setZoom(9);	
	}
	else if('Wicklow' == countyVal || 'WW' == countyVal)
	{
		map.setCenter(wicklowCenter);
		map.setZoom(9);	
	}
	else if('Wexford' == countyVal || 'WX' == countyVal)
	{
		map.setCenter(wexfordCenter);
		map.setZoom(9);	
	}

	// hide instructions div if it exists in the DOM
	var clickInstructions = document.getElementById('clickInstructions');
	if (typeof(clickInstructions) != 'undefined' && clickInstructions != null)
	{
		clickInstructions.style.display = 'block';
	}
	
}
