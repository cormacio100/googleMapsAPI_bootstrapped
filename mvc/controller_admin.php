<?php

/*******************************************************************************
 * Controller functions specifically for the Map section of the site
 */
 
 /**
 * Admin page checks if user is logged in
 * If not they are prompted to log in 
 * If yes then they can access other admin options
 */
function admin()
{
    # clear the user session by default upon reaching this page
    clearUserSession();

    header('Location: ./adminLogin');
    exit;
}

/**
 * Function displays a login form for user to access the admin section
 */
function adminLogin()
{
	global $twig;  
	$navTop = true;  
	$navBottomAdmin=true;

	# check if the user is already authenticated.
	# If so display the list of faults instead of the login screen
	/*if(isset($_SESSION['isLoggedIn']))
	{
		header('Location: ./adminSelectRegion');
		exit;
	}*/

    clearUserSession();


	# otherwise the user is presented with the login form
	$args_array=array(
		'navTop' => $navTop,
		'navBottomAdmin' => $navBottomAdmin,
	);
	
	$template='adminLogin';
	echo $twig->render($template.'.html.twig',$args_array);
}

/**
 * Function authenticates an admin user against the database when they try to gain access
 * 
 * @param - $_POST - values from login form
 */
function adminAuthenticate()
{
	$validUserArr=array();
	
	# check the submit button was pressed
	if(isset($_POST['login']))
	{
		# retrieve fieldEngineer details
		if(isset($_POST['adminUserName']))
		{
			$adminUserName=filter_input(INPUT_POST,'adminUserName',FILTER_SANITIZE_STRING);
		}
		
		if(isset($_POST['adminPassword']))
		{
			$adminPassword=filter_input(INPUT_POST,'adminPassword',FILTER_SANITIZE_STRING);
		}	
		
		$adminPasswordEncrypted=md5($adminPassword);
		
		# send username and password for validation against the database
		$validUserArr=isValid($adminUserName,$adminPasswordEncrypted);
	
		# if valid then the user is forwarded to the reported Faults paged
		if($validUserArr)
		{
			$_SESSION['adminUserName']=$validUserArr['firstName'].' '.$validUserArr['lastName'];
			$_SESSION['isLoggedIn'] = 'yes';
			
			header('Location: ./adminSelectRegion');
			exit;
		}
		else
		{
			# if invalid username/password display that they were invalid
			header('Location: ./messageAlert?messageId=7&forwardTo=adminLogin');
			exit;
		}
	}
	else 
	{
		# if form button was not pressed then display page not found
		header('Location: ./messageAlert?messageId=1');
		exit;
	}
}

/**
 * Function checks that user is logged in and the allows them to search by region
 */
function adminSelectRegion()
{
	global $twig; global $username; 
	$navTop = true;  
	$navBottomAdmin=true;
	$regionSelected=null;
	$adminUserName=null;
	$teamRegion='ALL';
	$admin=true;
	$adminSelectRegion=true;
	
	# check if the user is already authenticated.
	if(!isset($_SESSION['isLoggedIn']))
	{
		header('Location: ./messageAlert?messageId=14&forwardTo=adminLogin');
		exit;
	}
	else 
	{
		# retrieve the username
		if(!isset($_SESSION['adminUserName']))
		{
			header('Location: ./messageAlert?messageId=14&forwardTo=adminLogin');
			exit;
		}
		else
		{

			$isLoggedIn=$_SESSION['isLoggedIn'];
			
			$adminUserName=$_SESSION['adminUserName'];
			
			# check if the team region has been set. If not then it must be set. If yes then find what region it is 
			if(!isset($_SESSION['teamRegion']))
			{
				$_SESSION['teamRegion']='ALL';
			}
			else 
			{
				$teamRegion=$_SESSION['teamRegion'];
			}
		}
	}

	# check if region is already selected. If it is then it needs to be cleared
	if(isset($_SESSION['regionSelected']))
	{
		UNSET($_SESSION['regionSelected']);
	}

	# otherwise the user is presented with the login form
	$args_array=array(
		'navTop' => $navTop,
		'navBottomAdmin' => $navBottomAdmin,
		'regionSelected' => $regionSelected,
		'adminUserName' => $adminUserName,
		'admin' => $admin,
		'adminSelectRegion' => $adminSelectRegion,
		'isLoggedIn' => $isLoggedIn,
		'adminUserName' => $adminUserName,
		'teamRegion' => $teamRegion,
	);
	
	$template='adminSelectRegion';
	echo $twig->render($template.'.html.twig',$args_array);
}

/**
 * Function determines what region the user selected and forwards the user to the faults page
 */
