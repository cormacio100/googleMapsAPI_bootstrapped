<?php

/***********************************************************************************
 * Controller functions specifically for the Map section of the site
 */
 
 /**
 * map page
 */ 
function map()
{

    # if a user was in admin section and clicked on this option then they need to be logged out
    clearUserSession();

	# Auto forward user to the Site Finder sub page
	header('Location: ./mapReportFault');
	exit;
}

/**
 * Site Finder is a sub page of map
 * 
 * Template displays map and form to narrow down site search
 */
function mapDisplay()
{
	global $twig; 
	$navTop=true; 
	$navBottomMap=true; 
	
	$isLoggedIn=null;
	$firstName=null;
	$lastName=null;
	
	# check if the user is logged in. If so display it
	if(isset($_SESSION['isLoggedIn']))
	{
		$isLoggedIn=$_SESSION['isLoggedIn'];
	}
	if(isset($_SESSION['firstName']))
	{
		$firstName=$_SESSION['firstName'];
	}
	if(isset($_SESSION['lastName']))
	{
		$lastName=$_SESSION['lastName'];
	}
	$args_array=array(
		'username' => $firstName.' '.$lastName,
		'isLoggedIn' => $isLoggedIn,
		'navTop' => $navTop,
		'navBottomMap' => $navBottomMap,
	);
	
	$template='mapDisplay';
	echo $twig->render($template.'.html.twig',$args_array);
}

/**
 * Function retrieves details of all mobile sites stored in the database
 * It then saves each site record as a SiteObject and stores the object in an array
 * 
 * @ return JSON Outputs
 */
function mapFindMobileSites()
{
	$sitesArr=array();
	$siteObjArr=array();	# array of objects
	$selectCounty='ALL';
	
	if(isset($_GET['selectCounty']))
	{
		$selectCounty=filter_input(INPUT_GET,'selectCounty',FILTER_SANITIZE_STRING);
	}
	
	# retrieve array of sites on network
	$sitesArr=retrieveOnAirSites($selectCounty);

	# length of array
	$sitesArrLen=sizeof($sitesArr);
	
	# loop through array and create a Site Object for each arr element
	for($i=0; $i<$sitesArrLen;$i++)
	{
		$site=new Site(
			$sitesArr[$i]['siteId'],
			$sitesArr[$i]['siteName'],
			$sitesArr[$i]['county'],
			$sitesArr[$i]['latitude'],
			$sitesArr[$i]['longitude'],
			$sitesArr[$i]['onAir'],
			$sitesArr[$i]['_bsc'],
			$sitesArr[$i]['_rnc'],
			$sitesArr[$i]['dcsRating'],
			$sitesArr[$i]['gsmRating'],
			$sitesArr[$i]['usmRating'],
			$sitesArr[$i]['lteRating'],
			$sitesArr[$i]['txnRating'],
			$sitesArr[$i]['mprn'],
			$sitesArr[$i]['wentOffAir'],
			$sitesArr[$i]['backOnAir'],
			$sitesArr[$i]['_clusterId'],
			$sitesArr[$i]['_fieldEngId'],
			$sitesArr[$i]['firstName'],
			$sitesArr[$i]['lastName'],
			$sitesArr[$i]['teamRegion'],
			$sitesArr[$i]['hopsArray']);
			
		# add each site Object to an array
		$siteObjArr[]=$site;
	}
	
	# encode the Site Object Array into JSON	
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: 0");
	header('Content-Type: application/json');
	
	# encode the array as JSON
	$jsonOutput=json_encode($siteObjArr);
	
	echo $jsonOutput;
}


/**
 * Function retrieves all sites that are currentlyOff Air
 * 
 * @return JSON output
 */
