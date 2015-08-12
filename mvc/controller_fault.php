<?php

/***********************************************************************************
 * Controller functions specifically for the Fault Reporting section of the site
 */
 
# start or resume a session
if(!isset($_SESSION))
{
    session_start();
	ob_start();
}
 
 /**
  * Function is reposponsible for checking the email address entered in 
  * 
  * If NO fault reports were fond for that email addres then the user is forwarded to the form to report a fault
  * 
  * If faults WERE found then user is forwarded to the 
  */
 function reportFaultEmailCheck() 
 {
 	# need to to make the email address globally accessible
	$faultReportEmail=null;
	
	$faultReportArr=array();	# array off faults
	
	# variable to allow user access to page 
	$allowed=false;	
	
	# user can access this page in two ways. By POST or by SESSION
	# check if register button was pressed

	# check if register button was pressed
	if(isset($_POST['faultReportRegister']))
	{
		# check if email address was entered
		if(isset($_POST['faultReportEmail']))
		{
			# Sanitise the email address
			# FILTER_SANITIZE_STRING does not check for valid email addresses on it's own. It just removes unusal chars
			# Need to use it in conjunction with FILTER_VALIDATE_EMAIL
			$faultReportEmail=filter_input(INPUT_POST,'faultReportEmail',FILTER_SANITIZE_EMAIL);	

			if(filter_var($faultReportEmail, FILTER_VALIDATE_EMAIL)) 
			{
				# add the email address to the SESSION superglobal array
				$_SESSION['faultReportEmail']=$faultReportEmail;

				# check DB to see if previous faultId's exists against this email address. Only faultId's
				$faultReportArr=checkForFaultReports($faultReportEmail);
				
				if(empty($faultReportArr))
				{
					# if no results found display the form for reporting a fault	
					header('Location: ./mapReportFault?formId=2');
					exit;
				}
				else 
				{
					# if results found for previously reported faults by this email address then display the faults
					header('Location: ./mapReportFault?formId=3');
					exit;
				}
			}
			
			else 
			{
				# display that email address was invalid
				header('Location: ./messageAlert?messageId=4&forwardTo=mapReportFault');
				exit;
			}
		}
		else 
		{
			# if email address was not entered then it is an un-authorised access attempt.
			# error message will be displayed
			header('Location: ./messageAlert?messageId=4&forwardTo=mapReportFault');
			exit;
		}
		
	}
	else 
	{
		# if button was not pressed then there is an un-authorised access attempt.
		# error message will be displayed
		header('Location: ./messageAlert?messageId=14&forwardTo=mapReportFault');
		exit;
	}
	
 }