function adminRegionSelected()
{
	$teamRegion='ALL';	
		
	# check the button was pressed
	if(isset($_POST['select']))
	{
		if(isset($_POST['teamRegion']))
		{
			$teamRegion=filter_input(INPUT_POST,'teamRegion',FILTER_SANITIZE_STRING);
			
			# Set the teamRegion session variable and forward to right page
			$_SESSION['teamRegion']=$teamRegion;
		
			header('Location: ./adminReportedFaults');
		}
		else 
		{
			header('Location: ./messageAlert?messageId=3&forwardTo=adminSelectRegion');
			exit;
		}
	}
	else 
	{
		header('Location: ./messageAlert?messageId=3&forwardTo=adminSelectRegion');
		exit;
	}
	
}

/**
 * Function logs the admin user out. SESSION variables are cleared. User is sent back to login page
 */
function adminLogout()
{	
	# check that the user is logged in 
	# if not they get sent back to login screen as access is unauthorised to this function
	if(!isset($_SESSION['isLoggedIn']))
	{
		header('Location: ./messageAlert?messageId=14&forwardTo=adminLogin');	
		exit;
	}
	
	# if the user is logged in the SESSION variables get cleared and user is forwarded with a logout message
	//unset($_SESSION['adminUserName']);
	//unset($_SESSION['teamRegion']);
	//unset($_SESSION['isLoggedIn']);

    clearUserSession();

	header('Location: ./messageAlert?messageId=13&forwardTo=adminLogin');
}

/**
 * Function clears the admin userSession
 */
function clearUserSession()
{
    # if the user is logged in the SESSION variables get cleared and user is forwarded with a logout message
    unset($_SESSION['adminUserName']);
    unset($_SESSION['teamRegion']);
    unset($_SESSION['isLoggedIn']);
}


/**
 * Function updates the onAir status of a site as weel as the other sites on the same link as the site
 */
function adminUpdateSite()
{
	$siteId=null;
	$_clusterId=null;
	$onAir='Yes';	# default value
	$updated=null;
	
	# retrieve the other sites in the same cluster and then link
	if(isset($_POST['siteId']))
	{
		$siteId=filter_input(INPUT_POST,'siteId',FILTER_SANITIZE_NUMBER_INT);
	}  	
	
	if(isset($_POST['_clusterId']))
	{
		$_clusterId=filter_input(INPUT_POST,'_clusterId',FILTER_SANITIZE_NUMBER_INT);
	}

	if(isset($_POST['onAir']))
	{
		$onAir=filter_input(INPUT_POST,'onAir',FILTER_SANITIZE_STRING);
	}
	
	# send siteId and clusterId to first find site Id's of sites on the same link as this site that are
	# coming off this site. They all have their status updated
	$updated=updateSiteCluster($siteId,$_clusterId,$onAir);
	
	if($updated)
	{
		# if invalid username/password display that they were invalid
		header('Location: ./messageAlert?messageId=8&forwardTo=adminSites');
		exit;
	}
	else
	{
		# if invalid username/password display that they were invalid
		header('Location: ./messageAlert?messageId=9&forwardTo=adminSites');
		exit;		
	}
} 

/**
 * Funtion lists all faults that have been submitted
 */
function adminReportedFaults()
{
	global $twig; 
	//$navTop=true;
	//$navBottomAdmin=true;
	$admin=true;
	$adminReportedFaults=true;
	
	$teamRegion='ALL';
	
	$isLoggedIn=null;
	$firstName=null;
	$lastName=null;
	
	# array to hold the reported faults
	$reportedFaultsArr=array();

	# check that the user is logged in
	# if not they get sent back to login screeN
	if(!isset($_SESSION['isLoggedIn']))
	{
		header('Location: ./messageAlert?messageId=14&forwardTo=adminLogin');	
		exit;
	}
	else
	{
		$isLoggedIn=$_SESSION['isLoggedIn'];
		
		# check the username
		if(isset($_SESSION['adminUserName']))
			$adminUserName=$_SESSION['adminUserName'];
			
		# check what region the engineer is from 
		if(isset($_SESSION['teamRegion']))
		{
			$teamRegion=$_SESSION['teamRegion'];
		}
	}
	
	#((((((((((((( pager values )))))))))))))
	$startRecord=0;
	$recordsPerPage=10;
	$totalRecords=0;
    $activePage=1;      /* defaults to first page */
	$searchParam='fault';
	$url='./adminReportedFaults';
	$outputHTML=null;

    # check which page is selected in order to display the active page
    if(isset($_GET['pageNum']))
    {
        $activePage=filter_input(INPUT_GET,'pageNum',FILTER_SANITIZE_NUMBER_INT);
    }

	# count how many records are set
	$totalRecords=getTotalRecordsNum($searchParam,null,$teamRegion);
	
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
	}

	# retrieve an array or reported faults/sites
	$reportedFaultsArr = getPageRecords($searchParam,$startRecord,$recordsPerPage,null,$teamRegion);

	$args_array=array(
		'adminUserName' => $adminUserName,
		'isLoggedIn' => $isLoggedIn,
		//'navTop' => $navTop,
		//'navBottomAdmin' => $navBottomAdmin,
		'reportedFaultsArr' => $reportedFaultsArr,
		'teamRegion' => $teamRegion,
		'totalRecords' => $totalRecords,
		'outputHTML' => $outputHTML,
		'admin' => $admin,
		'adminReportedFaults' => $adminReportedFaults,
	);
	
	$template='adminReportedFaults';
	echo $twig->render($template.'.html.twig',$args_array);
}