function mapFindOffAirSites()
{
	$sitesOffAirArr=array();
	$sitesOffAirObjArr=array();
	
	$sitesOffAirArr=retrieveOffAirSites();
	
	# length of array
	$sitesOffAirArrLen=sizeof($sitesOffAirArr);

	# loop through array and for each arr element create a Site Object
	# Object used for more control JSON parsing
	for($i=0; $i<$sitesOffAirArrLen;$i++)
	{
		$site=new Site(
			$sitesOffAirArr[$i]['siteId'],
			$sitesOffAirArr[$i]['siteName'],
			$sitesOffAirArr[$i]['county'],
			$sitesOffAirArr[$i]['latitude'],
			$sitesOffAirArr[$i]['longitude'],
			$sitesOffAirArr[$i]['onAir'],
			$sitesOffAirArr[$i]['_bsc'],
			$sitesOffAirArr[$i]['_rnc'],
			$sitesOffAirArr[$i]['dcsRating'],
			$sitesOffAirArr[$i]['gsmRating'],
			$sitesOffAirArr[$i]['usmRating'],
			$sitesOffAirArr[$i]['lteRating'],
			$sitesOffAirArr[$i]['txnRating'],
			$sitesOffAirArr[$i]['mprn'],
			$sitesOffAirArr[$i]['wentOffAir'],
			$sitesOffAirArr[$i]['backOnAir'],
			$sitesOffAirArr[$i]['_clusterId'],
			$sitesOffAirArr[$i]['_fieldEngId'],
			$sitesOffAirArr[$i]['firstName'],
			$sitesOffAirArr[$i]['lastName'],
			$sitesOffAirArr[$i]['teamRegion'],
			$sitesOffAirArr[$i]['hopsArray']);
			
		# add each site Object to object Array 	
		$sitesOffAirObjArr[]=$site;
	}
	
	# add JSON header to output
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: 0");
	header('Content-Type: application/json');
	
	# encode the array as JSON
	$jsonOutput=json_encode($sitesOffAirObjArr);
	
	# output the JSON
	echo $jsonOutput;	
}


/**
 * Function retreives details of BSC/RNC/MSC controllers
 * 
 * @return JSON Output
 */
function mapFindControllers()
{
	$controllerArr=array();
	$controllerObjArr=array();
	$controllerArrLen=null;
	
	#####################################
	# TO DO
	#####################################
	#	LOOP THROGH ARRAY
	# 	CREATE SITE OBJECTS
	#	ADD OBJECTS TO ARRAY
	# 	CONVERT ARRAY TO JSON
	#	ECHO IT
	
	$controllerArr=retrieveControllers();
	
	# length of rnc portion of Array is needed for the loops
	$controllerRNCLen=sizeof($controllerArr['rnc']);
	# length of bsc portion of Array is needed for the loops
	$controllerBSCLen=sizeof($controllerArr['bsc']);
	
	# loop through array and for each arr element create a Controller Object
	for($i=0; $i<$controllerRNCLen;$i++)
	{
		if($controllerArr['rnc'])
		{
			$controller=new Controller($controllerArr['rnc'][$i]['rnc'],'rnc',$controllerArr['rnc'][$i]['rncLatitude'],$controllerArr['rnc'][$i]['rncLongitude'],$controllerArr['rnc'][$i]['controllerMSC']);
				# add the site Object to object Array 	
			$controllerObjArr[]=$controller;
		}
	}
	# loop through array and for each arr element create a Controller Object
	for($i=0; $i<$controllerBSCLen;$i++)
	{
		if($controllerArr['bsc'])
		{
			$controller=new Controller($controllerArr['bsc'][$i]['bsc'],'bsc',$controllerArr['bsc'][$i]['bscLatitude'],$controllerArr['bsc'][$i]['bscLongitude'],$controllerArr['bsc'][$i]['controllerMSC']);
		
			# add the BSC Object to controller object Array 	
			$controllerObjArr[]=$controller;
		}
	}

	# add JSON header to output
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: 0");
	header('Content-Type: application/json');
	
	# encode the array as JSON
	$jsonOutput=json_encode($controllerObjArr);
	
	echo $jsonOutput;
}

