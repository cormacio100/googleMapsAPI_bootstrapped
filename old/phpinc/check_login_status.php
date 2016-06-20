<?php

/**
 * Script determines if a user is logged in or not. This will determiner if they  are allowed access to admin section or not
 */

$isLoggedIn = false;
$username = null;

if(isset($_SESSION['username']))
{
	$isLoggedIn = true;
	$username = $_SESSION['username'];
}