/**
 * Function displays form for user to report network faults
 */
 function mapReportFault() 
 {

    # clear the admin user session by default upon reaching this page
    clearUserSession();

 	global $twig; 
	
	//$navTop=true;
	//$navBottomMap=true;
	$faultStatusMenu=true;
	
	$isLoggedIn=null;
	$firstName=null;
	$lastName=null;
	
	# default values
	$formId=1;
	$template=null;
	$action=null;
	
	# fault values to be updated 
	$faultId=null;
	$faultReportEmail=null;
 	$faultAddress=null;
 	$faultType=null;
 	$faultFrequency=null;
 	$faultDateFrom=null;
 	$faultDateTo=null;
 	$faultLatitude=null;
 	$faultLongitude=null;
 	$faultDescription=null;
 	$faultStatus='open';		# default value when reporting a fault
 	$faultUpdate=null;
	$faultReportArr=array();

	# default HTML for the submit button
	//$button='<input type="submit" id="submitFaultReport" name="submitFaultReport" value="submit" class="btn">';
		
	# default class in the form
	$class='class="faultForm"';
	$classAdmin='class="readOnly"';
		
	# argument array for template
	//$args_array=array(
	//	'navTop' => $navTop,
	//	'navBottomMap' => $navBottomMap,
	//);

	# template to display is determined by formId passed in
	# check what form ID was passed in 
	# if no results are found then form ID is passed in the $_GET super global
	if(isset($_GET['formId']))
	{	
		# sanitize the value
		$formId=filter_input(INPUT_GET,'formId',FILTER_SANITIZE_NUMBER_INT);
		
		# change this to SESSION
		if(isset($_SESSION['faultReportEmail']))
		{
			$faultReportEmail=$_SESSION['faultReportEmail'];	
		}
		else 
		{
			# if the passed email address is not valid then display error
			header('Location: ./messageAlert?messageId=4&forwardTo=mapReportFault');
			exit;
		}
	}
	
	# form template displayed is dependent on which formId is passed in to function
	if(1==$formId)
	{
		# housekeeping - clear the session variable for previous fault reports
		unset($_SESSION);

		$template='mapReportFaultForm1';
	}
	else if('2'==$formId)
	{
		$action=null;
		
		# Check if the there is a REQUEST TO REVIEW AN EXISTING FAULT REPORT or to create a new one
		# If viewing an existing report the fields will be READONLY 
		if(isset($_GET['action']))
		{
			$action=filter_input(INPUT_GET,'action', FILTER_SANITIZE_STRING);
			
			# if variable action is set to review then the fields should be made readonly as yu don't want the user to change data at this point
			if('review'==$action)
			{
				if(isset($_GET['faultId']))
				{
					$faultId=filter_input(INPUT_GET,'faultId', FILTER_SANITIZE_NUMBER_INT);
				}
				
				# retrieve details of Fault Report
				$faultReport=getFaultReport($faultId);
				
				# for review page we don't want the user to make changes so everything is readonly
				$readOnly='readonly';
				$disabled='disabled';
				
				# there will be not submit button
				$button=null;
				
				# change the class to readOnly
				$class='class="readOnly"';
				
				# if a fault report is found then populate the argument array with details
				if($faultReport)
				{
									
					# add the link to the args array
					$args_array['faultId'] = $faultReport['faultId'];
					$args_array['faultCounty'] = $faultReport['faultCounty'];
					
						# check for any special chars &#39; in Address which signifies an apostrophe
						$formattedAddress = str_replace("&#39;","'",$faultReport['faultAddress']);
					$args_array['faultAddress'] = $formattedAddress; 
					
					$args_array['faultMsisdn'] = $faultReport['faultMsisdn'];
			 		$args_array['faultType'] = $faultReport['faultType'];
			 		$args_array['faultFrequency'] = $faultReport['faultFrequency'];
					
						# format the date so that it can be read by form
						$date_format = 'Y-m-d';
						$dateTimeObject = new DateTime($faultReport['faultDateFrom']);
						$formatted_date_string = $dateTimeObject->format($date_format);
					$args_array['faultDateFrom'] = $formatted_date_string;
					
			 		$args_array['faultLatitude'] = $faultReport['faultLatitude'];
			 		$args_array['faultLongitude'] = $faultReport['faultLongitude'];
					
						# check for any special chars &#39; in Description which signifies an apostrophe
						$formattedDescription = str_replace("&#39;","'",$faultReport['faultDescription']);
			 		$args_array['faultDescription'] = $formattedDescription; 
			 		
			 		$args_array['faultStatus'] = $faultReport['faultStatus'];
					
						# check for any special chars &#39; in Description which signifies an apostrophe
						$formattedUpdate = str_replace("&#39;","'",$faultReport['faultUpdate']);
			 		$args_array['faultUpdate'] = $formattedUpdate;
	
					$args_array['readonly']=$readOnly;
                    $args_array['readonly2']=$readOnly;
					$args_array['faultStatusMenu']=$faultStatusMenu;
					$args_array['disabled']=$disabled;
					$args_array['classAdmin']=$classAdmin;

                    # display in breadcrumb
                    $args_array['pageBreadCrumb']='Previously Reported Service Fault';
				}
			}
			else
			{
				# if the passed action is not valid then display error
				header('Location: ./messageAlert?messageId=3&loc=1');
				exit;
			}
		} 
		else
		{
			# if a new fault report is being entered then you need to give it a default status
			$args_array['faultStatus'] = 'open';
			
			# need to tell the form that report is just for review. No submission or update is necessary
			$args_array['forSubmission']=true;

			# display in breadcrumb
			$args_array['pageBreadCrumb']='New Service Fault';
		}
		
		# create a link that will return the user back to the listing page
		$link=true;	
						
		# add the link to the args array
		$args_array['link'] = $link;
		
		# add email address to hidden field
		$args_array['faultReportEmail']=$faultReportEmail;
		
		# admin sections should be readOnly for normal user
		$args_array['classAdmin']=$classAdmin;
		
		# add the form action to the args_array
		$args_array['formAction']='./createReportFault';
		
		# add the status menu
		$args_array['faultStatusMenu']=$faultStatusMenu;

		$template='mapReportFaultForm2';
	}
	else if('3'==$formId)
	{
		$faultReportArr=null;

		#((((((((((( Pager Values )))))))))))
		/*$startRecord=0;
		$recordsPerPage=5;
		$totalRecords=0;
        $activePage=1;
        $searchParam='fault';
		$url='./mapReportFault&formId=3';
		$outputHTML=null;

        # check which page is selected in order to display the active page
        if(isset($_GET['pageNum']))
        {
            $activePage=filter_input(INPUT_GET,'pageNum',FILTER_SANITIZE_NUMBER_INT);
        }

        # count how many records are set
        $totalRecords=getTotalRecordsNum($searchParam,$faultReportEmail,null);

       //echo 'totalRecords is '.$totalRecords;exit;

        # create a Pager Object for creating the links at the top of the page
        $pager = new Pager($totalRecords,$recordsPerPage,$searchParam,$url,'ALL',$activePage);

        $outputHTML	 = $pager->getOutputHTML();

        # check the GET super global to see if startRecord & recordsPerPage have been passed in
        if(isset($_GET['startRecord']))
        {
            $startRecord = filter_input(INPUT_GET,'startRecord',FILTER_SANITIZE_NUMBER_INT);
        }
        if(isset($_GET['recordsPerPage']))
        {
            $recordsPerPage = filter_input(INPUT_GET,'recordsPerPage',FILTER_SANITIZE_NUMBER_INT);
        }*/

		# check DB to see if previous faultId's exists against this email address. Only faultId's
		$faultReportArr=checkForFaultReports($faultReportEmail);

        //$faultReportArr = getPageRecords($searchParam,$startRecord,$recordsPerPage,$faultReportEmail,null);


        if(sizeof($faultReportArr)>5)
        {
            for($i=0;$i<5;$i++)
            {
                $faultReportArrFirstFive[]=$faultReportArr[$i];
            }
        }
        else
        {
            $faultReportArrFirstFive=$faultReportArr;
        }


        # add the array to the arguments array to be used in the template
		$args_array['faultRerportEmail']=$faultReportEmail;
		$args_array['faultReportArr']=$faultReportArr;
        $args_array['faultReportArrFirstFive']=$faultReportArrFirstFive;
		//$args_array['outputHTML']=$outputHTML;
		# add email address to hidden field
		$args_array['faultReportEmail']=$faultReportEmail;
		
		$template='mapReportFaultForm3';
	}
	
	# add the class to the argument array for the form elements
	$args_array['class']=$class;
	
	echo $twig->render($template.'.html.twig',$args_array);
 }
 
 
 /**
  * Function receives values submitted in Fault Report form and saves them to the database
  */
  function createReportFault()
  {
	# form variables
	$faultCounty=null;
	$faultAddress=null;
	$faultMsisdn=null;
	$faultType=null;
	$faultFrequency=null;
	$faultDateFrom=null;
	
		# format the date to be YYYY-MM-DD h:i:s
		$date_format='Y-m-d H:i:s';
		$dateTimeObject = new DateTime($faultDateFrom);
		
		$faultDateFrom= $dateTimeObject->format($date_format);

	$faultDateTo=null;
	$faultLatitiude=null;
	$faultLongitude=null;
	$faultDescription=null;
	$faultStatus=null;
	$faultUpdate=null;
	$faultReportEmail=null;
	
	# check variables
	$validMsisdn=false;
	$faultReportArr=array();
	$faultReportCreated=false; # has the fault report been created
	$newFaultReportId=null;
	
	# check that the button was pressed to report the fault
	if(isset($_POST['submitFaultReport']))
	{

		if(isset($_POST['faultCounty']))
		{
			$faultCounty=filter_input(INPUT_POST,'faultCounty',FILTER_SANITIZE_STRING);
		}
		if(isset($_POST['faultAddress']))
		{
			$faultAddress=filter_input(INPUT_POST,'faultAddress',FILTER_SANITIZE_STRING);
		}
		# MSISDN is a mandatory field and must be in 353 format. This is check on the front end in Chrome
		if(isset($_POST['faultMsisdn']))
		{
			$faultMsisdn=filter_input(INPUT_POST,'faultMsisdn',FILTER_SANITIZE_NUMBER_INT);
			
			# convert the msisdn to a STRING value
			$faultMsisdnStr=strval($faultMsisdn);

			# check that the length of a string matches a proper mobile number for Ireland
			# 3538xxxxxxxx = 12 characters in length
			$faultMsisdnStrLen=strlen($faultMsisdnStr);

			# check MSISDN is long enough
			if(12==$faultMsisdnStrLen)
			{
				# check that the string starts in 353
				if(0==strPos($faultMsisdnStr,'3538'))
				{
					# convert string back to a  float value
					$faultMsisdn=(float)$faultMsisdnStr;
				}
			}
			else 
			{
				# if invalid MSISDN entered error message will be displayed
				header('Location: ./messageAlert?messageId=6&forwardTo=mapReportFault');
				exit;
			}
		}		
		if(isset($_POST['faultType']))
		{
			$faultType=filter_input(INPUT_POST,'faultType',FILTER_SANITIZE_STRING);
		}
		if(isset($_POST['faultFrequency']))
		{
			$faultFrequency=filter_input(INPUT_POST,'faultFrequency',FILTER_SANITIZE_STRING);
		}
		if(isset($_POST['faultDateFrom']))
		{
			$faultDateFrom=filter_input(INPUT_POST,'faultDateFrom',FILTER_SANITIZE_STRING);
		}
		if(isset($_POST['faultDateTo']))
		{
			$faultDateTo=filter_input(INPUT_POST,'faultDateTo',FILTER_SANITIZE_STRING);
		}
		if(isset($_POST['faultLatitude']))
		{
			$faultLatitude=filter_input(INPUT_POST,'faultLatitude',FILTER_SANITIZE_STRING);
		}
		if(isset($_POST['faultLongitude']))
		{
			$faultLongitude=filter_input(INPUT_POST,'faultLongitude',FILTER_SANITIZE_STRING);
		}
		if(isset($_POST['faultDescription']))
		{
			$faultDescription=filter_input(INPUT_POST,'faultDescription',FILTER_SANITIZE_STRING);
		}
		if(isset($_POST['faultStatus']))
		{
			$faultStatus=filter_input(INPUT_POST,'faultStatus',FILTER_SANITIZE_STRING);
		}
		if(isset($_POST['faultUpdate']))
		{
			$faultUpdate=filter_input(INPUT_POST,'faultUpdate',FILTER_SANITIZE_STRING);
		}	
		if(isset($_POST['faultReportEmail']))
		{
			$faultReportEmail=filter_input(INPUT_POST,'faultReportEmail',FILTER_SANITIZE_STRING);
		}	
		
		$faultReportArr=createFaultReport($faultCounty,$faultAddress,$faultMsisdn,$faultType,$faultFrequency,$faultDateFrom,$faultDateTo,$faultLatitude,$faultLongitude,$faultDescription,$faultStatus,$faultUpdate,$faultReportEmail);

		if(isset($faultReportArr['inserted']))
		{
			$faultReportCreated=$faultReportArr['inserted'];
			$newFaultReportId=$faultReportArr['newFaultReportId'];
		}

		if($faultReportCreated)
		{	
			# if form not submitted properly display error message
			header('Location: ./messageAlert?messageId=5&forwardTo=mapReportFault&formId=3&newFaultReportId='.$newFaultReportId);
			exit;
		}
		else 
		{			
			# if form not submitted properly display error message
			header('Location: ./messageAlert?messageId=9&forwardTo=mapReportFault&formId=3');
			exit;	
		}
	}
	else
	{
		# if form not submitted properly display error message
		header('Location: ./messageAlert?messageId=3&forwardTo=reportFault&loc=1');
		exit;
	}
	
	# try to retrieve submitted values

  }
 
 
 /**
  * Function retrieves an array of fault Objects and returns
  * so that markers can be created on Map for the location of the fault 
  */
