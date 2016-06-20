<?php

//----------------------------
//	INCLUDES
//----------------------------
session_start();

# include relevant files
require_once 'phpinc/config.inc.php';
require_once 'phpinc/check_login_status.php';

require_once 'mvc/model.php';
require_once 'mvc/controller.php';
require_once 'mvc/controller_map.php';
require_once 'mvc/controller_admin.php';
require_once 'mvc/controller_fault.php';
require_once 'mvc/controller_bootStrapTest.php';
require_once 'mvc/controller_AJAXTest.php';

require_once 'vendor/setup_twig.php';
require_once 'vendor/Epi/Epi.php';

# autoload classes
function autoLoad($class)
{
	$class_prefix='classes/';
	$class_suffix='.class.php';
	
	require $class_prefix.$class.$class_suffix;
};

spl_autoload_register('autoLoad');

#--------------------------------
# ROUTING LOGIC
#--------------------------------

Epi::INIT('route');

getRoute()->get('/','index');

# map
getRoute()->get('/map','map');
getRoute()->get('/mapReportFault','mapReportFault');
getRoute()->get('/mapDisplay','mapDisplay');
getRoute()->get('/mapFindMobileSites','mapFindMobileSites');
getRoute()->get('/mapFindOffAirSites','mapFindOffAirSites');
getRoute()->get('/mapFindControllers','mapFindControllers');

# fault Reporting
getRoute()->post('/reportFaultEmailCheck','reportFaultEmailCheck');
getRoute()->post('/createReportFault','createReportFault');
getRoute()->get('/findFaultsByEmailForMapMarkers','findFaultsByEmailForMapMarkers');
getRoute()->get('/getFaultIdListLinkedToEmail','getFaultIdListLinkedToEmail');

# admin
getRoute()->get('/admin','admin');
getRoute()->get('/adminReportFault','adminReportFault');
getRoute()->get('/adminReportedFaults','adminReportedFaults');
getRoute()->get('/adminLogin','adminLogin');
getRoute()->post('/adminAuthenticate','adminAuthenticate');
getRoute()->get('/adminSelectRegion','adminSelectRegion');
getRoute()->post('/adminRegionSelected','adminRegionSelected');
getRoute()->get('/adminSites','adminSites');
getRoute()->post('/adminUpdateSite','adminUpdateSite');
getRoute()->get('/adminUpdateFault','adminUpdateFault');
getRoute()->post('/adminUpdateReportFault','adminUpdateReportFault');
getRoute()->get('/adminLogout','adminLogout');

# alerts
getRoute()->get('/messageAlert','messageAlert');

# AJAX calls
getRoute()->get('/retrieveAllSites','retrieveAllSites');
getRoute()->get('/retrieveOffAirSites','retrieveOffAirSites');
getRoute()->get('/retrieveSitesByCounty','retrieveSitesByCounty');
getRoute()->get('/retrieveAdminSites','retrieveAdminSites');

# discrete function to update passwords. Not accessible through Front End
getRoute()->get('/adminUpdateUserPassword','adminUpdateUserPassword');

# test
getRoute()->get('/paginationAjaxTest','paginationAjaxTest');


getRoute()->get('.*','error404');
getRoute()->run();
