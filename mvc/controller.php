<?php

//------------------------------------------
//	Controller Functions
//------------------------------------------

/**
 * Index Page
 */
function index()
{
	global $twig; 
	//$navTop=true;
	//$navBottomHome=true;
	
	$isLoggedIn=null;
	$firstName=null;
	$lastName=null;
	
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
		'isLoggedIn' => $isLoggedIn,
		'username' => $firstName.' '.$lastName,
		//'navTop' => $navTop,
		//'navBottomHome' => $navBottomHome,
	);
	
	$template='index';
	echo $twig->render($template.'.html.twig',$args_array);	
}

/**
 * Function has detected that the user has trie to access a location that does not exist so forwards to the messageAlert section
 */
 function error404()
 {
 	header('Location: ./messageAlert?messageId=1');
	exit;
 }

/**
 * Function displays messages depending on the messageId forwrded to it
 * 
 * Also, forwards user back to relevant page depending on the messageId
 */
function messageAlert()
{
	global $twig; 
	$navTop=true;
	$navBottomHome=true;
	
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
	
	$message=null;
	$messageId=null;
	$forwardTo=null;
	$forwarding=null;
	$formId=null;

	
	# check what messageId was requested
	if(isset($_GET['messageId']))
	{
		$messageId=filter_input(INPUT_GET, 'messageId', FILTER_SANITIZE_NUMBER_INT);
	}
	
	# check if there is a request to FORWARD to another page after message is displayed
	if(isset($_GET['forwardTo']))
	{
		$forwardTo=filter_input(INPUT_GET,'forwardTo',FILTER_SANITIZE_STRING);
		
		# check if a particular fault report form was requested
		if(isset($_GET['formId']))
		{
			$formId=filter_input(INPUT_GET,'formId',FILTER_SANITIZE_NUMBER_INT);
			
			# append to the forwardTo string
			$forwardTo.='&formId='.$formId;
		} 
	}
	
	if('1'==$messageId)
	{
		$message='Page Not Found';
		$forwarding='Error 404';
        $messageAlertClass='class="alert alert-danger"';
	}
	else if('2'==$messageId)
	{
		$message='You are already logged in';
	}
	else if('3'==$messageId)
	{
		$message='Invalid Search Options Entered';
        $messageAlertClass='class="alert alert-danger"';
	}
	else if('4'==$messageId)
	{
		$message='Invalid Email Address entered.';
		$forwarding='Forwarding...';
        $messageAlertClass='class="alert alert-danger"';
	}
	else if('5'==$messageId)
	{
		# check if a a Fault Report ID was pass in. If So display it
		if(isset($_GET['newFaultReportId']))
		{
			$newFaultReportId=filter_input(INPUT_GET,'newFaultReportId',FILTER_SANITIZE_NUMBER_INT);
			
			$message='Fault Report '.$newFaultReportId.' Created.';

            $messageAlertClass='class="alert alert-success"';
		}
		else 
		{
			$message='Fault Report Created.';

            $messageAlertClass='class="alert alert-success"';
		}
        $forwarding='Forwarding...';
	}
	else if('6'==$messageId)
	{
		$message='Invalid Mobile Number entered. Must be in 353 format';
        $forwarding='Forwarding...';
        $messageAlertClass='class="alert alert-danger"';
	}
	else if('7'==$messageId)
	{
		$message='Invalid login attempt.';
        $forwarding='Forwarding...';
        $messageAlertClass='class="alert alert-danger"';
	}
	else if('8'==$messageId)
	{
		$message='Parent and Child sites on link Updated.';
        $forwarding='Forwarding...';
        $messageAlertClass='class="alert alert-success"';
	}
	else if('9'==$messageId)
	{
		$message='Something went wrong. Database NOT Updated.';
        $forwarding='Forwarding...';
        $messageAlertClass='class="alert alert-danger"';
	}
	else if('10'==$messageId)
	{
		$message='Invalid Fault Entry found.';
        $forwarding='Forwarding...';
        $messageAlertClass='class="alert alert-danger"';
	}
	else if('11'==$messageId)
	{
		$message='You need to log in to Admin section to access this page.';
        $forwarding='Forwarding...';
        $messageAlertClass='class="alert alert-warning"';
	}
	else if('12'==$messageId)
	{
		$message='Fault Report updated.';
        $forwarding='Forwarding...';
        $messageAlertClass='class="alert alert-success"';
	}
	else if('13'==$messageId)
	{
		$message='Logging Out.';
        $forwarding='Forwarding...';
        $messageAlertClass='class="alert alert-success"';
	}
	else if('14'==$messageId)
	{
		$message='Access Denied. Please Log In.';
        $forwarding='Forwarding...';
        $messageAlertClass='class="alert alert-danger"';
	}
	else 
	{
		$message='Page Not Found';
	}

	$args_array=array(
		'isLoggedIn' => $isLoggedIn,
		'username' => $firstName.' '.$lastName,
		'navTop' => $navTop,
		'navBottomHome' => $navBottomHome,
		'message' => $message,
		'forwarding' => $forwarding,
        'messageAlertClass' => $messageAlertClass
	);

	$template='messageAlert';
	echo $twig->render($template.'.html.twig',$args_array);
	
	# if request to forward the page came in then message gets displayed and then the page forwards after 2 second delay
	if($forwardTo)
	{
		header('Refresh:2; url=./'.$forwardTo);
	}
}


################################################ TESTING #####################################
function testModal()
{
    global $twig;


    $args_array=array(

    );

    $template='testModal';
    echo $twig->render($template.'.html.twig',$args_array);
}