/* function findFaultsByEmailForMapMarkers()
 {
 	# array to hold the faultObjects
 	$faultArr=array();
	$faultObjArr=array();	# array of fault objects
	$faultReportEmail=null;
	$faultArrLen=null;

	if(isset($_GET['pageSource']))
	{
		$pageSource=filter_input(INPUT_GET, 'pageSource',FILTER_SANITIZE_STRING);
		
		if('googleMap1'==$pageSource)
		{
			$faultReportEmail='ALL';	
		}
	}
	else 
	{
		if(isset($_SESSION['faultReportEmail']))	
		{
			$faultReportEmail=$_SESSION['faultReportEmail'];
		}
		else 
		{
			$faultReportEmail='ALL';	
		}
	}

	# retrieve array of faults containing id, latitude and longitude
	$faultArr=retrieveFaultLocationsByEmail($faultReportEmail,'markers');
		
	$faultArrLen=sizeof($faultArr);

	# loop through array and create a Fault Object for each fault
	for($i=0;$i<$faultArrLen;$i++)
	{
		$fault=new ReportedFault(
			$faultArr[$i]['faultId'],
			$faultArr[$i]['faultMsisdn'],
			$faultArr[$i]['faultType'],
			$faultArr[$i]['faultLatitude'],
			$faultArr[$i]['faultLongitude']
		);
		
		# add the fault Object to an array
		$faultObjArr[]=$fault;
	}
	
	# convert data to JSON
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: 0");
	header('Content-Type: application/json');

	# encode the array as JSON
	$jsonOutput=json_encode($faultObjArr);

	echo $jsonOutput;

 }*/