/**
 * Funtion displays all sites and allows the admin to turn them on and off 
 * 
 * Function utilises the Pager class to page results
 */
function adminSites()
{
	global $twig; 
	$navTop=true;           //
	$navBottomAdmin=true;   //
	$admin=true;
	$adminSites=true;
	
	$isLoggedIn=null;
	$adminUserName=null;
	$teamRegion=null;
	
	# check that the user is logged in
	# if not they get sent back to login screem
	if(!isset($_SESSION['isLoggedIn']))
	{
		header('Location: ./messageAlert?messageId=14&forwardTo=adminLogin');	
		exit;
	}
	else
	{
		$isLoggedIn=$_SESSION['isLoggedIn'];
		
		# check the username
		if(isset($_SESSION['adminUserName']))
			$adminUserName=$_SESSION['adminUserName'];
			
		# check what region the engineer is from 
		if(isset($_SESSION['teamRegion']))
		{
			$teamRegion=$_SESSION['teamRegion'];
		}
	}

	# array to hold the reported faults
	$sitesArr=array();
	$selectCounty='ALL';
	
	# check if a county was selected to refine search
	if(isset($_GET['selectCounty']))
	{
		$selectCounty=filter_input(INPUT_GET,'selectCounty',FILTER_SANITIZE_STRING);
	}

	##################################################
	# include Pager class to generate pages
	# need to first initialise values
	##################################################
	$startRecord=0;
	$recordsPerPage=10;
	$totalRecords=0;
	$activePage=1;      /* defaults to first page */
	$searchParam='site';
	$url='./adminSites';
	$outputHTML=null;

    # check which page is selected in order to display the active page
    if(isset($_GET['pageNum']))
    {
        $activePage=filter_input(INPUT_GET,'pageNum',FILTER_SANITIZE_NUMBER_INT);
    }

	# count how many records are set
	$totalRecords=getTotalRecordsNum($searchParam,$selectCounty,$teamRegion);

	# create a Pager Object for creating the links at the top of the page
	$pager = new Pager($totalRecords,$recordsPerPage,$searchParam,$url,$selectCounty,$activePage);
	
	$outputHTML=$pager->getOutputHTML();
	
	# check the GET superpGlobal to see if startRecord and recordsPerPage values have been passed
	if(isset($_GET['startRecord']))
	{
		$startRecord=filter_input(INPUT_GET,'startRecord',FILTER_SANITIZE_NUMBER_INT);
	}
	
	if(isset($_GET['recordsPerPage']))
	{
		$recordsPerPage=filter_input(INPUT_GET,'recordsPerPage',FILTER_SANITIZE_NUMBER_INT);
	}

	# retrieve an array or reported faults
	$sitesArr=getPageRecords($searchParam,$startRecord,$recordsPerPage,$selectCounty,$teamRegion);

	$args_array=array(
		'adminUserName' => $adminUserName,
		'isLoggedIn' => $isLoggedIn,
		'navTop' => $navTop, 
		'navBottomAdmin' => $navBottomAdmin,
		'sitesArr' => $sitesArr,
		'selectCounty' => $selectCounty,
		'totalRecords' => $totalRecords,
		'outputHTML' => $outputHTML,
		'admin' => $admin,
		'adminSites' => $adminSites,
		'teamRegion' => $teamRegion,
	);
	
	$template='adminSites';
	echo $twig->render($template.'.html.twig',$args_array);
}


/**
 * Function retrieves entries made by admin user and allows for updates and status changes to be made to the db
 * 
 * @param - $_GET
 */