/**
 * Function retrieves an array of fault Objects and returns
 * so that markers can be created on Map for the location of the fault
 */
function findFaultsByEmailForMapMarkers()
{
    # array to hold the faultObjects
    $faultArr=array();
    $faultObjArr=array();	# array of fault objects
    $faultReportEmail=null;
    $faultArrLen=null;

    if(isset($_GET['pageSource']))
    {
        $pageSource=filter_input(INPUT_GET, 'pageSource',FILTER_SANITIZE_STRING);

        if('googleMap1'==$pageSource)
        {
            $faultReportEmail='ALL';
        }
    }
    else
    {
        if(isset($_SESSION['faultReportEmail']))
        {
            $faultReportEmail=$_SESSION['faultReportEmail'];
        }
        else
        {
            $faultReportEmail='ALL';
        }
    }

    # retrieve array of faults containing id, latitude and longitude
    $faultArr=retrieveFaultLocationsByEmail($faultReportEmail,'markers');

    $faultArrLen=sizeof($faultArr);

    # loop through array and create a Fault Object from the ReportedFault class for each fault
    for($i=0;$i<$faultArrLen;$i++)
    {
        $fault=new ReportedFault(
            $faultArr[$i]['faultId'],
            $faultArr[$i]['faultMsisdn'],
            $faultArr[$i]['faultType'],
            $faultArr[$i]['faultLatitude'],
            $faultArr[$i]['faultLongitude']
        );

        # add the fault Object to an array
        $faultObjArr[]=$fault;
    }

    # convert data to JSON
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    header('Content-Type: application/json');

    # encode the array as JSON
    $jsonOutput=json_encode($faultObjArr);

    echo $jsonOutput;

}

/**
 * Function retrieves a list of Fault ID's and converts to JSON
 * Fault IDs are then listed on mapReportFault form page 3
 */

function getFaultIdListLinkedToEmail()
{
    $searchParam=null;
    $startRecord=0;
    $recordsPerPage=5;
    $url='./getFaultIdListLinkedToEmail';
    $faultReportEmail=null;

    if(isset($_GET['faultReportEmail']))
    {
        $faultReportEmail=filter_input(INPUT_GET,'faultReportEmail',FILTER_SANITIZE_STRING);
    }

    # retrive list of fault ID's
    $faultReportArr = retrieveFaultLocationsByEmail($faultReportEmail,'idList',$startRecord,$recordsPerPage);

    # encode the Site Object Array into JSON
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    header('Content-Type: application/json');

    # encode the array as JSON
    $jsonOutput=json_encode($faultReportArr);

    echo $jsonOutput;
}