function adminUpdateFault()
{
	global $twig; 
	$navTop=true;
	$navBottomAdmin=true;
	$adminFaultStatusMenu=true;
	$admin=true;
	$adminUpdateBtn=true;
	$isLoggedIn=null;
	$adminUserName=null;
	$teamRegion=null;
    $adminReportedFaults=true;

	# check if the user is logged in
	if(isset($_SESSION['isLoggedIn']))
	{
		$isLoggedIn=$_SESSION['isLoggedIn'];
	}
	if(isset($_SESSION['adminUserName']))
	{
		$adminUserName=$_SESSION['adminUserName'];
	}
	if(isset($_SESSION['teamRegion']))
	{
		$teamRegion=$_SESSION['teamRegion'];
	}
	$args_array=array(
		'adminUserName' => $adminUserName,
		'admin' => $admin,
		'isLoggedIn' => $isLoggedIn,
		'teamRegion' => $teamRegion,
	);
	
	$faultArr=array();
	$faultId=0;
	
	if(isset($_SESSION['isLoggedIn']))
	{
		if(isset($_GET['faultId']))
		{
			$faultId=filter_input(INPUT_GET,'faultId',FILTER_SANITIZE_NUMBER_INT);
			
			# retrieve the details for the submitted fault
			$faultReport=getFaultReport($faultId);
			
			# spilt the array into variables that can be used in the template
			$args_array['faultId'] = $faultReport['faultId'];
			$args_array['faultCounty'] = $faultReport['faultCounty'];
			
				# check for any special chars &#39; in Address which signifies an apostrophe
				$formattedAddress = str_replace("&#39;","'",$faultReport['faultAddress']);
			$args_array['faultAddress'] = $formattedAddress; 
			
	 		$args_array['faultType'] = $faultReport['faultType'];
	 		$args_array['faultFrequency'] = $faultReport['faultFrequency'];
			$args_array['faultMsisdn']= $faultReport['faultMsisdn'];
			
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
			
			$class='class="readOnly"';
			$args_array['class']=$class;
			
			$readOnly='readonly';
			$args_array['readonly']=$readOnly;

			# for menu bar
			$args_array['navTop']=$navTop;
			$args_array['navBottomAdmin']= $navBottomAdmin;
						
			# add the form action to the args_array
			$args_array['formAction']='./adminUpdateReportFault';
			
			# add the status menu and update button
			$args_array['adminFaultStatusMenu']=$adminFaultStatusMenu;
			$args_array['updateButton']=$adminUpdateBtn;
			
			#   to show active link
			$args_array['adminReportedFaults'] = $adminReportedFaults;

			$template='mapReportFaultForm2';
			echo $twig->render($template.'.html.twig',$args_array);
		}
		else
		{
			# if invalid faultId display that it was invalid
			header('Location: ./messageAlert?messageId=10&forwardTo=adminReportedFaults');
			exit;			
		}
	}
	else
	{
					
		# if invalid fault details display that they were invalid
		header('Location: ./messageAlert?messageId=10&forwardTo=adminReportedFaults');
		exit;
	}
}

/**
 * Function allows admin users to update reported faults
 */
function adminUpdateReportFault()
{
	$updated=null;
	$faultId=null;
	$faultStatus=null;	
	
	# check user is logged in
	if(isset($_SESSION['isLoggedIn']))
	{
		# retrieve values from POST
		# only need faultId, faultStatus, faultUpdate
		if(isset($_POST['faultId']))
		{
			$faultId=filter_input(INPUT_POST,'faultId',FILTER_SANITIZE_NUMBER_INT);
		}
		if(isset($_POST['faultStatus']))
		{
			$faultStatus=filter_input(INPUT_POST,'faultStatus',FILTER_SANITIZE_STRING);
		}
		if(isset($_POST['faultUpdate']))
		{
			$faultUpdate=filter_input(INPUT_POST,'faultUpdate',FILTER_SANITIZE_STRING);
		}
		
		# submit the variables to update the database
		$updated=updateFaultReport($faultId,$faultStatus,$faultUpdate);
		
		# check if the update was a success
		if($updated)
		{
			# if invalid fault details display that they were invalid
			header('Location: ./messageAlert?messageId=12&forwardTo=adminReportedFaults');
			exit;
		}
		else 
		{
			# if invalid fault details display that they were invalid
			header('Location: ./messageAlert?messageId=9&forwardTo=adminReportedFaults');
			exit;
		}
	}
	else 
	{
			# if invalid faultId display that it was invalid
			header('Location: ./messageAlert?messageId=11&forwardTo=adminLogin');
			exit;		
	}
}

/**
 * Function used to update user passwords. No Access to this from Front-End
 */
 function adminUpdateUserPassword()
 {
 	# retrieve username passed in from GET Superglobal
 	if(isset($_GET['userName']))
	{
		$userName=filter_input(INPUT_GET,'userName',FILTER_SANITIZE_STRING);
	}
	
	# submit update and check if was success
 	$success=updatePassWord($userName);
	
	echo 'Successful='.$success;
 }


